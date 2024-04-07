<?php

namespace simpl\components;

class SelectableGrid extends Grid {

    public function render( $action_col, $create_url = '', $actions = [] ) {
        $table = $this->table;
        $items = $this->items;
        $columns = $this->columns;
        ?>
            <?php if( !$items->isEmpty() ): ?>
                <div class="container-fluid">
                    <div class="row p-2 border mb-2">
                        <?php foreach( $items as $item ): ?>
                            <input type="radio" class="btn-check" name="media" id="media|<?= $item->ID ?>" autocomplete="off" value="media|<?= $item->ID ?>" <?php foreach( $columns as $key => $column ) { echo $key . '="' . $item->$key . '"'; } ?>>
                            <label class="btn p-2 col-lg-2 col-md-3"  for="media|<?= $item->ID ?>">
                                <div class="mb-1 ratio ratio-1x1 rounded border overflow-hidden">
                                    <img src="<?= ROOT . $item->thumb ?>" class="img-fluid object-fit-cover">
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column border border-5 justify-content-center align-items-center mb-3" style="min-height: 50vh">
                    <h2>No items</h2>
                </div>
            <?php endif; ?>
        <?php
    }

}