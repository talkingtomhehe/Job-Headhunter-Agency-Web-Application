<?php
// Set default values for optional variables
$ajaxEnabled = $ajaxEnabled ?? false;
$containerClass = $containerClass ?? '';
$onPageChange = $onPageChange ?? 'changePage';

// Calculate total pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Don't show pagination if there are no items
if ($totalItems === 0) {
    return;
}

// Determine page range to show (show 2 pages before and after current page)
$startPage = max(1, min($currentPage - 2, $totalPages - 4));
$endPage = min($totalPages, max(5, $currentPage + 2));

// Adjust start page if end page is too close to total pages
if ($endPage - $startPage < 4 && $endPage < $totalPages) {
    $startPage = max(1, $endPage - 4);
}

// If we're showing less than 5 pages and we're near the beginning
if ($endPage - $startPage < 4 && $startPage > 1) {
    $endPage = min($totalPages, $startPage + 4);
}
?>

<div class="pagination <?= $containerClass ?>">
    <?php if ($totalPages > 0): ?>
        <?php if ($currentPage > 1): ?>
            <?php if ($ajaxEnabled): ?>
                <a href="javascript:void(0)" 
                   class="pagination-link prev" 
                   onclick="<?= $onPageChange ?>('<?= str_replace('{page}', $currentPage - 1, $urlPattern) ?>', <?= $currentPage - 1 ?>)" 
                   data-page="<?= $currentPage - 1 ?>">
                    <i class="fa-solid fa-angle-left"></i> Previous
                </a>
            <?php else: ?>
                <a href="<?= str_replace('{page}', $currentPage - 1, $urlPattern) ?>" class="pagination-link prev">
                    <i class="fa-solid fa-angle-left"></i> Previous
                </a>
            <?php endif; ?>
        <?php else: ?>
            <!-- Disabled previous button when on first page -->
            <span class="pagination-link prev disabled">
                <i class="fa-solid fa-angle-left"></i> Previous
            </span>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($ajaxEnabled): ?>
                <a href="javascript:void(0)" 
                   class="pagination-link <?= $i == $currentPage ? 'active' : '' ?>" 
                   onclick="<?= $onPageChange ?>('<?= str_replace('{page}', $i, $urlPattern) ?>', <?= $i ?>)" 
                   data-page="<?= $i ?>">
                    <?= $i ?>
                </a>
            <?php else: ?>
                <a href="<?= str_replace('{page}', $i, $urlPattern) ?>" 
                   class="pagination-link <?= $i == $currentPage ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endif; ?>
        <?php endfor; ?>
        
        <?php if ($currentPage < $totalPages): ?>
            <?php if ($ajaxEnabled): ?>
                <a href="javascript:void(0)" 
                   class="pagination-link next" 
                   onclick="<?= $onPageChange ?>('<?= str_replace('{page}', $currentPage + 1, $urlPattern) ?>', <?= $currentPage + 1 ?>)" 
                   data-page="<?= $currentPage + 1 ?>">
                    Next <i class="fa-solid fa-angle-right"></i>
                </a>
            <?php else: ?>
                <a href="<?= str_replace('{page}', $currentPage + 1, $urlPattern) ?>" class="pagination-link next">
                    Next <i class="fa-solid fa-angle-right"></i>
                </a>
            <?php endif; ?>
        <?php else: ?>
            <!-- Disabled next button when on last page -->
            <span class="pagination-link next disabled">
                Next <i class="fa-solid fa-angle-right"></i>
            </span>
        <?php endif; ?>
        
    <?php endif; ?>
</div>