<main>
    <!-- Hero Section with SVG background -->
    <section class="hero-banner">
        <div class="image-container">
            <img src="/huntly/public/assets/images/home_image.svg" alt="Hero Background" class="hero-image">
            <div class="image-overlay"></div>
        </div>

        <!-- Hero search section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Bridging the gap between Talent and Opportunity!</h1>

                <div class="search-form-container">
                    <form class="search-form" action="/huntly/public/search.php" method="GET">
                        <div class="search-inputs">
                            <div class="input-group">
                                <i class="fa-solid fa-briefcase"></i>
                                <input type="text" id="job-search" name="keyword" placeholder="Job title or Company" autocomplete="off">
                                <div id="job-hint" class="search-hints"></div>
                            </div>

                            <div class="input-group">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" id="location-search" name="location" placeholder="City, State">
                                <div id="location-hint" class="search-hints"></div>
                            </div>

                            <div class="input-group">
                                <i class="fa-solid fa-house"></i>
                                <select name="work_model">
                                    <option value="" hidden>Work model</option>
                                    <?php if (!empty($workModels)): ?>
                                        <?php foreach ($workModels as $model): ?>
                                            <option value="<?= $model['id'] ?>"><?= htmlspecialchars($model['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="input-group">
                                <i class="fa-solid fa-list-ul"></i>
                                <select name="category">
                                    <option value="" hidden>Categories</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="search-button-container">
                            <button type="submit" class="search-button">Find Jobs</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Jobs Section -->
    <section class="recent-jobs">
        <div class="container">
            <h2 class="section-title">RECENT JOBS<span class="title-underline"></span></h2>

            <div class="jobs-container">
                <?php if (!empty($recentJobs)): ?>
                    <?php foreach ($recentJobs as $job): ?>
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
                                        <span class="job-tag"><?= htmlspecialchars($job['work_model'] ?? '') ?></span>
                                        <span class="job-tag"><?= htmlspecialchars($job['category_name'] ?? '') ?></span>
                                        <span class="job-tag"><?= htmlspecialchars($job['experience_level'] ?? '') ?></span>
                                    </div>
                                </div>
                                <div class="job-meta">
                                    <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></p>
                                    <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <?= call_user_func($formatSalary, $job['salary_min'], $job['salary_max']) ?></p>
                                    <p class="job-posted-date"><i class="fa-regular fa-calendar"></i> Posted <?= call_user_func($timeAgo, $job['created_at']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-jobs-message">
                        <p>No job listings available at the moment. Please check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="view-all-container">
                <a href="<?= SITE_URL ?>/job" class="view-all-link">View All Jobs <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Top Companies Section -->
    <section class="top-companies">
        <div class="container">
            <h2 class="section-title">TOP COMPANIES REGISTERED<span class="title-underline"></span></h2>

            <div class="companies-container">
                <?php if (!empty($topCompanies)): ?>
                    <?php foreach ($topCompanies as $company): ?>
                        <div class="company-card">
                            <div class="company-logo-large">
                                <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($company['logo_path']) ? $company['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                    alt="<?= htmlspecialchars($company['company_name']) ?>"
                                    onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                            </div>
                            <h3 class="company-title"><?= htmlspecialchars($company['company_name']) ?></h3>
                            <p class="company-location">
                                <i class="fa-solid fa-location-dot"></i> 
                                <?= !empty($company['headquarters_address']) ? htmlspecialchars($company['headquarters_address']) : 'Location not specified' ?>
                            </p>
                            <p class="company-jobs">Open jobs - <span><?= $company['job_count'] ?></span></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-companies-message">
                        <p>No companies available at the moment. Please check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>