<main>
    <section class="jd-application-section">
        <div class="container back-button-container">
            <!-- Back to job link -->
            <div class="jd-back-link">
                <a href="<?= SITE_URL ?>/job/viewJob/<?= $job['job_id'] ?>" class="jd-btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Job
                </a>
            </div>
        </div>
        
        <div class="container form-container">
            <?php if (isset($job) && $job): ?>
                <div class="jd-application-form-card">
                    <div class="jd-job-summary">
                        <div class="jd-summary-header">
                            <div class="jd-company-logo">
                                <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                    alt="<?= htmlspecialchars($job['company_name']) ?>"
                                    onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                            </div>
                            <div class="jd-summary-info">
                                <h2>Application for <?= htmlspecialchars($job['title']) ?></h2>
                                <p class="jd-company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                                <div class="jd-job-meta">
                                    <p class="jd-job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></p>
                                    <p class="jd-job-type"><i class="fa-solid fa-briefcase"></i> <?= htmlspecialchars($job['job_type']) ?></p>
                                    <?php if (!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                                    <p class="jd-job-salary"><i class="fa-solid fa-money-bill"></i> <?= call_user_func($formatSalary, $job['salary_min'], $job['salary_max']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="jd-application-steps">
                            <div class="jd-step current">
                                <div class="jd-step-number">1</div>
                                <div class="jd-step-label">Complete Application</div>
                            </div>
                            <div class="jd-step-connector"></div>
                            <div class="jd-step">
                                <div class="jd-step-number">2</div>
                                <div class="jd-step-label">Application Review</div>
                            </div>
                            <div class="jd-step-connector"></div>
                            <div class="jd-step">
                                <div class="jd-step-number">3</div>
                                <div class="jd-step-label">Interview Process</div>
                            </div>
                        </div>
                    </div>

                    <form action="<?= SITE_URL ?>/job/submitApplication" method="POST" enctype="multipart/form-data" class="jd-application-form">
                        <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                        
                        <div class="jd-form-section">
                            <h3>Personal Information</h3>
                            
                            <div class="jd-form-row">
                                <div class="jd-form-group">
                                    <label for="full_name">Full Name <span class="jd-required">*</span></label>
                                    <input type="text" id="full_name" name="full_name" required>
                                </div>
                                
                                <div class="jd-form-group">
                                    <label for="email">Email Address <span class="jd-required">*</span></label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="jd-form-row">
                                <div class="jd-form-group">
                                    <label for="phone">Phone Number <span class="jd-required">*</span></label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                                
                                <div class="jd-form-group">
                                    <label for="location">Current Location</label>
                                    <input type="text" id="location" name="location">
                                </div>
                            </div>
                        </div>
                        
                        <div class="jd-form-section">
                            <h3>Professional Experience</h3>
                            
                            <div class="jd-form-row">
                                <div class="jd-form-group">
                                    <label for="years_experience">Years of Experience</label>
                                    <select id="years_experience" name="years_experience">
                                        <option value="">Select years of experience</option>
                                        <option value="0-1">Less than 1 year</option>
                                        <option value="1-2">1-2 years</option>
                                        <option value="3-5">3-5 years</option>
                                        <option value="5-10">5-10 years</option>
                                        <option value="10+">10+ years</option>
                                    </select>
                                </div>
                                
                                <div class="jd-form-group">
                                    <label for="current_position">Current/Most Recent Position</label>
                                    <input type="text" id="current_position" name="current_position" placeholder="e.g., Software Developer at XYZ Company">
                                </div>
                            </div>
                            
                            <div class="jd-form-group">
                                <label for="skills">Key Skills (comma separated)</label>
                                <input type="text" id="skills" name="skills" placeholder="e.g., JavaScript, React, PHP, SQL">
                            </div>
                        </div>
                        
                        <div class="jd-form-section">
                            <h3>Resume</h3>
                            
                            <div class="jd-form-group">
                                <label for="resume">Upload Resume (PDF only) <span class="jd-required">*</span></label>
                                <div class="jd-file-upload-container">
                                    <input type="file" id="resume" name="resume" accept=".pdf" required class="jd-file-input">
                                    <div class="jd-file-upload-interface">
                                        <span class="jd-file-name">No file chosen</span>
                                        <button type="button" class="jd-file-upload-button">Browse</button>
                                    </div>
                                </div>
                                <small class="jd-form-text">Maximum file size: 5MB</small>
                            </div>
                        </div>
                        
                        <div class="jd-form-section">
                            <h3>Cover Letter / Additional Information</h3>
                            
                            <div class="jd-form-group">
                                <label for="cover_letter">Cover Letter (Optional)</label>
                                <textarea id="cover_letter" name="cover_letter" rows="5" placeholder="Introduce yourself and explain why you're a good fit for this position"></textarea>
                            </div>
                            
                            <div class="jd-form-group">
                                <label for="source">How did you hear about this job?</label>
                                <select id="source" name="source">
                                    <option value="direct">Huntly Job Board</option>
                                    <option value="social_media">Social Media</option>
                                    <option value="search_engine">Search Engine</option>
                                    <option value="referral">Referral</option>
                                    <option value="company_website">Company Website</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="jd-form-privacy">
                            <div class="jd-checkbox-container">
                                <input type="checkbox" id="privacy_agreement" name="privacy_agreement" required>
                                <label for="privacy_agreement">I agree to the processing of my personal data in accordance with the <a href="#" target="_blank">Privacy Policy</a> <span class="jd-required">*</span></label>
                            </div>
                        </div>
                        
                        <div class="jd-form-submit">
                            <button type="submit" class="jd-submit-button">Submit Application</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="jd-job-not-found">
                    <h2>Job Not Found</h2>
                    <p>The job listing you're trying to apply for doesn't exist or has been removed.</p>
                    <a href="<?= SITE_URL ?>/job" class="jd-btn-primary">Browse All Jobs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle file input display
    const fileInput = document.getElementById('resume');
    const fileName = document.querySelector('.jd-file-name');
    const fileUploadButton = document.querySelector('.jd-file-upload-button');
    
    if (fileInput && fileName && fileUploadButton) {
        fileUploadButton.addEventListener('click', function() {
            fileInput.click();
        });
        
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
                fileName.classList.add('file-selected');
            } else {
                fileName.textContent = 'No file chosen';
                fileName.classList.remove('file-selected');
            }
        });
    }
    
    // Form validation
    const applicationForm = document.querySelector('.jd-application-form');
    
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            let isValid = true;
            const fullName = document.getElementById('full_name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const resume = document.getElementById('resume');
            const privacyAgreement = document.getElementById('privacy_agreement');
            
            // Reset previous error messages
            const errorMessages = document.querySelectorAll('.jd-error-message');
            errorMessages.forEach(el => el.remove());
            
            // Reset error styling
            document.querySelectorAll('.jd-form-group.error').forEach(el => {
                el.classList.remove('error');
            });
            
            // Validate required fields
            if (!fullName.value.trim()) {
                showError(fullName, 'Full name is required');
                isValid = false;
            }
            
            if (!email.value.trim()) {
                showError(email, 'Email address is required');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError(email, 'Please enter a valid email address');
                isValid = false;
            }
            
            if (!phone.value.trim()) {
                showError(phone, 'Phone number is required');
                isValid = false;
            }
            
            if (!resume.files.length) {
                showError(resume.parentElement, 'Resume is required');
                isValid = false;
            } else if (resume.files[0].size > 5 * 1024 * 1024) { // 5MB limit
                showError(resume.parentElement, 'File size must be less than 5MB');
                isValid = false;
            }
            
            if (!privacyAgreement.checked) {
                showError(privacyAgreement.parentElement, 'You must agree to the privacy policy');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to the first error
                const firstError = document.querySelector('.jd-error-message');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
    
    // Show error message for a form element
    function showError(element, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'jd-error-message';
        errorElement.textContent = message;
        
        // Add error class to parent form-group
        const formGroup = element.closest('.jd-form-group') || element.parentElement;
        formGroup.classList.add('error');
        
        // Place error message appropriately
        if (element.classList.contains('jd-file-upload-container')) {
            element.parentElement.appendChild(errorElement);
        } else {
            formGroup.appendChild(errorElement);
        }
    }
    
    // Email validation function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>