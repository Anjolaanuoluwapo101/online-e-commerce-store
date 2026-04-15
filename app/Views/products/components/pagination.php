<?php if ($totalPages > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Product pagination">
                <ul class="pagination justify-content-center mb-0">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="handlePagination(<?= $currentPage - 1 ?>)">
                                <i class="fa fa-chevron-left"></i> Prev
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php 
                    // Show first page
                    if ($currentPage > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="handlePagination(1)">1</a>
                        </li>
                        <?php if ($currentPage > 4): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php 
                    // Show pages around current page
                    $start = max(1, $currentPage - 2);
                    $end = min($totalPages, $currentPage + 2);
                    
                    for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="#" onclick="handlePagination(<?= $i ?>)">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php 
                    // Show last page
                    if ($currentPage < $totalPages - 2): ?>
                        <?php if ($currentPage < $totalPages - 3): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="handlePagination(<?= $totalPages ?>)">
                                <?= $totalPages ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="handlePagination(<?= $currentPage + 1 ?>)">
                                Next <i class="fa fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?>