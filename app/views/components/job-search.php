<?php
$company_id = isset($_GET['id']) ? $_GET['id'] : null;
$search_query = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$job_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
?>

<div class="job-search-section">
    <div class="search-header">
        <h2>
            <?php
            if ($company_id && isset($company['company_name'])) {
                echo htmlspecialchars($company['company_name']) . " có " . $total_jobs . " vị trí đang tuyển - tìm việc phù hợp với bạn.";
            }
            ?>
        </h2>
    </div>

    <form action="" method="GET" class="search-form">
        <input type="hidden" name="page" value="company-detail">
        <input type="hidden" name="id" value="<?php echo $company_id; ?>">
        <input type="hidden" name="tab" value="jobs">

        <div class="search-input-wrapper">
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Tìm kiếm theo chức danh hoặc yêu cầu công việc"
                value="<?php echo $search_query; ?>"
            >

            <select name="type" class="job-type-select">
                <option value="">Tất cả hình thức</option>
                <option value="Full-time" <?php echo $job_type == 'Full-time' ? 'selected' : ''; ?>>Full-time</option>
                <option value="Part-time" <?php echo $job_type == 'Part-time' ? 'selected' : ''; ?>>Part-time</option>
                <option value="Contract" <?php echo $job_type == 'Contract' ? 'selected' : ''; ?>>Contract</option>
                <option value="Internship" <?php echo $job_type == 'Internship' ? 'selected' : ''; ?>>Internship</option>
            </select>

            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>