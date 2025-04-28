<div class="application-view-container">
    <div class="page-header">
        <div class="back-link">
            <a href="<?= SITE_URL ?>/employer/applications">
                <i class="fa-solid fa-arrow-left"></i> Back to Applications
            </a>
        </div>
    </div>
    
    <div class="application-header">
        <h1>Application for <?= htmlspecialchars($job['title']) ?></h1>
    </div>

    <div class="application-status-bar">
        <div class="app-status-info">
            <span class="app-status-label">Current Status:</span>
            <span class="app-status-badge app-status-<?= strtolower($application['status']) ?>">
                <?= ucfirst($application['status']) ?>
            </span>
        </div>
        
        <div class="app-status-actions">
            <form action="<?= SITE_URL ?>/employer/updateApplicationStatus" method="POST" class="app-status-form">
                <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                
                <div class="app-status-buttons">
                    <button type="submit" name="status" value="pending" class="app-status-btn <?= $application['status'] == 'pending' ? 'active' : '' ?>">
                        <i class="fa-solid fa-clock"></i> <span>Pending</span>
                    </button>
                    <button type="submit" name="status" value="reviewing" class="app-status-btn <?= $application['status'] == 'reviewing' ? 'active' : '' ?>">
                        <i class="fa-solid fa-magnifying-glass"></i> <span>Reviewing</span>
                    </button>
                    <button type="submit" name="status" value="shortlisted" class="app-status-btn <?= $application['status'] == 'shortlisted' ? 'active' : '' ?>">
                        <i class="fa-solid fa-star"></i> <span>Shortlisted</span>
                    </button>
                    <button type="submit" name="status" value="hired" class="app-status-btn <?= $application['status'] == 'hired' ? 'active' : '' ?>">
                        <i class="fa-solid fa-check-circle"></i> <span>Hired</span>
                    </button>
                    <button type="submit" name="status" value="rejected" class="app-status-btn app-status-btn-danger <?= $application['status'] == 'rejected' ? 'active' : '' ?>">
                        <i class="fa-solid fa-times-circle"></i> <span>Rejected</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="application-grid">
        <div class="application-details">
            <div class="application-card">
                <h2>Applicant Information</h2>
                <div class="applicant-profile">
                    <div class="applicant-avatar large">
                        <?php
                        // Get avatar path based on whether this is a registered user or guest
                        $avatarPath = !empty($application['seeker_id']) && !empty($application['avatar_path']) ? 
                            $application['avatar_path'] : 'assets/images/defaultavatar.jpg';
                        ?>
                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $avatarPath ?>" 
                            alt="<?= htmlspecialchars($application['full_name']) ?>" class="user-avatar">
                    </div>
                    <div class="applicant-details">
                        <h3><?= htmlspecialchars($application['full_name']) ?></h3>
                        <div class="contact-info">
                            <p><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($application['email']) ?></p>
                            <?php if (!empty($application['phone'])): ?>
                            <p><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($application['phone']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($application['seeker_id'])): ?>
                            <p><i class="fa-solid fa-user"></i> Registered User</p>
                            <?php else: ?>
                            <p><i class="fa-solid fa-user-check"></i> Guest Applicant</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="application-content">
            <?php if (!empty($application['cover_letter'])): ?>
            <div class="application-card">
                <h2>Cover Letter</h2>
                <div class="cover-letter">
                    <?= nl2br(htmlspecialchars($application['cover_letter'])) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($application['resume_path'])): ?>
            <div class="application-card">
                <h2>Resume</h2>
                <div class="resume-preview">
                    <div class="file-download">
                        <a href="<?= SITE_URL . PUBLIC_PATH ?>/<?= $application['resume_path'] ?>" target="_blank" class="btn-document">
                            <i class="fa-solid fa-file-pdf"></i> View Resume
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>