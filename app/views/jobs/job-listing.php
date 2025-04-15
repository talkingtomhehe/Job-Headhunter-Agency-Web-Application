<main>
    <!-- Page header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Browse Jobs</h1>
            <p class="page-description">Find your dream job from our latest opportunities</p>
        </div>
    </section>

    <!-- Job Search Section -->
    <section class="job-search-section">
        <div class="container">
            <form class="search-form" action="<?= SITE_URL ?>/jobs" method="GET">
                <div class="search-inputs">
                    <div class="input-group">
                        <i class="fa-solid fa-briefcase"></i>
                        <input type="text" name="keyword" placeholder="Job title or Company" value="<?= htmlspecialchars($keyword ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="location" placeholder="City, State" value="<?= htmlspecialchars($location ?? '') ?>">
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-house"></i>
                        <select name="work_model">
                            <option value="">Work model</option>
                            <option value="remote" <?= ($workModel ?? '') === 'remote' ? 'selected' : '' ?>>Remote</option>
                            <option value="hybrid" <?= ($workModel ?? '') === 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                            <option value="onsite" <?= ($workModel ?? '') === 'onsite' ? 'selected' : '' ?>>On-site</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-list-ul"></i>
                        <select name="category">
                            <option value="">Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= ($selectedCategory ?? '') == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="search-button-container">
                    <button type="submit" class="search-button">Search Jobs</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Jobs Listing Section -->
    <section class="jobs-listing">
        <div class="container">
            <!-- Filters and job count -->
            <div class="jobs-header">
                <div class="job-count">
                    <h2><?= $totalJobs ?> Jobs Found</h2>
                </div>
                <div class="jobs-filter">
                    <label for="sort-by">Sort by:</label>
                    <select id="sort-by" onchange="sortJobs(this.value)">
                        <option value="newest" <?= ($sortBy ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
                        <option value="oldest" <?= ($sortBy ?? '') === 'oldest' ? 'selected' : '' ?>>Oldest</option>
                        <option value="salary_high" <?= ($sortBy ?? '') === 'salary_high' ? 'selected' : '' ?>>Salary (high to low)</option>
                        <option value="salary_low" <?= ($sortBy ?? '') === 'salary_low' ? 'selected' : '' ?>>Salary (low to high)</option>
                    </select>
                </div>
            </div>

            <!-- Job listings -->
            <div class="jobs-container">
                <?php if (count($jobs) > 0): ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card" onclick="window.location.href='<?= SITE_URL ?>/jobs/view/<?= $job['job_id'] ?>'">
                            <div class="job-header">
                                <div class="company-logo">
                                    <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                         alt="<?= htmlspecialchars($job['company_name']) ?>"
                                         onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                                </div>
                                <div class="job-info">
                                    <h3 class="job-title"><?= htmlspecialchars($job['title']) ?></h3>
                                    <p class="company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                                    <div class="job-tags">
                                        <span class="job-tag"><?= htmlspecialchars($job['work_model']) ?></span>
                                        <span class="job-tag"><?= htmlspecialchars($job['category_name']) ?></span>
                                        <span class="job-tag"><?= htmlspecialchars($job['experience_level']) ?></span>
                                    </div>
                                </div>
                                <div class="job-meta">
                                    <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></p>
                                    <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <?= formatSalary($job['salary_min'], $job['salary_max']) ?></p>
                                    <p class="job-posted-date"><i class="fa-regular fa-calendar"></i> Posted <?= timeAgo($job['created_at']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-jobs-found">
                        <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/no-results.svg" alt="No jobs found" class="no-jobs-image">
                        <h3>No jobs found</h3>
                        <p>Try adjusting your search criteria or check back later for new opportunities.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalJobs > 0): ?>
                <div class="pagination">
                    <?php
                    $totalPages = ceil($totalJobs / $jobsPerPage);
                    $currentPage = $page ?? 1;
                    
                    // Build the query string for pagination links
                    $queryParams = $_GET;
                    unset($queryParams['url']); // Remove the URL parameter
                    $queryString = http_build_query($queryParams);
                    $queryString = !empty($queryString) ? '&' . $queryString : '';
                    ?>
                    
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= SITE_URL ?>/jobs?page=<?= $currentPage - 1 . $queryString ?>" class="pagination-link prev">
                            <i class="fa-solid fa-angle-left"></i> Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <a href="<?= SITE_URL ?>/jobs?page=<?= $i . $queryString ?>" 
                           class="pagination-link <?= $i == $currentPage ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= SITE_URL ?>/jobs?page=<?= $currentPage + 1 . $queryString ?>" class="pagination-link next">
                            Next <i class="fa-solid fa-angle-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
    function sortJobs(sortValue) {
        // Get current URL
        const url = new URL(window.location.href);
        
        // Update or add the sort parameter
        url.searchParams.set('sort', sortValue);
        
        // Redirect to the new URL
        window.location.href = url.toString();
    }
</script>