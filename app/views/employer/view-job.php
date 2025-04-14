<div class="dashboard-section">
    <div class="page-header">
        <div class="back-link">
            <a href="<?= SITE_URL ?>/employer/jobs">
                <i class="fa-solid fa-arrow-left"></i> Back to Job Listings
            </a>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <div class="job-title-header">
                <h2><?= htmlspecialchars($job['title']) ?></h2>
                <span class="status-badge status-<?= strtolower($job['status']) ?>">
                    <?= ucfirst($job['status']) ?>
                </span>
            </div>
            
            <div class="card-actions">
                <a href="<?= SITE_URL ?>/employer/jobs/editJob/<?= $job['job_id'] ?>" class="btn-action btn-edit">
                    <i class="fa-solid fa-pencil"></i> Edit Job
                </a>
                <div class="dropdown">
                    <button type="button" class="btn-action btn-status dropdown-toggle">
                        <i class="fa-solid fa-check-circle"></i> Update Status
                        <i class="fa-solid fa-caret-down" style="margin-left: 5px; font-size: 0.8rem;"></i>
                    </button>
                    <div class="dropdown-content">
                        <form action="<?= SITE_URL ?>/employer/jobs/updateStatus" method="POST">
                            <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="dropdown-item <?= $job['status'] == 'active' ? 'active' : '' ?>">Active</button>
                        </form>
                        <form action="<?= SITE_URL ?>/employer/jobs/updateStatus" method="POST">
                            <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="dropdown-item <?= $job['status'] == 'pending' ? 'active' : '' ?>">Draft</button>
                        </form>
                        <form action="<?= SITE_URL ?>/employer/jobs/updateStatus" method="POST">
                            <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                            <input type="hidden" name="status" value="closed">
                            <button type="submit" class="dropdown-item <?= $job['status'] == 'closed' ? 'active' : '' ?>">Closed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Job information in 2-column layout -->
            <div class="job-info-grid">
                <div class="job-info-column">
                    <div class="job-meta">
                        <div class="meta-item">
                            <i class="fa-solid fa-building"></i>
                            <span><?= htmlspecialchars($job['company_name']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?= htmlspecialchars($job['location']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fa-solid fa-clock"></i>
                            <span>Posted: <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                        </div>
                        <?php if (!empty($job['application_deadline'])): ?>
                        <div class="meta-item">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>Deadline: <?= date('M d, Y', strtotime($job['application_deadline'])) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="job-info-column">
                    <div class="job-meta">
                        <?php if (!empty($job['job_type'])): ?>
                        <div class="meta-item">
                            <i class="fa-solid fa-briefcase"></i>
                            <span><?= htmlspecialchars($job['job_type']) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($job['work_model'])): ?>
                        <div class="meta-item">
                            <i class="fa-solid fa-house-laptop"></i>
                            <span><?= ucfirst(htmlspecialchars($job['work_model'])) ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($job['experience_level'])): ?>
                        <div class="meta-item">
                            <i class="fa-solid fa-chart-line"></i>
                            <span><?= ucfirst(htmlspecialchars($job['experience_level'])) ?> Level</span>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                        <div class="meta-item">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            <span>
                                <?php if (!empty($job['salary_min']) && !empty($job['salary_max'])): ?>
                                    $<?= number_format($job['salary_min']) ?> - $<?= number_format($job['salary_max']) ?>
                                <?php elseif (!empty($job['salary_min'])): ?>
                                    From $<?= number_format($job['salary_min']) ?>
                                <?php elseif (!empty($job['salary_max'])): ?>
                                    Up to $<?= number_format($job['salary_max']) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="job-section">
                <h3>Description</h3>
                <div class="job-description">
                    <?= nl2br(htmlspecialchars($job['description'])) ?>
                </div>
            </div>
            
            <div class="job-section">
                <h3>Requirements</h3>
                <div class="job-requirements">
                    <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                </div>
            </div>
            
            <?php if (!empty($job['benefits'])): ?>
            <div class="job-section">
                <h3>Benefits</h3>
                <div class="job-benefits">
                    <?= nl2br(htmlspecialchars($job['benefits'])) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($job['hide_salary']) && $job['hide_salary']): ?>
            <div class="salary-note">
                <i class="fa-solid fa-eye-slash"></i>
                <span>Salary information is hidden from job seekers</span>
            </div>
            <?php endif; ?>
            
            <!-- PDF button moved to the end -->
            <?php if (!empty($job['pdf_path'])): ?>
            <div class="job-section pdf-section">
                <h3>Additional Documents</h3>
                <div class="pdf-container">
                    <a href="<?= SITE_URL . PUBLIC_PATH . '/' . $job['pdf_path'] ?>" target="_blank" class="btn-document">
                        <i class="fa-solid fa-file-pdf"></i> View Complete Job Description (PDF)
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Applications (<?= count($applications) ?>)</h2>
        </div>
        
        <div class="card-body">
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </div>
                    <p>No applications received yet</p>
                </div>
            <?php else: ?>
                <div class="responsive-table">
                    <table class="data-table applications-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr data-status="<?= strtolower($application['status']) ?>">
                                    <td>
                                        <div class="applicant-cell">
                                            <div class="applicant-avatar">
                                                <?= substr($application['full_name'], 0, 1) ?>
                                            </div>
                                            <div class="applicant-info">
                                                <strong><?= htmlspecialchars($application['full_name']) ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($application['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($application['status']) ?>">
                                            <?= ucfirst($application['status']) ?>
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <a href="<?= SITE_URL ?>/employer/applications/view/<?= $application['application_id'] ?>" class="btn-icon" title="View Application">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>