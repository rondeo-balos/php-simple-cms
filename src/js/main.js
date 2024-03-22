const spin = e => {
    var div = $( '<div class="spinner-border spinner-border-sm" role="status">' );
    div.append( '<span class="visually-hidden">Loading...</span>' );
    $( e ).html( div );
}

const unspin = e => {
    var text = $(e).attr( 'text' );
    $( e ).html( text );
}

const __alert = (e, txt, cls = 'danger') => {
    var div = $( `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">` );
    div.append( txt );
    div.append( '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' );

    $( e ).html( div );
}

// Small modal


$( document ).ready( () => {
    const __modal = ( message, link ) => {
        let alertModal = $( '#alertModal' );
        alertModal.find( '.modal-body' ).html( message );
        alertModal.find( '#alertConfirm' ).attr( 'href', link );
    
        let modal = new bootstrap.Modal( document.getElementById( 'alertModal' ) );
        modal.show();
    }

    $( '[href*="delete"]' ).click( function(e) {
        e.preventDefault();

        __modal( 'Confirm deletion', $(this).attr( 'href' ) );
    });
});

//const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
//const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });