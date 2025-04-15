<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/jobs">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Listings
        </a>
    </div>
</div>

<div class="job-form-container">
    <form action="<?= SITE_URL ?>/admin/addJob" method="POST" class="job-form" enctype="multipart/form-data">
        <div class="form-section">
            <h3>Company & Employer Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="company_id">Company <span class="required">*</span></label>
                    <select id="company_id" name="company_id" required>
                        <option value="">Select a company</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?= $company['company_id'] ?>"><?= htmlspecialchars($company['company_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="employer_id">Employer <span class="required">*</span></label>
                    <select id="employer_id" name="employer_id" required>
                        <option value="">Select an employer</option>
                        <?php foreach ($employers as $employer): ?>
                            <option value="<?= $employer['user_id'] ?>"><?= htmlspecialchars($employer['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Basic Information</h3>
            
            <div class="form-group">
                <label for="title">Job Title <span class="required">*</span></label>
                <input type="text" id="title" name="title" required placeholder="e.g. Senior Software Engineer">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category_selector">Job Category <span class="required">*</span></label>
                    <select id="category_selector" onchange="toggleCategoryInput()">
                        <option value="existing">Select from existing categories</option>
                        <option value="new">Add a new category</option>
                    </select>
                </div>

                <div class="form-group" id="existing_category_group">
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" id="new_category_group" style="display:none;">
                    <input type="text" id="new_category" name="new_category" placeholder="Enter new category name">
                </div>
                
                <div class="form-group">
                    <label for="employment_type">Employment Type <span class="required">*</span></label>
                    <select id="employment_type" name="employment_type" required>
                        <option value="">Select employment type</option>
                        <option value="Full-time">Full Time</option>
                        <option value="Part-time">Part Time</option>
                        <option value="Contract">Contract</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="work_model">Work Model <span class="required">*</span></label>
                    <select name="work_model" id="work_model">
                        <option value="">Select Work Model</option>
                        <?php foreach ($workModels as $model): ?>
                            <option value="<?= $model['id'] ?>"><?= htmlspecialchars($model['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="experience_level">Experience Level <span class="required">*</span></label>
                    <select name="experience_level" id="experience_level">
                        <option value="">Select Experience Level</option>
                        <?php foreach ($experienceLevels as $level): ?>
                            <option value="<?= $level['id'] ?>"><?= htmlspecialchars($level['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="location">Location <span class="required">*</span></label>
                <input type="text" id="location" name="location" required placeholder="e.g. New York, NY">
            </div>
            
            <div class="form-group">
                <label for="job_pdf">Job Description PDF</label>
                <input type="file" id="job_pdf" name="job_pdf" accept=".pdf" class="file-input">
                <small class="form-help">Upload a PDF with detailed job description (max 5MB)</small>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Compensation</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="salary_min">Minimum Salary</label>
                    <div class="input-with-icon">
                        <span class="input-icon">$</span>
                        <input type="number" id="salary_min" name="salary_min" placeholder="e.g. 50000">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="salary_max">Maximum Salary</label>
                    <div class="input-with-icon">
                        <span class="input-icon">$</span>
                        <input type="number" id="salary_max" name="salary_max" placeholder="e.g. 80000">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="hide_salary" name="hide_salary" value="1">
                    <label for="hide_salary">Hide salary from job listing</label>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Job Details</h3>
            
            <div class="form-group">
                <label for="description">Job Description <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" required placeholder="Describe the job role, responsibilities, and your company..."></textarea>
                <small class="form-help">Be specific about the job's responsibilities, projects, and teams.</small>
            </div>
            
            <div class="form-group">
                <label for="requirements">Requirements <span class="required">*</span></label>
                <textarea id="requirements" name="requirements" rows="6" required placeholder="List the skills, qualifications, and experience required..."></textarea>
                <small class="form-help">List the technical skills, qualifications, and experience you're looking for.</small>
            </div>
            
            <div class="form-group">
                <label for="benefits">Benefits</label>
                <textarea id="benefits" name="benefits" rows="4" placeholder="List the benefits, perks, and advantages..."></textarea>
                <small class="form-help">Highlight benefits like health insurance, remote work, flexible hours, etc.</small>
            </div>
            
            <div class="form-group">
                <label for="application_deadline">Application Deadline</label>
                <input type="date" id="application_deadline" name="application_deadline">
            </div>
        </div>
        
        <div class="form-section">
            <h3>Status</h3>
            <div class="job-status-selector">
                <div class="status-option">
                    <input type="radio" id="status_active" name="status" value="active" checked class="status-radio">
                    <label for="status_active" class="status-label status-active">
                        <div class="status-icon">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                        <div class="status-info">
                            <span class="status-title">Active</span>
                            <span class="status-description">Job is published and visible to applicants</span>
                        </div>
                    </label>
                </div>
                
                <div class="status-option">
                    <input type="radio" id="status_draft" name="status" value="draft" class="status-radio">
                    <label for="status_draft" class="status-label status-draft">
                        <div class="status-icon">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="status-info">
                            <span class="status-title">Draft</span>
                            <span class="status-description">Save as draft to review or edit later</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary">Create Job</button>
            <a href="<?= SITE_URL ?>/admin/jobs" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
function toggleCategoryInput() {
    const selector = document.getElementById('category_selector');
    const existingGroup = document.getElementById('existing_category_group');
    const newGroup = document.getElementById('new_category_group');
    const categorySelect = document.getElementById('category_id');
    const newCategoryInput = document.getElementById('new_category');
    
    if (selector.value === 'new') {
        existingGroup.style.display = 'none';
        newGroup.style.display = 'block';
        categorySelect.removeAttribute('required');
        newCategoryInput.setAttribute('required', '');
    } else {
        existingGroup.style.display = 'block';
        newGroup.style.display = 'none';
        categorySelect.setAttribute('required', '');
        newCategoryInput.removeAttribute('required');
    }
}
</script>