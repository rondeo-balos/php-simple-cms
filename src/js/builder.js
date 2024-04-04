;
const _initBuilder = ( root, _definitions, _props ) => {
    let index = -1;

    const _addBlock = ( name ) => {
        let newProps = JSON.parse(JSON.stringify(_definitions[name].props));
        if( index < 0 ) {
            _props.push( newProps );
        } else {
            _props.splice( index, 0, newProps );
            $( '#blocks' ).attr( 'index', index + 1 );
        }
        index = -1;
        _renderBlocks();
    }

    const _generateDatalist = ( el ) => {
        var table = el.attr( 'list' );
        var column = el.attr('display');
        __quickFetch( `${root}admin/quick`, {
            table: table,
            columns: [column]
        },
        res => {
            var datalist = $( `<dlist id="${table}">` );
            res.data.forEach( function( option, i ) {
                var option = $( '<option value="' + option.key + '">' + option[column] + '</option>' );
                datalist.append( option );
            });
            el.after( datalist );
            _fancyDropdown( el );
        });
    }

    const _fancyDropdown = ( el ) => {
        var datalist = el.next( 'dlist' );
        var minWidth = datalist.width();

        function outputSize() {
            if( el.width() < minWidth ) {
                datalist.css( 'min-width', `${el.width()}px` );
            } else {
                datalist.css( 'width', `${el.width()}px` );
            }
        }

        new ResizeObserver( outputSize ).observe( el[0] );

        el.on( 'input', function(e) {
            datalist.css( 'display', 'block' );
            var text = $( this ).val().toUpperCase();
            var hide = 1;
            
            datalist.find( 'option' ).each( function(){
                var option = $(this);
                if( option.val().toUpperCase().indexOf( text ) > -1 ) {
                    option.css( 'display', 'block' );
                    hide = 0;
                } else {
                    option.css( 'display', 'none' );
                }
            });
            
            if( hide ) {
                datalist.css( 'display', 'none' );
            }
        });

        el.on( 'click', function(e) {
            var hide = 1;
            datalist.find( 'option' ).each( function() {
                var option = $(this);
                if( option.css( 'display' ) === 'block' ) {
                    hide = 0;
                    //return false; // exit loop early
                }
            });

            if( datalist.css( 'display' ) === 'block' || hide === 1 ) {
                datalist.css( 'display', 'none' );
            } else {
                datalist.css( 'display', 'block' );
            }
        });

        $( document ).on( 'click', function(e) {
            if( $(e.target).is('option') ) {
                el.val( $(e.target).val() ).trigger( 'change' );
            }
            if( !$(e.target).is( 'dlist' ) && !$(e.target).is( 'input' ) ) {
                datalist.css( 'display', 'none' );
            }
        });

        datalist.css( 'display', 'none' );
    }

    $( document ).on( 'tabShown', '#blocks [data-bs-toggle="tab"]', function(e) {
        var index = $( '#blocks' ).attr( 'index' );

        if( index < 0 ) {
            alert();
            $( '#block' ).parent().addClass( 'd-none' );
            return;
        }

        var prop = _props[index];
        var definition = _definitions[prop.name];

        let tab = $( '#block-tab' );
        tab.empty();
        
        tab.html( he.decode(definition.settings) );
        Object.keys( prop ).forEach( function( key ) {
            tab.find( `[name="${key}"]` ).val( prop[key] );
        });

        tab.find( 'input, textarea, select' ).on( 'keyup change', function(e) {
            prop[ $(this).attr( 'name' ) ] = $( this ).val();
            _preview();
        });

        tab.find( '[list]' ).each( function(e) {
            _generateDatalist( $(this) );
        });

        $( '#block' ).parent().removeClass( 'd-none' );
        $( '#block' ).click();
    });

    const _renderBlocks = () => {
        var blocks = $( '#blocks' );
        blocks.empty();
        _props.forEach( function( prop, i ) {
            if ( prop === null ) {
                _props.slice( i, 1 );
                return;
            }
            var blockIndex = blocks.attr( 'index' );
            var definition = _definitions[prop.name];

            if( definition ) {
                var button = $( '<button class="btn-block btn btn-sm btn-outline-secondary w-100 rounded-0 mb-1 d-flex flex-row p-2" data-bs-toggle="tab" type="button">' );
                button.text( definition.name );
                if( blockIndex == i ) button.addClass( 'active' );
                button.on( 'click', function(e) {
                    e.preventDefault();
                    $( '#blocks' ).attr( 'index', i );
                    $( this ).trigger( 'tabShown' );
                });

                var icon = $( '<ion-icon size="small" class="me-2">' );
                icon.attr( 'name', definition.icon );
                button.prepend( icon );

                button.append( '<span class="flex-fill">' )

                var addBefore = $( '<ion-icon size="small" class="hover-blue block-actions" name="add-outline" data-bs-toggle="tooltip" title="Add block before">' );
                addBefore.on( 'click', function(e) {
                    e.preventDefault();
                    index = i;
                    let myModal = new bootstrap.Modal(document.getElementById('addBlock'), {});
                    myModal.show();
                });
                var deleteBlock = $( '<ion-icon size="small" class="hover-red block-actions" name="trash-outline" data-bs-toggle="tooltip" title="Delete block">' );
                deleteBlock.on( 'click', function(e) {
                    e.preventDefault();
                    _props.splice( i, 1 );
                    _renderBlocks();
                });

                button.append( addBefore );
                button.append( deleteBlock );

                blocks.append( button );
            } else {
                _props.slice( i, 1 );
            }
        });
        
        _preview();
    }

    const _preview = () => {
        $( '[name="blocks"]' ).val( JSON.stringify( _props ) );
        $.ajax({
            url: `${root}admin/pages/preview`,
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                console.log( res );
                if( res.code === 200 ) {
                    $( '[name="token"]' ).val( res.data.token );
                    _reload( res.data.token );
                } else {
                    __alert( '#alert', res.message );
                }
            },
            error: (xhr, status, error) => {
                    try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
            }
        });
    }

    const _reload = ( token ) => {
        $( '#preview_blank' ).attr( 'href', `${root}?__p=${token}` );
        // Get the iframe element
        var iframe = document.getElementById('preview_iframe');

        // Create a new document for the iframe
        var iframeDocument = iframe.contentWindow.document;

        // Make an AJAX request using Zepto
        $.ajax({
            url: `${root}?__p=${token}`,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                // When the request is successful, load the content into the iframe
                iframeDocument.open();
                iframeDocument.write(data);
                iframeDocument.close();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching content:', error);
            }
        });
        //$( 'iframe' ).attr( 'src',  );
    }

    $( document ).ready( function(){
        $( '#_title' ).on( 'keyup change', function(e) {
            $( '#title' ).val( $( this ).val() );
        });
        $( '#title' ).on( 'keyup change', function(e) {
            $( '#_title' ).val( $( this ).val() );
        });

        $( 'input, select, textarea' ).on( 'keyup change', function(e) {
            _preview();
        });

        _renderBlocks();
    });

    return {
        addBlock: _addBlock
    }
}