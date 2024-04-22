<?php

namespace simpl\components;

class Table {
    protected $table;
    protected $items;
    protected $columns;

    public function __construct( $table, $items, $columns ) {
        $this->table = $table;
        $this->items = $items;
        $this->columns = $columns;
    }

    /**
     * $actions = [
     *      'edit' => [
     *          'url' => '',
     *          'class' => '',
     *          'label' => ''
     *      ]
     * ];
     */
    public function render( $action_col, $create_url = '', $actions = [] ) {
        $table = $this->table;
        $items = $this->items;
        $columns = $this->columns;
        ?>
            <?php if( !$items->isEmpty() ): ?>
            <div class="rounded border overflow-hidden bg-white mb-3">
                <table class="table table-hover" style="margin-bottom: -1px;">
                    <tr>
                        
                        <?php foreach( $columns as $key => $column ): ?>
                            <th class="p-3 <?= $key ?>"><?= $column[0] ?></th>
                        <?php endforeach; ?>

                    </tr>
                    <?php foreach( $items as $item ): ?>
                        <tr>

                            <?php foreach( $columns as $key => $column ): ?>
                                <td class="p-3 align-middle <?= $key ?>">
                                    <b><?= $this->formatValue( $key, $item->$key ) ?></b>

                                    <?php if( $key === $action_col ): ?>
                                        <div class="d-block text-sm">
                                            <?php foreach( $actions as $action ): ?>
                                                <a href="<?= $this->replacePlaceholders($action['url'] ?? '', $item) /*($action['url'] ?? '') . '/' . $item->ID*/ ?>" class="pe-2 <?= $action['class'] ?? '' ?>"><small><?= $action['label'] ?? '' ?></small></a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </td>
                            <?php endforeach; ?>

                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column border border-5 justify-content-center align-items-center mb-3" style="min-height: 50vh">
                <h2>No items</h2>
                <p class="text-center">
                    It seems that this colllection doesn't have items.<br> 
                    Go ahead and add a new item!
                </p>
                <a href="<?= $create_url ?>" class="btn btn-primary btn-sm" id="create">Add <?= $table ?></a>
            </div>
        <?php endif; ?>
        <script>
            
        </script>
        <?php
    }

    protected function replacePlaceholders( $string, $variables ) {
        $callback = function($matches) use ($variables) {
            $placeholder = $matches[1];
            return isset($variables[$placeholder]) ? $variables[$placeholder] : $matches[0];
        };
    
        $pattern = '/{{(.*?)}}/';
        return preg_replace_callback($pattern, $callback, $string);
    }

    public function paginate() {
        $table = $this->table;
        $items = $this->items;
        $columns = $this->columns;
        ?>
            <div class="d-flex justify-content-between">
                <div>
                    <?php
                        $perPage = $items->perPage();
                        $totalItems = $items->total();
                        $start = ($items->currentPage() - 1) * $perPage + 1;
                        $start = $items->isEmpty() ? 0 : $start;
                        $end = min($start + $perPage - 1, $totalItems);
                
                        echo "Showing $start to $end $table(s)";
                    ?>
                </div>
                <div>
                    <?php if ($items->hasPages()): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                                <?php if ($items->onFirstPage()): ?>
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="<?= $items->previousPageUrl() ?>">Previous</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $items->lastPage(); $i++): ?>
                                    <li class="page-item <?= ($i === $items->currentPage()) ? 'active' : '' ?>"><a class="page-link" href="<?= $items->url($i) ?>"><?= $i ?></a></li>
                                <?php endfor; ?>

                                <?php if ($items->hasMorePages()): ?>
                                    <li class="page-item"><a class="page-link" href="<?= $items->nextPageUrl() ?>">Next</a></li>
                                <?php else: ?>
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
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
                    <a href="#" class="me-3 btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editColumn">
                        <ion-icon name="list" data-bs-toggle="tooltip" title="Edit columns"></ion-icon>
                    </a>
                    <a href="#" class="me-3 btn btn-outline-secondary btn-sm <?= isset( $_GET['column'] ) ? 'border border-2 border-primary': ''; ?>" data-bs-toggle="modal" data-bs-target="#filter">
                        <ion-icon name="funnel" data-bs-toggle="tooltip" title="Filter <?= $table ?>s"></ion-icon>
                    </a>
                    <?php if( strlen( $create_url ) > 0 ): ?>
                        <a href="<?= $create_url ?>" class="btn btn-primary btn-sm" id="create">Add <?= $table ?></a>
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

                <div class="modal fade modal-sm" id="editColumn" tabindex="-1" aria-labelledby="Edit Column" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="columnsForm">
                                <div class="modal-header p-0">
                                    <h2 class="h6 mb-0 p-2 ps-3">Edit Columns</h2>
                                    <div class="p-2 border-start rounded-0 ms-auto">
                                        <button type="button" class="btn-close btn-sm m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body p-2">
                                    <?php foreach( $columns as $key => $column ): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="<?= $key ?>" id="<?= $key ?>" checked>
                                            <label class="form-check-label" for="<?= $key ?>">
                                                <?= $column[0] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="modal-footer p-2">
                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm" id="applyColumn" text="Apply" data-bs-dismiss="modal">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    $( '#columnsForm' ).on( 'submit', e => {
                        e.preventDefault();
                        
                        spin( '#applyColumn' );
                        
                        let columnsData = {};
                        $( '#columnsForm' ).find( '[type="checkbox"]' ).each( function(i) {
                            columnsData[$(this).val()] = $(this).is(":checked");
                        });
                        localStorage.setItem( '<?= $base ?>', JSON.stringify(columnsData) );
                        
                        applyColumn();
                        unspin( '#applyColumn' );
                        
                        return false;
                    } );

                    const applyColumn = () => {
                        let storedData = localStorage.getItem( '<?= $base ?>' );
                        
                        if (storedData) {
                            let columnsData = JSON.parse(storedData);

                            Object.keys( columnsData ).forEach( function( key ) {
                                $( `#columnsForm #${key}` ).prop( "checked", columnsData[key] );
                                if( !columnsData[key] ) {
                                    $( `.${key}` ).hide();
                                } else {
                                    $( `.${key}` ).show();
                                }
                            });
                            $('#columnsForm').find('[type="checkbox"]').each(function() {
                                let checkboxValue = $(this).val();

                                if (columnsData.hasOwnProperty(checkboxValue)) {
                                    $(this).prop("checked", columnsData[checkboxValue]);
                                }
                            });
                        }
                    };

                    $( document ).ready( function() {
                        applyColumn();
                    } );
                </script>
            </div>
        <?php
    }

    protected function formatValue( $col, $value ) : String {
        $columns = $this->columns;

        // Check if the column exists in the configuration
        if (array_key_exists($col, $columns)) {
            $format = $columns[$col][1];

            if( is_array( $format ) ) {
                return $format[$value];
            } else {
                // Apply formatting based on format type
                switch ($format) {
                    case 'bool':
                        // For "No" and "Yes" values, convert 0 to "No" and 1 to "Yes"
                        return ($value == 1) ? "Yes" : "No";
                    case 'date':
                        // For formatted date/time values, assuming $value is a valid date/time string
                        $dateTime = new \DateTime($value);
                        return $dateTime->format('Y-m-d H:i A');
                    default:
                        // For other cases, return value as is
                        return $value ?? '';
                }
            }
        }

        // Return value as is if not found in column configuration
        return $value;
    }

}