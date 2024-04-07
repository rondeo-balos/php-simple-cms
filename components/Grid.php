<?php

namespace simpl\components;

class Grid extends Table {

    public function render( $action_col, $create_url = '', $actions = [] ) {
        $table = $this->table;
        $items = $this->items;
        $columns = $this->columns;
        ?>
            <?php if( !$items->isEmpty() ): ?>
                <div class="row p-2 border mb-2">
                    <?php foreach( $items as $item ): ?>
                        <div class="p-2 col-lg-2 col-md-3" <?php foreach( $columns as $key => $column ) { echo $key . '="' . $item->$key . '"'; } ?>>
                            <div class="mb-1 ratio ratio-1x1 rounded border overflow-hidden" >
                                <img src="<?= ROOT . $item->thumb ?>" class="img-fluid object-fit-cover">
                                <div class="hover position-absolute d-flex flex-wrap justify-content-center align-items-center bg-body-secondary bg-opacity-75">
                                    <?php foreach( $actions as $action ): ?>
                                        <a href="<?= $this->replacePlaceholders($action['url'] ?? '', $item) ?>" target="#<?= $item->ID ?>" class="m-1 btn btn-sm <?= $action['class'] ?? '' ?>"><?= $action['label'] ?? '' ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <small class="d-block text-center"><?= (strlen($item->title) > 12) ? (substr( $item->title, 0, 12 ) . '...') : $item->title ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column border border-5 justify-content-center align-items-center mb-3" style="min-height: 50vh">
                    <h2>No items</h2>
                    <p class="text-center">
                        It seems that this colllection doesn't have items.<br> 
                        Go ahead and add a new item!
                    </p>
                    <a href="<?= $create_url ?>" class="btn btn-primary btn-sm">Add <?= $table ?></a>
                </div>
            <?php endif; ?>
        <?php
    }

