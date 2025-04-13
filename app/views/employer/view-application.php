<div class="application-view-container">
    <div class="page-header">
        <div class="back-link">
            <a href="<?= SITE_URL ?>/employer/applications">
                <i class="fa-solid fa-arrow-left"></i> Back to Applications
            </a>
        </div>
        <h1>Application Details</h1>
    </div>
    
    <div class="application-status-bar">
        <div class="status-info">
            <span class="status-label">Current Status:</span>
            <span class="status-badge status-<?= strtolower($application['status']) ?>">
                <?= ucfirst($application['status']) ?>
            </span>
        </div>
        
        <div class="status-actions">
            <form action="<?= SITE_URL ?>/employer/applications/status" method="POST" class="status-form">
                <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                
                <div class="status-buttons">
                    <button type="submit" name="status" value="pending" class="status-btn <?= $application['status'] == 'pending' ? 'active' : '' ?>">
                        Pending
                    </button>
                    <button type="submit" name="status" value="reviewing" class="status-btn <?= $application['status'] == 'reviewing' ? 'active' : '' ?>">
                        Reviewing
                    </button>
                    <button type="submit" name="status" value="shortlisted" class="status-btn <?= $application['status'] == 'shortlisted' ? 'active' : '' ?>">
                        Shortlisted
                    </button>
                    <button type="submit" name="status" value="rejected" class="status-btn <?= $application['status'] == 'rejected' ? 'active' : '' ?>">
                        Rejected
                    </button>
                    <button type="submit" name="status" value="hired" class="status-btn <?= $application['status'] == 'hired' ? 'active' : '' ?>">
                        Hired
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="application-grid">
        <div class="application-details">
            <div class="application-card">
                <h2 class="card-title">Applicant Information</h2>
                <div class="applicant-profile">
                    <div class="applicant-avatar large">
                        <?= substr($application['full_name'], 0, 1) ?>
                    </div>
                    <div class="applicant-details">
                        <h3><?= htmlspecialchars($application['full_name']) ?></h3>
                        <div class="contact-info">
                            <p><i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($application['email']) ?></p>
                            <?php if (!empty($application['phone'])): ?>
                            <p><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($application['phone']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="application-card">
                <h2 class="card-title">Job Details</h2>
                <div class="job-details">
                    <h3><?= htmlspecialchars($application['job_title']) ?></h3>
                    <p class="job-meta">
                        <i class="fa-solid fa-calendar"></i> Posted: <?= date('F d, Y', strtotime($application['job_created_at'])) ?>
                    </p>
                </div>
            </div>
            
            <div class="application-card">
                <h2 class="card-title">Application Timeline</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date"><?= date('M d, Y', strtotime($application['created_at'])) ?></div>
                        <div class="timeline-content">
                            <h4>Application Submitted</h4>
                            <p>The candidate applied for this position</p>
                        </div>
                    </div>
                    
                    <?php if (!empty($application['updated_at']) && $application['updated_at'] != $application['created_at']): ?>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date"><?= date('M d, Y', strtotime($application['updated_at'])) ?></div>
                        <div class="timeline-content">
                            <h4>Status Updated</h4>
                            <p>Application status changed to <?= ucfirst($application['status']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="application-content">
            <?php if (!empty($application['cover_letter'])): ?>
            <div class="application-card">
                <h2 class="card-title">Cover Letter</h2>
                <div class="cover-letter">
                    <?= nl2br(htmlspecialchars($application['cover_letter'])) ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($application['resume_path'])): ?>
            <div class="application-card">
                <h2 class="card-title">Resume</h2>
                <div class="resume-preview">
                    <?php
                    $extension = pathinfo($application['resume_path'], PATHINFO_EXTENSION);
                    if (strtolower($extension) === 'pdf'): 
                    ?>
                        <div class="pdf-preview">
                            <object data="<?= SITE_URL . PUBLIC_PATH . '/' . $application['resume_path'] ?>" type="application/pdf" width="100%" height="600">
                                <p>It appears your browser doesn't support embedded PDFs. You can 
                                <a href="<?= SITE_URL . PUBLIC_PATH . '/' . $application['resume_path'] ?>" target="_blank">download the PDF</a> instead.</p>
                            </object>
                        </div>
                    <?php else: ?>
                        <div class="file-download">
                            <i class="fa-solid fa-file"></i>
                            <a href="<?= SITE_URL . PUBLIC_PATH . '/' . $application['resume_path'] ?>" target="_blank" class="btn-primary">
                                Download Resume
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="application-card">
                <h2 class="card-title">Actions</h2>
                <div class="action-buttons">
                    <a href="mailto:<?= htmlspecialchars($application['email']) ?>" class="btn-primary">
                        <i class="fa-solid fa-envelope"></i> Email Candidate
                    </a>
                    
                    <a href="#" class="btn-secondary" id="emailSelectBtn">
                        <i class="fa-solid fa-paper-plane"></i> Send Template Email
                    </a>
                </div>
                
                <!-- Email Template Selector (Initially Hidden) -->
                <div id="emailTemplates" class="email-templates" style="display: none;">
                    <h3>Select Email Template</h3>
                    <div class="template-options">
                        <div class="template-option">
                            <input type="radio" name="emailTemplate" id="template1" value="interview">
                            <label for="template1">Interview Invitation</label>
                        </div>
                        <div class="template-option">
                            <input type="radio" name="emailTemplate" id="template2" value="shortlisted">
                            <label for="template2">Shortlisted Notification</label>
                        </div>
                        <div class="template-option">
                            <input type="radio" name="emailTemplate" id="template3" value="rejected">
                            <label for="template3">Rejection Notice</label>
                        </div>
                        <div class="template-option">
                            <input type="radio" name="emailTemplate" id="template4" value="custom">
                            <label for="template4">Custom Message</label>
                        </div>
                    </div>
                    
                    <div id="customTemplate" class="custom-template" style="display: none;">
                        <textarea rows="5" placeholder="Enter your custom message..."></textarea>
                    </div>
                    
                    <div class="template-actions">
                        <button class="btn-secondary" id="cancelEmailBtn">Cancel</button>
                        <button class="btn-primary" id="sendEmailBtn">Send Email</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Email template functionality
    const emailSelectBtn = document.getElementById('emailSelectBtn');
    const emailTemplates = document.getElementById('emailTemplates');
    const cancelEmailBtn = document.getElementById('cancelEmailBtn');
    const sendEmailBtn = document.getElementById('sendEmailBtn');
    const customTemplate = document.getElementById('customTemplate');
    const templateOptions = document.querySelectorAll('input[name="emailTemplate"]');
    
    if (emailSelectBtn) {
        emailSelectBtn.addEventListener('click', function(e) {
            e.preventDefault();
            emailTemplates.style.display = 'block';
            this.style.display = 'none';
        });
    }
    
    if (cancelEmailBtn) {
        cancelEmailBtn.addEventListener('click', function() {
            emailTemplates.style.display = 'none';
            emailSelectBtn.style.display = 'inline-flex';
            customTemplate.style.display = 'none';
            // Reset radio buttons
            templateOptions.forEach(option => {
                option.checked = false;
            });
        });
    }
    
    templateOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'custom') {
                customTemplate.style.display = 'block';
            } else {
                customTemplate.style.display = 'none';
            }
        });
    });
    
    if (sendEmailBtn) {
        sendEmailBtn.addEventListener('click', function() {
            // Here you would implement the email sending functionality
            // For now, just show a success message
            let selectedTemplate = '';
            templateOptions.forEach(option => {
                if (option.checked) {
                    selectedTemplate = option.value;
                }
            });
            
            if (selectedTemplate) {
                alert('Email template "' + selectedTemplate + '" has been sent to the candidate.');
                emailTemplates.style.display = 'none';
                emailSelectBtn.style.display = 'inline-flex';
                customTemplate.style.display = 'none';
                // Reset radio buttons
                templateOptions.forEach(option => {
                    option.checked = false;
                });
            } else {
                alert('Please select an email template');
            }
        });
    }
});
</script>