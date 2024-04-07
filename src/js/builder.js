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

    const debounce = (func, wait, immediate) => {
        let timeout;
        return function () {
            const context = this;
            const args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
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
            if( definition.type === 'repeater' ) {
                _populateRepeater( tab );
                return;
            }

            tab.find( `[name="${key}"]` ).val( prop[key] );
        });

        tab.find( 'input, textarea, select, #editor' ).on( 'keyup change input blur mouseup mousedrag',debounce(function(e) {
            var name = $(this).attr( 'name' );
            prop[name] = $( this ).val();
            _preview();
        }, 100));

        tab.on( 'click', '.repeater .repeater-add', function(e) {
            e.preventDefault();
            _populateRepeater( $(this) );
        });
    
        tab.on( 'click', '.repeater-remove', function(e) {
            e.preventDefault();
            $( this ).closest( '.repeater-clone' ).remove();
        });

        $( '#block' ).parent().removeClass( 'd-none' );
        $( '#block' ).click();
    });

    const _renderBlocks = () => {
        var blocks = $( '#blocks' );
        blocks.empty();

        var blockElements = [];

        _props.forEach( function( prop, i ) {
            if ( prop === null ) {
                _props.slice( i, 1 );
                return;
            }
            var blockIndex = blocks.attr( 'index' );
            var definition = _definitions[prop.name];

            if( definition ) {
                var button = $( `<button class="btn-block btn btn-sm btn-outline-secondary w-100 rounded-0 mb-1 d-flex flex-row p-2" data-bs-toggle="tab" type="button" index="${i}">` );
                button.text( definition.name );
                if( blockIndex == i ) button.addClass( 'active' );

                var icon = $( '<ion-icon size="small" class="me-2">' );
                icon.attr( 'name', definition.icon );
                button.prepend( icon );

                button.append( '<span class="flex-fill">' )

                var addBefore = $( '<ion-icon size="small" class="hover-blue block-actions" name="add-outline" data-bs-toggle="tooltip" title="Add block before">' );
                addBefore.on( 'click', function(e) {
                    e.preventDefault();
                    index = i;
                    let myModal = bootstrap.Modal.getOrCreateInstance( '#addModal' ); // new bootstrap.Modal(document.getElementById('addBlock'), {});
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

                blockElements.push( button );
            } else {
                _props.slice( i, 1 );
            }
        });

        
        blocks.on( 'click', '.btn-block', function(e) {
            e.preventDefault();
            $( '#blocks' ).attr( 'index', $( this ).attr( 'index' ) );
            $( this ).trigger( 'tabShown' );
        });

        blocks.append( blockElements );
        
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

        /*$( 'input, select, textarea' ).on( 'keyup change', function(e) {
            _preview();
        });*/

        _renderBlocks();
    });

    const _populateRepeater = (el) => {
        var base = el.parent().find( '.repeater-base' );

        var clone = base.clone();
        clone.removeClass( 'repeater-base' );
        clone.addClass( 'repeater-clone' );
        clone.find( 'input, textarea, select, #editor' ).val( '' );
        base.after( clone );
    }

    return {
        addBlock: _addBlock,
        preview: _preview,
        populateRepeater: _populateRepeater
    }
}