    public function filter( $base, $create_url = '' ) {
        $table = $this->table;
        $items = $this->items;
        $columns = $this->columns;
        ?>
            <div class="d-flex flex-row justify-content-between align-items-center mb-4">

                <div style="max-width: 400px;">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Search <?= $table ?>s" aria-label="Search <?= $table ?>" aria-describedby="search-button" name="s" value="<?= $_GET['s'] ?? '' ?>">
                            <button type="submit" role="submit" class="btn btn-outline-secondary btn-sm" aria-labelledby="Search button"><ion-icon name="search"></ion-icon></button>
                        </div>
                    </form>
                </div>

                <div class="d-flex flex-row align-items-center">
                    <a href="#" class="me-3 btn btn-outline-secondary btn-sm <?= isset( $_GET['column'] ) ? 'border border-2 border-primary': ''; ?>" data-bs-toggle="modal" data-bs-target="#filter">
                        <ion-icon name="funnel" data-bs-toggle="tooltip" title="Filter <?= $table ?>s"></ion-icon>
                    </a>
                    <?php if( strlen( $create_url ) > 0 ): ?>
                        <a href="<?= $create_url ?>" class="btn btn-primary btn-sm">Add <?= $table ?></a>
                    <?php endif; ?>
                </div>

                <div class="modal fade modal-lg" id="filter" tabindex="-1" aria-labelledby="Filter <?= $table ?>s" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="filterForm">
                                <div class="modal-header p-0">
                                    <h2 class="h6 mb-0 p-2 ps-3">Filter <?= $table ?>s</h2>
                                    <div class="p-2 border-start rounded-0 ms-auto">
                                        <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body p-2">
                                    <div id="filters"></div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="addFilter">Add Filter</button>
                                </div>
                                <div class="modal-footer p-2">
                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm" id="applyFilter" text="Apply" data-bs-dismiss="modal">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    // Function to prefill filter values from $_GET parameters
                    const prefillFilterValues = () => {
                        let filters = <?= json_encode($_GET['column'] ?? [], JSON_HEX_TAG); ?>;
                        let operators = <?= json_encode($_GET['operator'] ?? [], JSON_HEX_TAG); ?>;
                        let values = <?= json_encode($_GET['value'] ?? [], JSON_HEX_TAG); ?>;

                        for (let i = 0; i < filters.length; i++) {
                            addFilterField();
                            let filter = $('#filters .row').eq(i);

                            filter.find('[name="column[]"]').val(filters[i]).change();
                            filter.find('[name="operator[]"]').val(operators[i]);
                            var value = filter.find('[name="value[]"]');
                            if( value.hasClass( 'btn-check' ) ) filter.find( '[name="value[]"][value="' + values[i] + '"]' ).prop( 'checked', 'yes' );
                            else value.val(values[i]);
                        }
                    };

                    const addFilterField = () => {
                        let filter = $( '<div class="row g-3 align-items-center mb-2">' );

                        let removeBtn = $( '<button type="button" class="btn btn-outline-secondary btn-sm"><ion-icon name="trash-outline" size="small"></ion-icon></button>' );
                        let column = $( '<select class="form-select form-select-sm" name="column[]">' );
                        <?php foreach( $columns as $key => $column ): ?>
                            column.append( '<option value="<?= $key ?>"><?= $column[0] ?></option>' );
                        <?php endforeach; ?>

                        let operator = $( '<select class="form-select form-select-sm" name="operator[]">' );
                        operator.append( '<option value="=">Equal</option>' );
                        operator.append( '<option value="<>">Not Equal</option>' );

                        let value = $( '<input type="text" class="form-control form-control-sm" name="value[]">' );

                        let wrapDel = $( '<div class="col-auto">' );
                        wrapDel.append( removeBtn );
                        filter.append( wrapDel );
                        
                        let wrapCol = $( '<div class="col-auto">' );
                        wrapCol.append( column );
                        filter.append( wrapCol );
                        
                        var wrapOp = $( '<div class="col-auto">' );
                        wrapOp.append( operator );
                        filter.append( wrapOp );
                        
                        var wrapVal = $( '<div class="col-auto">' );
                        wrapVal.append( value );
                        filter.append( wrapVal );

                        removeBtn.on( 'click', function(e) {
                            e.preventDefault();
                            filter.remove();
                        });

                        let config = <?= json_encode( $columns ) ?>;

                        column.on( 'change', function(e) {
                            const selectedFormat = config[ $(this).val() ][1];
                            if( Array.isArray(selectedFormat) ) {
                                operator = $( '<select class="form-select form-select-sm" name="operator[]">' );
                                        operator.append( '<option value="=">Equal</option>' );
                                        operator.append( '<option value="<>">Not Equal</option>' );
                                        wrapOp.html( operator );

                                        value = $( '<div class="btn-group" role="group" aria-label="Yes, No">' );
                                        value.append( '<input type="radio" class="btn-check" name="value[]" value="1" id="value_1" autocomplete="off" checked>' );
                                        value.append( '<label class="btn btn-outline-primary btn-sm" for="value_1">' + selectedFormat[1] + '</label>' );

                                        value.append( '<input type="radio" class="btn-check" name="value[]" value="0" id="value_0" autocomplete="off">' );
                                        value.append( '<label class="btn btn-outline-primary btn-sm" for="value_0">' + selectedFormat[0] + '</label>' );
                                        wrapVal.html( value );
                            } else{
                                switch( selectedFormat ) {
                                    case 'bool':
                                        operator = $( '<select class="form-select form-select-sm" name="operator[]">' );
                                        operator.append( '<option value="=">Equal</option>' );
                                        operator.append( '<option value="<>">Not Equal</option>' );
                                        wrapOp.html( operator );

                                        value = $( '<div class="btn-group" role="group" aria-label="Yes, No">' );
                                        value.append( '<input type="radio" class="btn-check" name="value[]" value="1" id="value_1" autocomplete="off" checked>' );
                                        value.append( '<label class="btn btn-outline-primary btn-sm" for="value_1">Yes</label>' );

                                        value.append( '<input type="radio" class="btn-check" name="value[]" value="0" id="value_0" autocomplete="off">' );
                                        value.append( '<label class="btn btn-outline-primary btn-sm" for="value_0">No</label>' );
                                        wrapVal.html( value );
                                        break;
                                    case 'date':
                                        operator = $( '<select class="form-select form-select-sm" name="operator[]">' );
                                        operator.append('<option value="=">Equal</option>');
                                        operator.append('<option value="<">Less Than</option>');
                                        operator.append('<option value="<=">Less Than or Equal</option>');
                                        operator.append('<option value=">">Greater Than</option>');
                                        operator.append('<option value=">=">Greater Than or Equal</option>');
                                        operator.append('<option value="<>">Not Equal</option>');
                                        wrapOp.html( operator );

                                        value = $( '<input type="datetime-local" class="form-control form-control-sm" name="value[]">' );
                                        wrapVal.html( value );
                                        break;
                                    default:
                                        operator = $( '<select class="form-select form-select-sm" name="operator[]">' );
                                        operator.append( '<option value="=">Equal</option>' );
                                        operator.append( '<option value="<>">Not Equal</option>' );
                                        wrapOp.html( operator );

                                        value = $( '<input type="text" class="form-control form-control-sm" name="value[]">' );
                                        wrapVal.html( value );
                                }
                            }
                        });

                        $( '#filters' ).append( filter );
                    }
                    
                    $( '#addFilter' ).on( 'click', e => {
                        e.preventDefault();
                        addFilterField();
                    });

                    prefillFilterValues();
                </script>
            </div>
        <?php
    }

}