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

        if( definition.type === 'repeater' ) {
            Object.defineProperty(document.querySelector('.repeater'), 'value', {
                get: function() {
                    var data = tab.find('.repeater .repeater-container').map(function(i, o) {
                        var item = {};
                        $(o).find('input, textarea, select').each(function() {
                            var name = $(this).prop('tagName');
                            var value = $(this).val();
                            item[name] = value;
                        });
                        return item;
                    }).get();
                    return data;
                },
                set: function(value) {
                    // Reverse the process based on the get function
                    for (var i = tab.find('.repeater .repeater-container').length; i < value.length; i++) {
                        _populateRepeater( tab.find( '.repeater .repeater-add' ) );
                    }
                    tab.find('.repeater .repeater-container').each(function(i, o) {
                        if (i < value.length) {
                            var item = value[i];
                            $(o).find('input, textarea, select').each(function() {
                                var name = $(this).prop('tagName');
                                if (item[name] !== undefined) {
                                    $(this).val(item[name]);
                                }
                            });
                        } else {
                            // If there are more .repeater elements than values in the data array,
                            // set the values to empty for those extra elements
                            $(o).find('input, textarea, select').val('');
                        }
                    });
                }
            });
        }

        Object.keys( prop ).forEach( function( key, i ) {
            tab.find( `[name="${key}"]` ).val( prop[key] );
        });

        tab.find( 'input, textarea, select, #editor, .repeater' ).on( 'keyup change input blur mouseup mousedrag',debounce(function(e) {
            var name = $(this).attr( 'name' );
            prop[name] = $( this ).val();
            _preview();
        }, 100));

        /**
         * Temporary
         */
        tab.on( 'click', '.repeater .repeater-add', function(e) {
            e.preventDefault();
            _populateRepeater( $(this) );
        });
    
        tab.on( 'click', '.repeater-remove', function(e) {
            e.preventDefault();
            $( this ).closest( '.repeater-container' ).remove();
        });
        // End of temporary

        $( '#block' ).parent().removeClass( 'd-none' );
        $( '#block' ).click();
    });

    const _renderBlocks = () => {
        var blocks = $( '#blocks' );
        blocks.empty();

        //var spacePlaceholder = $( '<div class="space-placeholder"></div>' );

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

                button.append( '<span class="flex-fill">' );

                var originalIndex = null;
                var draggingItem = null;
                var reorder = $( '<ion-icon size="small" class="hove-blue block-actions" name="reorder-three-outline" data-bs-toggle="tooltip" title="Reorder block">' );
                reorder.css( 'cursor', 'grab' );
                reorder.on( 'mousedown', function(e) {
                    e.preventDefault();
                    draggingItem = $( this ).parent();
                    draggingItem.addClass( 'dragging' );
                    //spacePlaceholder.addClass( 'space-dragging' );
                    //draggingItem.before( spacePlaceholder );
                    originalIndex = draggingItem.index();
                    var mouseY = e.clientY - blocks.offset().top;
                    //startDragging( mouseY );
                });

                $( document ).on( 'mousemove', function(e) {
                    var mouseY = e.clientY - blocks.offset().top;
                    if( draggingItem ) {
                        startDragging( mouseY );
                    }
                });

                function startDragging( mouseY ) {
                    blocks.find( 'active' ).removeClass( 'active' );
                    draggingItem.css( 'top', mouseY );
                    var newIndex = Math.floor(mouseY / draggingItem.height());

                    if (newIndex >= 0 && newIndex < blocks.children().length && newIndex !== originalIndex) {
                        //blocks.children().eq(newIndex).before( spacePlaceholder );
                        blocks.children().eq(newIndex).before(draggingItem);
                    }
                }

                $( document ).on( 'mouseup', function(e) {
                    if( draggingItem ) {
                        // Update the _props array to reflect the new order
                        var originalIndex = draggingItem.attr( 'index' );
                        var newIndex = draggingItem.index();
                        console.log( originalIndex, newIndex );
                        var movedProp = _props.splice(originalIndex, 1)[0];
                        _props.splice(newIndex, 0, movedProp);

                        

                        draggingItem.removeClass( 'dragging' );
                        //spacePlaceholder.removeClass( 'space-dragging' );
                        draggingItem = null;

                        _renderBlocks();
                    }
                });

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

                button.append( reorder );
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
        blocks.append( '<div class="invisible">' );
        
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
        var base = el.parent().find( '.repeater-container' ).first();

        var clone = base.clone();
        //clone.removeClass( 'repeater-container' );
        //clone.addClass( 'repeater-clone' );
        clone.find( 'input, textarea, select, #editor' ).val( '' );
        el.parent().find( '.repeater-container' ).last().after( clone );
    }

    return {
        addBlock: _addBlock,
        preview: _preview,
        populateRepeater: _populateRepeater
    }
}