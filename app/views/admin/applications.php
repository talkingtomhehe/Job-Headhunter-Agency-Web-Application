<div class="dashboard-card">
    <div class="card-header">
        <div class="card-filters">
            <div class="filter-group">
                <label for="statusFilter">Filter by Status:</label>
                <select id="statusFilter" class="filter-select">
                    <option value="all" <?= empty($_GET['filter']) ? 'selected' : '' ?>>All Applications</option>
                    <option value="pending" <?= ($_GET['filter'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending Review</option>
                    <option value="approved" <?= ($_GET['filter'] ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= ($_GET['filter'] ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
            
            <div class="search-box">
                <input type="text" id="applicationSearch" placeholder="Search applications..." class="search-input">
                <button class="search-button"><i class="fa-solid fa-search"></i></button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (empty($applications)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-file-circle-xmark"></i>
                </div>
                <p>No applications found in this category</p>
            </div>
        <?php else: ?>
            <div class="responsive-table">
                <table class="data-table applications-table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Applied</th>
                            <th>Admin Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr data-status="<?= strtolower($application['admin_status']) ?>">
                                <td>
                                    <div class="applicant-cell">
                                        <?php
                                        $avatarPath = !empty($application['avatar_path']) ? $application['avatar_path'] : 'assets/images/defaultavatar.jpg';
                                        ?>
                                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $avatarPath ?>" alt="<?= htmlspecialchars($application['full_name']) ?>" class="applicant-avatar">
                                        <div class="applicant-info">
                                            <strong><?= htmlspecialchars($application['full_name']) ?></strong>
                                            <div class="contact-info">
                                                <p><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($application['applicant_email'] ?? 'No email') ?></p>
                                                <?php if (!empty($application['phone'])): ?>
                                                <p><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($application['phone']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($application['job_title']) ?></td>
                                <td><?= htmlspecialchars($application['company_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($application['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge admin-status-<?= strtolower($application['admin_status']) ?>">
                                        <?= ucfirst($application['admin_status']) ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?= SITE_URL ?>/admin/applications/view/<?= $application['application_id'] ?>" class="btn-icon" title="View Application">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <?php if ($application['admin_status'] === 'pending'): ?>
                                        <form action="<?= SITE_URL ?>/admin/applications/approve" method="POST" style="display: inline;">
                                            <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                                            <button type="submit" class="btn-icon btn-approve-icon" title="Approve Application">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="<?= SITE_URL ?>/admin/applications/reject" method="POST" style="display: inline;">
                                            <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                                            <button type="submit" class="btn-icon btn-reject-icon" title="Reject Application">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($applications)): ?>
        <div class="pagination-container">
            <?php
            // Set required variables for pagination component
            $totalItems = $totalItems ?? count($applications);
            $itemsPerPage = $itemsPerPage ?? 10;
            $currentPage = $currentPage ?? 1;
            
            // Build URL with any existing filters maintained
            $filterParam = isset($_GET['filter']) && $_GET['filter'] !== 'all' ? "?filter={$_GET['filter']}&" : "?";
            $urlPattern = SITE_URL . '/admin/applications' . $filterParam . 'page={page}';
            
            // Include pagination component
            include ROOT_PATH . '/app/views/components/pagination.php';
            ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status filter functionality
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            if (selectedStatus === 'all') {
                window.location.href = '<?= SITE_URL ?>/admin/applications';
            } else {
                window.location.href = '<?= SITE_URL ?>/admin/applications?filter=' + selectedStatus;
            }
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('applicationSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.applications-table tbody tr');
            
            rows.forEach(row => {
                const applicantName = row.querySelector('.applicant-info strong').textContent.toLowerCase();
                const applicantEmail = row.querySelector('.contact-info p').textContent.toLowerCase();
                const jobTitle = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const company = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                if (applicantName.includes(searchTerm) || 
                    applicantEmail.includes(searchTerm) || 
                    jobTitle.includes(searchTerm) || 
                    company.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>