<div class="dashboard-card">
    <div class="card-header">
        <div class="card-filters">
            <div class="filter-group">
                <label for="roleFilter">Filter by Role:</label>
                <select id="roleFilter" class="filter-select">
                    <option value="all" <?= ($activeRole ?? '') === 'all' ? 'selected' : '' ?>>All Users</option>
                    <option value="job_seeker" <?= ($activeRole ?? '') === 'job_seeker' ? 'selected' : '' ?>>Job Seekers</option>
                    <option value="company_admin" <?= ($activeRole ?? '') === 'company_admin' ? 'selected' : '' ?>>Employers</option>
                    <option value="admin" <?= ($activeRole ?? '') === 'admin' ? 'selected' : '' ?>>Admins</option>
                </select>
            </div>
            
            <div class="search-box">
                <input type="text" id="userSearch" placeholder="Search users..." class="search-input">
                <button class="search-button"><i class="fa-solid fa-search"></i></button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p>No users found in this category</p>
            </div>
        <?php else: ?>
            <div class="responsive-table">
                <table class="data-table users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr data-role="<?= strtolower($user['role']) ?>">
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">
                                            <?= substr($user['full_name'], 0, 1) ?>
                                        </div>
                                        <div class="user-info">
                                            <strong><?= htmlspecialchars($user['full_name']) ?></strong>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="role-badge role-<?= strtolower($user['role']) ?>">
                                        <?= $user['role'] === 'job_seeker' ? 'Job Seeker' : ($user['role'] === 'company_admin' ? 'Employer' : ucfirst($user['role'])) ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= $user['active'] ? 'active' : 'inactive' ?>">
                                        <?= $user['active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?= SITE_URL ?>/admin/users/view/<?= $user['user_id'] ?>" class="btn-icon" title="View User">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <?php if ($user['role'] !== 'admin'): ?>
                                    <button type="button" class="btn-icon btn-delete" data-id="<?= $user['user_id'] ?>" title="Delete User">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Delete Modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                    <div class="modal-actions">
                        <button id="cancelDelete" class="btn-secondary">Cancel</button>
                        <form id="deleteForm" method="POST">
                            <input type="hidden" id="deleteUserId" name="user_id" value="">
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role filter functionality
    const roleFilter = document.getElementById('roleFilter');
    if (roleFilter) {
        roleFilter.addEventListener('change', function() {
            const selectedRole = this.value;
            if (selectedRole === 'all') {
                window.location.href = '<?= SITE_URL ?>/admin/users';
            } else {
                window.location.href = '<?= SITE_URL ?>/admin/users?role=' + selectedRole;
            }
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.users-table tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.user-info strong').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Delete modal functionality
    const modal = document.getElementById('deleteModal');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancelDelete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            document.getElementById('deleteUserId').value = userId;
            modal.style.display = 'block';
        });
    });
    
    // Closing the modal
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Close when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Set up delete form submission
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const userId = document.getElementById('deleteUserId').value;
            this.action = '<?= SITE_URL ?>/admin/users/delete/' + userId;
            this.submit();
        });
    }
});
</script>