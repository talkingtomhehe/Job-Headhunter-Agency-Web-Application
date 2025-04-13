<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/employer/jobs">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Listings
        </a>
    </div>
</div>

<div class="job-form-container">
    <form action="<?= SITE_URL ?>/employer/jobs/update" method="POST" class="job-form" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
        
        <div class="form-section">
            <h3>Basic Information</h3>
            
            <div class="form-group">
                <label for="title">Job Title <span class="required">*</span></label>
                <input type="text" id="title" name="title" required value="<?= htmlspecialchars($job['title']) ?>" placeholder="e.g. Senior Software Engineer">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category_id">Job Category <span class="required">*</span></label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>" <?= isset($job['category_id']) && $job['category_id'] == $category['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="employment_type">Employment Type <span class="required">*</span></label>
                    <select id="employment_type" name="employment_type" required>
                        <option value="">Select employment type</option>
                        <option value="Full-time" <?= $job['job_type'] == 'Full-time' ? 'selected' : '' ?>>Full Time</option>
                        <option value="Part-time" <?= $job['job_type'] == 'Part-time' ? 'selected' : '' ?>>Part Time</option>
                        <option value="Contract" <?= $job['job_type'] == 'Contract' ? 'selected' : '' ?>>Contract</option>
                        <option value="Internship" <?= $job['job_type'] == 'Internship' ? 'selected' : '' ?>>Internship</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="work_model">Work Model <span class="required">*</span></label>
                    <select id="work_model" name="work_model" required>
                        <option value="">Select work model</option>
                        <?php foreach ($workModels as $model): ?>
                            <option value="<?= $model['slug'] ?>" <?= isset($job['work_model']) && $job['work_model'] == $model['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($model['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="experience_level">Experience Level <span class="required">*</span></label>
                    <select id="experience_level" name="experience_level" required>
                        <option value="">Select experience level</option>
                        <?php foreach ($experienceLevels as $level): ?>
                            <option value="<?= $level['slug'] ?>" <?= isset($job['experience_level']) && $job['experience_level'] == $level['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($level['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="job_pdf">Job Description PDF</label>
                <?php if(!empty($job['pdf_path'])): ?>
                    <div class="current-file">
                        <p>Current file: <a href="<?= SITE_URL . PUBLIC_PATH . '/' . $job['pdf_path'] ?>" target="_blank">View PDF</a></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="job_pdf" name="job_pdf" accept=".pdf" class="file-input">
                <small class="form-help">Upload a new PDF to replace the current one (max 5MB)</small>
            </div>
            
            <div class="form-group">
                <label for="location">Location <span class="required">*</span></label>
                <input type="text" id="location" name="location" required value="<?= htmlspecialchars($job['location']) ?>" placeholder="e.g. New York, NY">
            </div>
        </div>
        
        <div class="form-section">
            <h3>Compensation</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="salary_min">Minimum Salary</label>
                    <div class="input-with-icon">
                        <span class="input-icon">$</span>
                        <input type="number" id="salary_min" name="salary_min" value="<?= !empty($job['salary_min']) ? htmlspecialchars($job['salary_min']) : '' ?>" placeholder="e.g. 50000">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="salary_max">Maximum Salary</label>
                    <div class="input-with-icon">
                        <span class="input-icon">$</span>
                        <input type="number" id="salary_max" name="salary_max" value="<?= !empty($job['salary_max']) ? htmlspecialchars($job['salary_max']) : '' ?>" placeholder="e.g. 80000">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="hide_salary" name="hide_salary" value="1" <?= isset($job['hide_salary']) && $job['hide_salary'] ? 'checked' : '' ?>>
                    <label for="hide_salary">Hide salary from job listing</label>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>Job Details</h3>
            
            <div class="form-group">
                <label for="description">Job Description <span class="required">*</span></label>
                <textarea id="description" name="description" rows="6" required placeholder="Describe the job role, responsibilities, and your company..."><?= htmlspecialchars($job['description']) ?></textarea>
                <small class="form-help">Be specific about the job's responsibilities, projects, and teams.</small>
            </div>
            
            <div class="form-group">
                <label for="requirements">Requirements <span class="required">*</span></label>
                <textarea id="requirements" name="requirements" rows="6" required placeholder="List the skills, qualifications, and experience required..."><?= htmlspecialchars($job['requirements']) ?></textarea>
                <small class="form-help">List the technical skills, qualifications, and experience you're looking for.</small>
            </div>
            
            <div class="form-group">
                <label for="benefits">Benefits</label>
                <textarea id="benefits" name="benefits" rows="4" placeholder="List the benefits, perks, and advantages..."><?= isset($job['benefits']) ? htmlspecialchars($job['benefits']) : '' ?></textarea>
                <small class="form-help">Highlight benefits like health insurance, remote work, flexible hours, etc.</small>
            </div>
            
            <div class="form-group">
                <label for="application_deadline">Application Deadline</label>
                <input type="date" id="application_deadline" name="application_deadline" value="<?= isset($job['application_deadline']) ? htmlspecialchars($job['application_deadline']) : '' ?>">
            </div>
        </div>

        <div class="form-section">
            <h3>Job Status</h3>
            <div class="form-group status-buttons">
                <div class="radio-button">
                    <input type="radio" id="status_active" name="status" value="active" <?= $job['status'] == 'active' ? 'checked' : '' ?>>
                    <label for="status_active">Active</label>
                </div>
                <div class="radio-button">
                    <input type="radio" id="status_pending" name="status" value="pending" <?= $job['status'] == 'pending' ? 'checked' : '' ?>>
                    <label for="status_pending">Draft</label>
                </div>
                <div class="radio-button">
                    <input type="radio" id="status_closed" name="status" value="closed" <?= $job['status'] == 'closed' ? 'checked' : '' ?>>
                    <label for="status_closed">Closed</label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" name="publish" value="1" class="btn-primary">Update Job</button>
            <a href="<?= SITE_URL ?>/employer/jobs" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>