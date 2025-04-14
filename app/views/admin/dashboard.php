<div class="stats-container fade-in" style="animation-delay: 0.1s;">
    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <div class="stat-count"><?= $totalJobs ?></div>
            <div class="stat-label">Total Jobs</div>
        </div>
    </div>
    
    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-count"><?= $pendingJobs ?></div>
            <div class="stat-label">Pending Jobs</div>
        </div>
    </div>
    
    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-count"><?= $totalUsers ?></div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    
    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-file-lines"></i>
        </div>
        <div class="stat-content">
            <div class="stat-count"><?= $totalApplications ?></div>
            <div class="stat-label">Total Applications</div>
        </div>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="dashboard-summary-grid analytics-section">
    <!-- Job Status Distribution Chart -->
    <div class="dashboard-card fade-in" style="animation-delay: 0.2s;">
        <div class="card-header">
            <h2>Job Status Distribution</h2>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="jobStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- User Role Distribution Chart -->
    <div class="dashboard-card fade-in" style="animation-delay: 0.3s;">
        <div class="card-header">
            <h2>User Distribution</h2>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="userRoleChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Timeline -->
<div class="dashboard-card activity-timeline-card fade-in" style="animation-delay: 0.6s;">
    <div class="card-header">
        <h2>Recent Platform Activity</h2>
    </div>
    <div class="card-body">
        <div class="activity-timeline">
            <?php if (!empty($recentActivities)): ?>
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <?php if ($activity['type'] == 'job_posted'): ?>
                                <i class="fa-solid fa-briefcase"></i>
                            <?php elseif ($activity['type'] == 'user_registered'): ?>
                                <i class="fa-solid fa-user-plus"></i>
                            <?php elseif ($activity['type'] == 'application_submitted'): ?>
                                <i class="fa-solid fa-file-lines"></i>
                            <?php else: ?>
                                <i class="fa-solid fa-bell"></i>
                            <?php endif; ?>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text"><?= $activity['description'] ?></p>
                            <span class="activity-time"><?= \helpers\DateHelper::timeAgo($activity['timestamp']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No recent activity</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="dashboard-summary-grid">
    <!-- Recent Jobs Section -->
    <div class="dashboard-card fade-in" style="animation-delay: 0.4s;">
        <div class="card-header">
            <h2>Recent Job Postings</h2>
            <a href="<?= SITE_URL ?>/admin/jobs" class="view-all">View All</a>
        </div>
        <div class="card-body">
            <?php if (count($recentJobs) > 0): ?>
                <div class="responsive-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentJobs as $job): ?>
                                <tr>
                                    <td><?= htmlspecialchars($job['title']) ?></td>
                                    <td><?= htmlspecialchars($job['company_name']) ?></td>
                                    <td><?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($job['status']) ?>">
                                            <?= ucfirst($job['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= SITE_URL ?>/admin/jobs/view/<?= $job['job_id'] ?>" class="btn-icon" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <p>No job postings available</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Users Section -->
    <div class="dashboard-card fade-in" style="animation-delay: 0.5s;">
        <div class="card-header">
            <h2>Recent Users</h2>
            <a href="<?= SITE_URL ?>/admin/users" class="view-all">View All</a>
        </div>
        <div class="card-body">
            <?php if (count($recentUsers) > 0): ?>
                <div class="responsive-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentUsers as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <?php if ($user['role'] == 'admin'): ?>
                                            <span class="status-badge">Admin</span>
                                        <?php elseif ($user['role'] == 'company_admin'): ?>
                                            <span class="status-badge status-active">Employer</span>
                                        <?php else: ?>
                                            <span class="status-badge status-pending">Job Seeker</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= SITE_URL ?>/admin/users/view/<?= $user['user_id'] ?>" class="btn-icon" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p>No users available</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Job Status Distribution Chart
    const jobStatusCtx = document.getElementById('jobStatusChart').getContext('2d');
    const jobStatusChart = new Chart(jobStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Pending', 'Rejected', 'Closed'],
            datasets: [{
                data: [
                    <?= $jobStatusCounts['active'] ?? 0 ?>, 
                    <?= $jobStatusCounts['pending'] ?? 0 ?>, 
                    <?= $jobStatusCounts['rejected'] ?? 0 ?>, 
                    <?= $jobStatusCounts['closed'] ?? 0 ?>
                ],
                backgroundColor: [
                    '#4CAF50',  // green for active
                    '#FF9800',  // orange for pending
                    '#F44336',  // red for rejected
                    '#9E9E9E'   // gray for closed
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    
    // User Role Distribution Chart
    const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
    const userRoleChart = new Chart(userRoleCtx, {
        type: 'pie',
        data: {
            labels: ['Job Seekers', 'Employers', 'Admins'],
            datasets: [{
                data: [
                    <?= $userRoleCounts['job_seeker'] ?? 0 ?>, 
                    <?= $userRoleCounts['company_admin'] ?? 0 ?>, 
                    <?= $userRoleCounts['admin'] ?? 0 ?>
                ],
                backgroundColor: [
                    '#2196F3',  // blue for job seekers
                    '#673AB7',  // purple for employers
                    '#E91E63'   // pink for admins
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>