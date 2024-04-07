
<?php

use simpl\includes\Db;
use simpl\model\Media;
use simpl\components\SelectableGrid;

defined( 'ABSPATH' ) || exit;

Db::createInstance();
$builder = Media::query();
if( isset( $get['s'] ) ) {
    $searchTerm = '%' . ($get['s'] ?? '') . '%';
    $builder = $builder->where( 'filepath', 'like', $searchTerm )
        ->orWhere( 'title', 'like', $searchTerm )
        ->orWhere( 'alt', 'like', $searchTerm );
}
$builder = $builder->orderByDesc( 'created_at' );
if( isset( $get['column'] ) && isset( $get['operator'] ) && isset( $get['value'] ) ) {
    foreach( $get['column'] as $key => $column ) {
        $builder = $builder->where( $column, $get['operator'][$key], $get['value'][$key] );
    }
}
$media = $builder->paginate(
    $perPage = 12,
    $columns = ['*'],
    $pageName = 'page',
    $page = $get['page'] ?? 1
);
$base = ROOT . 'admin/media';
$media->withPath( $base );
$cols = [
    'ID' => ['ID', ''], // this is normal
    'title' => ['Title', ''], // normal
    'alt' => ['Alt Text', ''], // normal
    'type' => [ 'Type', ['File', 'Folder']], // File or Folder
    'filepath' => ['Filepath', ''], // normal
    'created_at' => ['Created At', 'date'], // formatted
    'updated_at' => ['Updated At', 'date'], // formatted
];
$table = new SelectableGrid( 'Media', $media, $cols );
$table->filter( 'media');
$table->render( 'title');
$table->paginate();
?>
<style>
    body {
        overflow: hidden;
    }
</style>
<script>
    window.onmessage = function(e) {
        if( e.data == 'getMedia' ) {
            window.top.postMessage( { media: $( '[name="media"]:checked' ).val(), thumb: $( '[name="media"]:checked' ).attr( 'filepath' ) }, '*' );
        }
    }
</script>