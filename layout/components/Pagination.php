<?php

namespace simpl;

class Pagination {

    public static function render( $items ) {
        ?>
            <div class="d-flex justify-content-between">
                <div>
                    <?php
                        $perPage = $items->perPage();
                        $totalUsers = $items->total();
                        $start = ($items->currentPage() - 1) * $perPage + 1;
                        $end = min($start + $perPage - 1, $totalUsers);
                
                        echo "Showing $start to $end user(s)";
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

}