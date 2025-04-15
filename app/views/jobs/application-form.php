<main>
    <section class="job-application-section">
        <div class="container">
            <!-- Back to job link -->
            <div class="back-link">
                <a href="<?= SITE_URL ?>/jobs/view/<?= $job['job_id'] ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Job Details
                </a>
            </div>
            
            <?php if (isset($job) && $job): ?>
                <div class="application-form-card">
                    <div class="job-header">
                        <div class="company-logo">
                            <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                 alt="<?= htmlspecialchars($job['company_name']) ?>"
                                 onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                        </div>
                        <div class="job-title-container">
                            <h1>Apply for: <?= htmlspecialchars($job['title']) ?></h1>
                            <p class="company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                        </div>
                    </div>
                    
                    <form action="<?= SITE_URL ?>/jobs/submit-application" method="POST" enctype="multipart/form-data" class="application-form">
                        <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                        
                        <div class="form-section">
                            <h2 class="form-section-title">Personal Information</h2>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name <span class="required">*</span></label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="form-section-title">Resume & Cover Letter</h2>
                            
                            <div class="form-group">
                                <label for="resume">Resume (PDF) <span class="required">*</span></label>
                                <div class="file-upload-container">
                                    <input type="file" id="resume" name="resume" accept=".pdf" required>
                                    <div class="file-upload-button">
                                        <i class="fa-solid fa-upload"></i> Choose File
                                    </div>
                                    <div class="file-name">No file chosen</div>
                                </div>
                                <div class="file-size-limit">Maximum file size: 5MB</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cover_letter">Cover Letter (Optional)</label>
                                <textarea id="cover_letter" name="cover_letter" rows="5" placeholder="Tell us why you're interested in this position and what makes you a good fit..."></textarea>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2 class="form-section-title">Additional Information</h2>
                            
                            <div class="form-group">
                                <label for="linkedin">LinkedIn Profile (Optional)</label>
                                <input type="url" id="linkedin" name="linkedin" placeholder="https://www.linkedin.com/in/yourprofile">
                            </div>
                            
                            <div class="form-group">
                                <label for="portfolio">Portfolio Website (Optional)</label>
                                <input type="url" id="portfolio" name="portfolio" placeholder="https://www.yourportfolio.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="current_company">Current/Most Recent Company (Optional)</label>
                                <input type="text" id="current_company" name="current_company">
                            </div>
                            
                            <div class="form-group">
                                <label for="current_position">Current/Most Recent Position (Optional)</label>
                                <input type="text" id="current_position" name="current_position">
                            </div>
                            
                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="agreement" name="agreement" required>
                                <label for="agreement">I confirm that all the information provided is accurate and complete. <span class="required">*</span></label>
                            </div>
                        </div>
                        
                        <div class="form-buttons">
                            <button type="submit" class="submit-application-btn">Submit Application</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="error-message">
                    <h2>Job Not Found</h2>
                    <p>The job listing you're trying to apply for doesn't exist or has been removed.</p>
                    <a href="<?= SITE_URL ?>/jobs" class="btn-primary">Browse All Jobs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle file input display
        const fileInput = document.getElementById('resume');
        const fileName = document.querySelector('.file-name');
        const fileUploadButton = document.querySelector('.file-upload-button');
        
        if (fileInput && fileName && fileUploadButton) {
            fileUploadButton.addEventListener('click', function() {
                fileInput.click();
            });
            
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    fileName.textContent = fileInput.files[0].name;
                    
                    // Validate file type
                    const fileExtension = fileInput.files[0].name.split('.').pop().toLowerCase();
                    if (fileExtension !== 'pdf') {
                        alert('Please upload a PDF file only.');
                        fileInput.value = '';
                        fileName.textContent = 'No file chosen';
                        return;
                    }
                    
                    // Validate file size (5MB max)
                    if (fileInput.files[0].size > 5 * 1024 * 1024) {
                        alert('File size exceeds 5MB. Please upload a smaller file.');
                        fileInput.value = '';
                        fileName.textContent = 'No file chosen';
                    }
                } else {
                    fileName.textContent = 'No file chosen';
                }
            });
        }
    });
</script>