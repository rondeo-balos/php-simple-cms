<?php
use simpl\includes\Db;
use simpl\includes\FlashSession;
use simpl\model\Page;
use simpl\model\Preview;

defined( 'ABSPATH' ) || exit;

if( isset($ID) ) {
    Db::createInstance();
    try {
        $page = Page::findOrFail( $ID );
        $blocks = $page->blocks;

        $preview = Preview::where( 'token', '=', $page->token )->first();
        if( $preview ) {
            $data = json_decode( $preview->data );
            $blocks = $data->blocks;
        }

        $update_text = 'Update Page';
        $update_url = 'admin/pages/edit/'.$ID;
        $url = __ROOT__ . $page->path;
        $public_url = '<label>Public URL</label><br><a target="_blank" title="Opens in new tab" href="'. $url . '">' . $url . '</a>';
    } catch( \Exception $e ) {

    }
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/he/1.2.0/he.min.js"></script>
<script>
    const _definitions = <?= json_encode( $blockManager->definitions ) ?>;
    let _props = <?= $blocks ?? '[]' ?>;
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

        /*Object.keys(definition.fields).forEach( function( key ) {
            var field = definition.fields[key];
            
            var label = $( '<label class="form-label text-capitalize">' );
            label.text( key );

            var f = null;
            if( Array.isArray( field ) ) {
                f = $( '<select class="form-select mb-2">' );
                field.forEach( function( option, i ) {
                    var option = $( '<option>' + option + '</option>' );
                    f.append( option );
                });
            } else if( field.includes( 'select:' ) ) {
                f = $( '<select class="form-select mb-2 form-select-sm">' );
                console.log( field.split( ':' )[1] );
                __quickFetch( 'http://localhost/admin/quick', {
                    table: field.split( ':' )[1],
                    columns: [ 'title', 'path' ] 
                },
                res => {
                    res.data.forEach( function( option, i ) {
                        var option = $( '<option value="' + option.key + '">' + option.title + '</option>' );
                        f.append( option );
                    });
                });
            } else if( field.includes( 'datalist:' ) ) {
                f = $( '<input class="form-control mb-2 form-control-sm" list="option_' + field + '" id="' + field + '" placeholder="Type to search..." value="' + prop[key] + '">' );
                var flist = $( '<datalist id="option_' + field + '">' );
                console.log( field.split( ':' )[1] );
                __quickFetch( 'http://localhost/admin/quick', {
                    table: field.split( ':' )[1],
                    columns: [ 'title' ] 
                },
                res => {
                    res.data.forEach( function( option, i ) {
                        var option = $( '<option value="' + option.key + '">' + option.title + '</option>' );
                        flist.append( option );
                    });
                });
                f.append( flist );
            } else if( field === 'textarea' ) {
                f = $( '<textarea class="form-control mb-2 form-control-sm">' + prop[key] + '</textarea>' );
            } else {
                f = $( '<input class="form-control mb-2 form-control-sm" type="' + field + '" value="' + prop[key] + '">' );
            }
            
            f.on( 'keyup change', function(e) {
                prop[key] = $( this ).val();
                _preview();
            });

            tab.append( label );
            tab.append( f );
        });*/

        $( '#block' ).parent().removeClass( 'd-none' );
        $( '#block' ).click();
    });

    const _renderBlocks = () => {
        var blocks = $( '#blocks' );
        blocks.empty();
        _props.forEach( function( prop, i ) {
            var blockIndex = blocks.attr( 'index' );
            var definition = _definitions[prop.name];
            
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
        });
        
        _preview();
    }

    const _preview = () => {
        $( '[name="blocks"]' ).val( JSON.stringify( _props ) );
        $.ajax({
            url: '<?= ROOT ?>admin/pages/preview',
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
        $( '#preview_blank' ).attr( 'href', '<?= ROOT ?>?__p=' + token );
        // Get the iframe element
        var iframe = document.getElementById('preview_iframe');

        // Create a new document for the iframe
        var iframeDocument = iframe.contentWindow.document;

        // Make an AJAX request using Zepto
        $.ajax({
            url: '<?= ROOT ?>?__p=' + token,
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
        $( '#_title' ).on( 'keyup', function(e) {
            $( '#title' ).val( $( this ).val() );
        });
        $( '#title' ).on( 'keyup', function(e) {
            $( '#_title' ).val( $( this ).val() );
        });

        _renderBlocks();
    });
</script>

<div class="modal fade modal-lg" id="addBlock" tabindex="-1" aria-labelledby="Add Block" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0">
                <h2 class="h6 mb-0 p-2 ps-3">Add block</h2>
                <div class="p-2 border-start rounded-0 ms-auto">
                    <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-2 px-3">
                <div class="row">
                    <?php foreach( $blockManager->definitions as $name => $definition ): ?>
                        <div class="col-md-2 p-2">
                            <div class="w-100 ratio ratio-1x1">
                                <button data-bs-dismiss="modal" class="border-rounded btn btn-outline-secondary d-flex justify-content-center align-items-center w-100 flex-column" onclick="javascript:_addBlock( '<?= $definition['name'] ?>' )">
                                    <div>
                                        <ion-icon name="<?= $definition['icon'] ?>" size="small"></ion-icon>
                                        <p><?= $definition['name'] ?></p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="alert"></div>

<form method="POST">
    <input type="hidden" name="token" value="<?= $page->token ?? '' ?>">
    <input type="hidden" name="blocks" value="<?= htmlentities($blocks) ?? '' ?>">
    <div class="row">

        <div class="col-md-2">
            <strong>Blocks</strong>
            <div class="nav flex-column nav-pills me-3 py-2" id="blocks" role="tablist" aria-orientation="vertical"> </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#addBlock" class="text-decoration-none"><ion-icon name="add-outline"></ion-icon> Add block </a>
        </div>
        
        <div class="col-md-8">
            <div class="d-flex flex-row align-items-center justify-content-center mb-3">
                <a href="<?= ROOT ?>admin/pages" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="tooltip" title="All pages"><ion-icon name="chevron-back" size="small"></ion-icon></a>

                <input type="text" name="_title" id="_title" class="h5 border-0 p-2 m-0 focus-ring flex-fill" value="<?= $page->title ?? '' ?>" placeholder="Page Title" style="background: none; --bs-focus-ring-color: rgba(0, 0, 0, 0)" required>

                <h1 class="h5 m-0"></h1>
                <div class="flex-fill"></div>
                <a href="#" id="preview_blank" class="me-3 btn btn-outline-secondary btn-sm" target="_blank">
                    <ion-icon name="open-outline" data-bs-toggle="tooltip" title="Open preview in new tab"></ion-icon>
                </a>
                <button type="button" class="me-3 btn btn-outline-secondary btn-sm">
                    <ion-icon name="refresh-outline" data-bs-toggle="tooltip" title="Reload preview"></ion-icon>
                </button>
                <button type="submit" role="submit" class="btn btn-primary btn-sm" id="create" text="<?= $update_text ?? 'Publish' ?>"><?= $update_text ?? 'Publish' ?></button>
            </div>

            <div id="preview" class="border" style="height: 80vh">
                <iframe id="preview_iframe" src="<?= ROOT ?>" style="width: 100%; height: 100%"></iframe>
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="h-100 border bg-body">
                <ul class="nav nav-tabs justify-content-end mt-2 px-2" id="settings" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="page" data-bs-toggle="tab" data-bs-target="#page-tab" type="button" role="tab" aria-controls="page-tab" aria-selected="true">Page</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo" data-bs-toggle="tab" data-bs-target="#seo-tab" type="button" role="tab" aria-controls="seo-tab" aria-selected="true">SEO</button>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <button class="nav-link" id="block" data-bs-toggle="tab" data-bs-target="#block-tab" type="button" role="tab" aria-controls="block-tab" aria-selected="true">Block</button>
                    </li>
                </ul>
                <div class="tab-content px-3 py-4" id="tabContent">
                    <div class="tab-pane fade show active" id="page-tab" role="tabpanel" aria-labelledby="page" tabindex="0">

                        <div class="form-group mb-2">
                            <label class="form-label">
                                Status 
                                <span class="" data-bs-toggle="tooltip" title="Whether the page is publicly accessible">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label><br>
                            <div class="btn-group" role="group" aria-label="Status">
                                <input type="radio" class="btn-check" name="status" id="draft" value="0" autocomplete="off" <?= isset($page) ? ($page->status == 0 ? 'checked' : '') : '' ?> required>
                                <label class="btn btn-outline-primary btn-sm" for="draft">Draft</label>

                                <input type="radio" class="btn-check" name="status" id="public" value="1" autocomplete="off" <?= isset($page) ? ($page->status == 1 ? 'checked' : '') : 'checked' ?> required>
                                <label class="btn btn-outline-primary btn-sm" for="public">Public</label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="path" class="form-label">
                                URL Path <span class="text-danger">*</span>
                                <span class="" data-bs-toggle="tooltip" title="Unique URL path of the page. The path always begins with a slash ('/') and never ends with one (e.g., '/about')">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <input type="text" name="path" id="path" class="form-control form-control-sm" autocomplete="off" value="<?= $page->path ?? '/' ?>" required>
                        </div>
                        <div class="mb-2"><?= $public_url ?? '' ?></div>

                    </div>
                    <div class="tab-pane fade" id="seo-tab" role="tabpanel" aria-labelledby="seo" tabindex="0">
                        <div class="form-group mb-2">
                            <label for="title" class="form-label">
                                Page title 
                                <span class="" data-bs-toggle="tooltip" title="Defines the document's title that is shown in a browser's title bar or a page's tab. Search engines typically display about the first 55-60 characters of a page title. Text beyond that may be lost, so try not to have titles longer than that. If you must use a longer title, make sure the important parts come earlier and that nothing critical is in the part of the title that is likely to be dropped.">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm" autocomplete="off" value="<?= $page->title ?? '' ?>">
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="form-label">
                                Page description 
                                <span class="" data-bs-toggle="tooltip" title="Document description">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label>
                            <textarea name="description" id="description" class="form-control form-control-sm" autocomplete="off"><?= $page->description ?? '' ?></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">
                                Search engine visibility 
                                <span class="" data-bs-toggle="tooltip" title="test">
                                    <ion-icon name="help-circle-outline"></ion-icon>
                                </span>
                            </label><br>
                            <div class="btn-group" role="group" aria-label="Visibility">
                                <input type="radio" class="btn-check" name="visibility" id="hidden" value="noindex" autocomplete="off" <?= isset($page) ? ($page->visibility == 'noindex' ? 'checked' : '') : 'checked' ?>>
                                <label class="btn btn-outline-primary btn-sm" for="hidden">Hidden</label>

                                <input type="radio" class="btn-check" name="visibility" id="visible" value="index" autocomplete="off" <?= isset($page) ? ($page->visibility == 'index' ? 'checked' : '') : '' ?>>
                                <label class="btn btn-outline-primary btn-sm" for="visible">Visible</label>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="block-tab" role="tabpanel" aria-labelledby="block" tabindex="0">
                        ...
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
.admin-sidebar {
    display: none;
}

#blocks button .block-actions {
    opacity: 0;
}
#blocks button:hover .block-actions {
    opacity: 1;
}
</style>

<script>
    $( 'form' ).on( 'submit', e => {
        e.preventDefault();
        spin( '#create' );

        $.ajax({
            url: '<?= ROOT ?><?= $update_url ?? 'admin/pages/create' ?>',
            type: 'POST',
            dataType: 'json',
            data: $( 'form' ).serialize(),
            success: res => {
                console.log( res );
                if( res.code === 200 ) {
                    __alert( '#alert', res.message, 'success' );
                    if( typeof res.data.redirect !== 'undefined' ) {
                        document.location = res.data.redirect;
                    }
                } else {
                    __alert( '#alert', res.message );
                }

                unspin( '#create' );
            },
            error: (xhr, status, error) => {
                try{ __alert( '#alert', JSON.parse(xhr.responseText).message ); } catch(e) {}
                unspin( '#create' );
            }
        } );

        return false;
    } );
    <?php if( FlashSession::hasKey( 'message' ) ): ?>
        __alert( '#alert', '<?= FlashSession::get( 'message' ) ?>', 'info' );
    <?php endif; ?>
</script>