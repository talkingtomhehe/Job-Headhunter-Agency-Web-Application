<?php
function generatePaginationUrl($page_num) {
    $params = $_GET;
    $params['page_num'] = $page_num;
    return '?' . http_build_query($params);
}

$total_pages = ceil($total_jobs / $jobs_per_page);
$current_page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
?>

<div class="pagination">
    <?php if ($current_page > 1): ?>
        <a href="<?php echo generatePaginationUrl($current_page - 1); ?>"
           class="pagination-button">
            <i class="fas fa-chevron-left"></i>
        </a>
    <?php endif; ?>

    <?php
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);

    if ($start_page > 1) {
        echo '<a href="' . generatePaginationUrl(1) . '" class="pagination-button">1</a>';
        if ($start_page > 2) {
            echo '<span class="pagination-button disabled">...</span>';
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = ($i === $current_page) ? ' active' : '';
        echo '<a href="' . generatePaginationUrl($i) . '" class="pagination-button' . $active_class . '">' . $i . '</a>';
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            echo '<span class="pagination-button disabled">...</span>';
        }
        echo '<a href="' . generatePaginationUrl($total_pages) . '" class="pagination-button">' . $total_pages . '</a>';
    }
    ?>

    <?php if ($current_page < $total_pages): ?>
        <a href="<?php echo generatePaginationUrl($current_page + 1); ?>"
           class="pagination-button">
            <i class="fas fa-chevron-right"></i>
        </a>
    <?php endif; ?>
</div>