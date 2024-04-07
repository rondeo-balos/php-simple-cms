;
/**
 * Fancy dropdown
 */

const _generateDatalist = ( el ) => {
    el.next( 'dlist' ).remove();
    var table = el.attr( 'list' );
    var column = el.attr('display');
    __quickFetch( `${window.location.origin}/admin/quick`, {
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
        el.trigger( 'input' );
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
        
        /*datalist.find( 'option' ).each( function(){
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
        }*/
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

$( document ).on( 'click', '[list]', function(e) {
    _generateDatalist( $(this) );
});

$( document ).on( 'click', '[show="media"]', function(e) {

    let myModal = bootstrap.Modal.getOrCreateInstance( '#getMedia' );
    myModal.show();

    $( '#getMedia #selectMedia' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#getMedia' ).find( 'iframe' )[0].contentWindow.postMessage( 'getMedia', '*' );
    });

    var media = $( this );
    window.onmessage = function(e) {
        if( typeof e.data.media !== 'undefined' ) {
            media.val( e.data.media ).trigger( 'change' );
            media.next( '.media-preview' ).remove();
            media.after( `<img class="media-preview img-thumbnail" src="${window.location.origin + '/' + e.data.thumb}">` );
        }
    }
});