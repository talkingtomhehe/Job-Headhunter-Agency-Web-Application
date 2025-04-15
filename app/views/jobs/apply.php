<main>
    <section class="job-application-section">
        <div class="container">
            <!-- Back to job link -->
            <div class="back-link">
                <a href="<?= SITE_URL ?>/jobs/view/<?= $job['job_id'] ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Job
                </a>
            </div>
            
            <?php if (isset($job) && $job): ?>
                <div class="application-form-card">
                    <div class="job-summary">
                        <h2>Application for <?= htmlspecialchars($job['title']) ?></h2>
                        <p class="company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                        <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></p>
                    </div>

                    <form action="<?= SITE_URL ?>/jobs/submitApplication" method="POST" enctype="multipart/form-data" class="application-form">
                        <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                        
                        <div class="form-section">
                            <h3>Personal Information</h3>
                            
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Resume</h3>
                            
                            <div class="form-group">
                                <label for="resume">Upload Resume (PDF only) *</label>
                                <div class="file-upload-container">
                                    <input type="file" id="resume" name="resume" accept=".pdf" required class="file-input">
                                    <div class="file-upload-interface">
                                        <span class="file-name">No file chosen</span>
                                        <button type="button" class="file-upload-button">Browse</button>
                                    </div>
                                </div>
                                <small class="form-text">Maximum file size: 5MB</small>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3>Additional Information</h3>
                            
                            <div class="form-group">
                                <label for="cover_letter">Cover Letter (Optional)</label>
                                <textarea id="cover_letter" name="cover_letter" rows="5" placeholder="Introduce yourself and explain why you're a good fit for this position"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-submit">
                            <button type="submit" class="submit-button">Submit Application</button>
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
                } else {
                    fileName.textContent = 'No file chosen';
                }
            });
        }
    });
</script>