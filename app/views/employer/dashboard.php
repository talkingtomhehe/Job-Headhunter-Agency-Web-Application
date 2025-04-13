<div class="dashboard-container">
    <!-- Dashboard Title Section -->
    <div class="dashboard-title-section fade-in" style="animation-delay: 0.05s;">
        <h1>Employer Dashboard</h1>
        <p>Welcome back to your recruitment management center</p>
    </div>
    
    <!-- Key Metrics Section - Positioned at the top with oval styling -->
    <div class="stats-container">
        <!-- Active Jobs Stat -->
        <div class="stat-box oval-stat fade-in" style="animation-delay: 0.1s;">
            <div class="stat-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <div class="stat-count"><?php echo $activeJobs; ?></div>
                <div class="stat-label">Active Jobs</div>
            </div>
        </div>
        
        <!-- Total Applications Stat -->
        <div class="stat-box oval-stat fade-in" style="animation-delay: 0.2s;">
            <div class="stat-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="stat-content">
                <div class="stat-count"><?php echo $totalApplications; ?></div>
                <div class="stat-label">Applications</div>
            </div>
        </div>
        
        <!-- Total Jobs Stat -->
        <div class="stat-box oval-stat fade-in" style="animation-delay: 0.3s;">
            <div class="stat-icon">
                <i class="fa-solid fa-chart-bar"></i>
            </div>
            <div class="stat-content">
                <div class="stat-count"><?php echo $totalJobs; ?></div>
                <div class="stat-label">Total Jobs</div>
            </div>
        </div>
        
        <!-- New Today Stat -->
        <div class="stat-box oval-stat fade-in" style="animation-delay: 0.4s;">
            <div class="stat-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div class="stat-content">
                <div class="stat-count"><?php echo isset($todayApplications) ? $todayApplications : 0; ?></div>
                <div class="stat-label">New Today</div>
            </div>
        </div>
    </div>

    <!-- Analytics Overview Section -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3 class="section-title">Analytics Overview</h3>
            <p class="section-subtitle">Insights into your recruitment activity</p>
        </div>
        
        <div class="dashboard-summary-grid">
            <!-- Applications Overview Chart -->
            <div class="dashboard-card fade-in" style="animation-delay: 0.5s;">
                <div class="card-header">
                    <h2>Applications by Status</h2>
                    <a href="<?= SITE_URL ?>/employer/applications" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                        <?php if ($totalApplications == 0): ?>
                            <div class="no-data-overlay">
                                <p>No application data available yet</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Job Activity Chart -->
            <div class="dashboard-card fade-in" style="animation-delay: 0.6s;">
                <div class="card-header">
                    <h2>Job Status Distribution</h2>
                    <a href="<?= SITE_URL ?>/employer/jobs" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="jobActivityChart"></canvas>
                        <?php if ($totalJobs == 0): ?>
                            <div class="no-data-overlay">
                                <p>No job posting data available yet</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3 class="section-title">Latest Applications</h3>
            <p class="section-subtitle">Recent candidate submissions</p>
        </div>
        
        <div class="application-activities-container">
            <!-- Recent Applications -->
            <div class="dashboard-card full-width fade-in" style="animation-delay: 0.7s;">
                <div class="card-header">
                    <h2>Recent Applicants</h2>
                    <a href="<?= SITE_URL ?>/employer/applications" class="view-all">View All</a>
                </div>
                <div class="card-body">
                    <?php if (isset($recentApplications) && count($recentApplications) > 0): ?>
                        <div class="activity-list">
                            <?php foreach ($recentApplications as $application): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4><?= $application->job_title ?></h4>
                                        <p>Applied by: <?= $application->applicant_name ?></p>
                                        <div class="activity-meta">
                                            <span class="status-badge status-<?= $application->status ?>"><?= $application->status ?></span>
                                            <span class="activity-time"><?= \helpers\DateHelper::timeAgo($application->created_at) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fa-solid fa-file-circle-xmark"></i>
                            </div>
                            <p>No recent applications found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add the CSS for the oval stat boxes -->
<style>
.dashboard-title-section h1 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.dashboard-title-section p {
    color: #6c757d;
    font-size: 1.1rem;
}

.application-activities-container {
    width: 100%;
    margin-bottom: 2rem;
}

.full-width {
    width: 100%;
}
</style>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize charts if there is data
    <?php if ($totalApplications > 0): ?>
    // Applications Overview Chart
    const applicationCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(applicationCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Reviewing', 'Shortlisted', 'Hired', 'Rejected'],
            datasets: [{
                data: [
                    <?php echo isset($applicationStats['pending']) ? $applicationStats['pending'] : 0; ?>,
                    <?php echo isset($applicationStats['reviewing']) ? $applicationStats['reviewing'] : 0; ?>,
                    <?php echo isset($applicationStats['shortlisted']) ? $applicationStats['shortlisted'] : 0; ?>,
                    <?php echo isset($applicationStats['hired']) ? $applicationStats['hired'] : 0; ?>,
                    <?php echo isset($applicationStats['rejected']) ? $applicationStats['rejected'] : 0; ?>
                ],
                backgroundColor: [
                    '#fff8dd', // Pending - Yellow
                    '#e9ecef', // Reviewing - Gray
                    '#e0f3ff', // Shortlisted - Blue
                    '#d1e7dd', // Hired - Green
                    '#f8d7da'  // Rejected - Red
                ],
                borderColor: [
                    '#ffc107',
                    '#6c757d',
                    '#0d6efd',
                    '#198754',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            },
            cutout: '65%'
        }
    });
    <?php endif; ?>
    
    <?php if ($totalJobs > 0): ?>
    // Job Activity Chart
    const activityCtx = document.getElementById('jobActivityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Draft', 'Expired', 'Filled'],
            datasets: [{
                label: 'Number of Jobs',
                data: [
                    <?php echo $activeJobs; ?>,
                    <?php echo isset($jobStats['draft']) ? $jobStats['draft'] : 0; ?>,
                    <?php echo isset($jobStats['expired']) ? $jobStats['expired'] : 0; ?>,
                    <?php echo isset($jobStats['filled']) ? $jobStats['filled'] : 0; ?>
                ],
                backgroundColor: [
                    'rgba(6, 49, 188, 0.7)',  // Active - Primary blue
                    'rgba(108, 117, 125, 0.7)', // Draft - Gray
                    'rgba(108, 117, 125, 0.5)', // Expired - Light gray
                    'rgba(25, 135, 84, 0.7)'   // Filled - Green
                ],
                borderColor: [
                    'rgb(6, 49, 188)',
                    'rgb(108, 117, 125)',
                    'rgb(108, 117, 125)',
                    'rgb(25, 135, 84)'
                ],
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            barThickness: 30
        }
    });
    <?php endif; ?>
});
</script>