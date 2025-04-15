<main>
    <!-- Redesigned search banner section -->
    <section class="search-banner">
        <div class="search-overlay"></div>
        <div class="search-content">
            <h1 class="search-title">Find Your Dream Job</h1>
            <p class="search-subtitle">Browse thousands of jobs from top companies</p>
            
            <form id="job-search-form" class="search-form" action="<?= SITE_URL ?>/job" method="GET">
                <div class="search-row">
                    <div class="search-col">
                        <div class="input-group">
                            <i class="fa-solid fa-briefcase"></i>
                            <input type="text" id="keyword-input" name="keyword" placeholder="Job title or Company" value="<?= htmlspecialchars($keyword ?? '') ?>">
                        </div>
                    </div>
                    <div class="search-col">
                        <div class="input-group">
                            <i class="fa-solid fa-location-dot"></i>
                            <input type="text" id="location-input" name="location" placeholder="Location" value="<?= htmlspecialchars($location ?? '') ?>">
                        </div>
                    </div>
                    <div class="search-col">
                        <button type="submit" class="search-button">Search Jobs</button>
                    </div>
                </div>
                
                <div class="advanced-filters">
                    <div class="filter-row">
                        <div class="filter-col">
                            <div class="input-group">
                                <i class="fa-solid fa-house"></i>
                                <select id="work-model-input" name="work_model">
                                    <option value="">Work model</option>
                                    <option value="remote" <?= ($workModel ?? '') === 'remote' ? 'selected' : '' ?>>Remote</option>
                                    <option value="hybrid" <?= ($workModel ?? '') === 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                                    <option value="onsite" <?= ($workModel ?? '') === 'onsite' ? 'selected' : '' ?>>On-site</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-col">
                            <div class="input-group">
                                <i class="fa-solid fa-list-ul"></i>
                                <select id="category-input" name="category">
                                    <option value="">Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['category_id'] ?>" <?= ($selectedCategory ?? '') == $category['category_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter-col">
                            <div class="input-group">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <select id="experience-input" name="experience">
                                    <option value="">Experience level</option>
                                    <option value="entry" <?= ($experienceLevel ?? '') === 'entry' ? 'selected' : '' ?>>Entry level</option>
                                    <option value="mid" <?= ($experienceLevel ?? '') === 'mid' ? 'selected' : '' ?>>Mid level</option>
                                    <option value="senior" <?= ($experienceLevel ?? '') === 'senior' ? 'selected' : '' ?>>Senior level</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-col">
                            <div class="input-group">
                                <i class="fa-solid fa-clock"></i>
                                <select id="job-type-input" name="job_type">
                                    <option value="">Job type</option>
                                    <option value="Full-time" <?= ($jobType ?? '') === 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                    <option value="Part-time" <?= ($jobType ?? '') === 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                    <option value="Contract" <?= ($jobType ?? '') === 'Contract' ? 'selected' : '' ?>>Contract</option>
                                    <option value="Freelance" <?= ($jobType ?? '') === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                                    <option value="Internship" <?= ($jobType ?? '') === 'Internship' ? 'selected' : '' ?>>Internship</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="toggle-filters">
                    <a href="#" id="toggle-advanced-filters">
                        <span class="show-text">Show advanced filters</span>
                        <span class="hide-text">Hide advanced filters</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Jobs Listing Section with dashboard-like layout -->
    <section class="jobs-listing">
        <div class="container">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="job-count">
                        <h2><span id="total-jobs-count" class="count-number"><?= $totalJobs ?></span> Jobs Found</h2>
                    </div>
                    <div class="card-filters">
                        <div class="filter-group">
                            <label for="sort-by">Sort by:</label>
                            <select id="sort-by" class="filter-select">
                                <option value="newest" <?= ($sortBy ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
                                <option value="oldest" <?= ($sortBy ?? '') === 'oldest' ? 'selected' : '' ?>>Oldest</option>
                                <option value="salary_high" <?= ($sortBy ?? '') === 'salary_high' ? 'selected' : '' ?>>Salary (high to low)</option>
                                <option value="salary_low" <?= ($sortBy ?? '') === 'salary_low' ? 'selected' : '' ?>>Salary (low to high)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Loading indicator (initially hidden) -->
                    <div id="loading-indicator" class="loading-indicator" style="display: none;">
                        <i class="fa-solid fa-circle-notch fa-spin"></i> Loading jobs...
                    </div>

                    <!-- Jobs container -->
                    <div id="jobs-container" class="jobs-container">
                        <?php if (!empty($jobs) && count($jobs) > 0): ?>
                            <?php foreach ($jobs as $job): ?>
                                <div class="job-card" onclick="window.location.href='<?= SITE_URL ?>/job/viewJob/<?= $job['job_id'] ?>'">
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
                                                <?php if (!empty($job['work_model'])): ?>
                                                    <span class="job-tag work-model"><i class="fa-solid fa-house"></i> <?= htmlspecialchars($job['work_model']) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($job['category_name'])): ?>
                                                    <span class="job-tag category"><i class="fa-solid fa-tag"></i> <?= htmlspecialchars($job['category_name']) ?></span>
                                                <?php endif; ?>
                                                <?php if (!empty($job['job_type'])): ?>
                                                    <span class="job-tag job-type"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($job['job_type']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="job-meta">
                                            <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></p>
                                            <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <?= call_user_func($formatSalary, $job['salary_min'], $job['salary_max']) ?></p>
                                            <p class="job-date"><i class="fa-regular fa-calendar"></i> <?= call_user_func($timeAgo, $job['created_at']) ?></p>
                                            <a href="<?= SITE_URL ?>/job/viewJob/<?= $job['job_id'] ?>" class="view-job-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <h3>No Jobs Found</h3>
                                <p>Try adjusting your search criteria or check back later for new opportunities.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination (will be updated by AJAX) -->
                    <div id="pagination-container" class="pagination">
                        <?php if (!empty($jobs) && $totalJobs > 0): ?>
                            <?php
                            $totalPages = ceil($totalJobs / $jobsPerPage);
                            $currentPage = $page ?? 1;
                            
                            if ($currentPage > 1): ?>
                                <a href="javascript:void(0)" class="pagination-link prev" data-page="<?= $currentPage - 1 ?>">
                                    <i class="fa-solid fa-angle-left"></i> Previous
                                </a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                <a href="javascript:void(0)" data-page="<?= $i ?>" 
                                class="pagination-link <?= $i == $currentPage ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <a href="javascript:void(0)" class="pagination-link next" data-page="<?= $currentPage + 1 ?>">
                                    Next <i class="fa-solid fa-angle-right"></i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Template for job cards (used by JavaScript to create new job cards) -->
<template id="job-card-template">
    <div class="job-card">
        <div class="job-header">
            <div class="company-logo">
                <img src="" alt="" onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
            </div>
            <div class="job-info">
                <h3 class="job-title"></h3>
                <p class="company-name"></p>
                <div class="job-tags">
                    <span class="job-tag work-model"><i class="fa-solid fa-house"></i> <span class="work-model-text"></span></span>
                    <span class="job-tag category"><i class="fa-solid fa-tag"></i> <span class="category-text"></span></span>
                    <span class="job-tag job-type"><i class="fa-solid fa-clock"></i> <span class="job-type-text"></span></span>
                </div>
            </div>
            <div class="job-meta">
                <p class="job-location"><i class="fa-solid fa-location-dot"></i> <span class="location-text"></span></p>
                <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <span class="salary-text"></span></p>
                <p class="job-date"><i class="fa-regular fa-calendar"></i> <span class="date-text"></span></p>
                <a href="#" class="view-job-btn">View Details</a>
            </div>
        </div>
    </div>
</template>

<script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/job-listing.js" defer></script>