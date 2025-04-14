<div class="filter-bar">
    <div class="filter-options">
        <a href="<?= SITE_URL ?>/admin/applications" class="filter-btn <?= empty($_GET['filter']) ? 'active' : '' ?>">All Applications</a>
        <a href="<?= SITE_URL ?>/admin/applications?filter=pending" class="filter-btn <?= ($_GET['filter'] ?? '') === 'pending' ? 'active' : '' ?>">Pending Admin Review</a>
        <a href="<?= SITE_URL ?>/admin/applications?filter=approved" class="filter-btn <?= ($_GET['filter'] ?? '') === 'approved' ? 'active' : '' ?>">Admin Approved</a>
        <a href="<?= SITE_URL ?>/admin/applications?filter=rejected" class="filter-btn <?= ($_GET['filter'] ?? '') === 'rejected' ? 'active' : '' ?>">Admin Rejected</a>
    </div>
</div>

<div class="dashboard-card">
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
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Applicant</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td>
                                    <div class="job-title-cell">
                                        <strong><?= htmlspecialchars($application['full_name']) ?></strong>
                                        <span class="job-location">
                                            <i class="fa-solid fa-envelope"></i> 
                                            <?= htmlspecialchars($application['applicant_email'] ?? $application['email'] ?? 'No email available') ?>
                                        </span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($application['job_title']) ?></td>
                                <td><?= htmlspecialchars($application['company_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($application['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($application['status']) ?>">
                                        <?= ucfirst($application['status']) ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?= SITE_URL ?>/admin/applications/view/<?= $application['application_id'] ?>" class="btn-icon" title="View Application">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= SITE_URL ?>/admin/applications/edit/<?= $application['application_id'] ?>" class="btn-icon" title="Edit Application">
                                        <i class="fa-solid fa-pencil"></i>
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
</div>