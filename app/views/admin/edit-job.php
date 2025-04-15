<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/jobs">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Listings
        </a>
    </div>
</div>

<div class="admin-job-view">
    <div class="dashboard-card">
        <div class="card-header">
            <h2><?= htmlspecialchars($job['title']) ?></h2>
            <div class="admin-status-info">
                <span class="status-badge admin-status-<?= strtolower($job['admin_status']) ?>">
                    <i class="fa-solid fa-<?= $job['admin_status'] === 'pending' ? 'clock' : ($job['admin_status'] === 'approved' ? 'check' : 'times') ?>"></i>
                    <?= ucfirst($job['admin_status']) ?>
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <form action="<?= SITE_URL ?>/admin/jobs/update" method="POST" class="job-form" enctype="multipart/form-data">
                <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                
                <div class="form-section">
                    <h3>Company & Employer Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company_id">Company</label>
                            <select id="company_id" name="company_id" disabled>
                                <option value="<?= $company['company_id'] ?>"><?= htmlspecialchars($company['company_name']) ?></option>
                            </select>
                            <input type="hidden" name="company_id" value="<?= $company['company_id'] ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="employer_id">Employer</label>
                            <select id="employer_id" name="employer_id" disabled>
                                <option value="<?= $employer['user_id'] ?>"><?= htmlspecialchars($employer['full_name']) ?></option>
                            </select>
                            <input type="hidden" name="employer_id" value="<?= $employer['user_id'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="title">Job Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" required value="<?= htmlspecialchars($job['title']) ?>" placeholder="e.g. Senior Software Engineer">
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
                                    <option value="<?= $category['category_id'] ?>" <?= (!empty($job['category_id']) && $job['category_id'] == $category['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                                
                                <?php if ($hasCustomCategory): ?>
                                    <option value="<?= $jobCategory['category_id'] ?>" selected><?= htmlspecialchars($jobCategory['name']) ?></option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group" id="new_category_group" style="display:none;">
                            <input type="text" id="new_category" name="new_category" placeholder="Enter new category name">
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
                            <select name="work_model" id="work_model">
                                <option value="">Select Work Model</option>
                                <?php foreach ($workModels as $model): ?>
                                    <option value="<?= $model['id'] ?>" <?= (!empty($job['work_model']) && $job['work_model'] == $model['id']) ? 'selected' : '' ?>><?= htmlspecialchars($model['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="experience_level">Experience Level <span class="required">*</span></label>
                            <select name="experience_level" id="experience_level">
                                <option value="">Select Experience Level</option>
                                <?php foreach ($experienceLevels as $level): ?>
                                    <option value="<?= $level['id'] ?>" <?= (!empty($job['experience_level']) && $job['experience_level'] == $level['id']) ? 'selected' : '' ?>><?= htmlspecialchars($level['name']) ?></option>
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
                    <h3>Admin Status</h3>
                    <div class="job-status-selector">
                        <div class="status-option">
                            <input type="radio" id="admin_status_pending" name="admin_status" value="pending" <?= $job['admin_status'] == 'pending' ? 'checked' : '' ?> class="status-radio">
                            <label for="admin_status_pending" class="status-label status-pending">
                                <div class="status-icon">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="status-info">
                                    <span class="status-title">Pending Review</span>
                                    <span class="status-description">Job needs admin review before going live</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="status-option">
                            <input type="radio" id="admin_status_approved" name="admin_status" value="approved" <?= $job['admin_status'] == 'approved' ? 'checked' : '' ?> class="status-radio">
                            <label for="admin_status_approved" class="status-label status-active">
                                <div class="status-icon">
                                    <i class="fa-solid fa-check-circle"></i>
                                </div>
                                <div class="status-info">
                                    <span class="status-title">Approved</span>
                                    <span class="status-description">Job is visible to job seekers</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="status-option">
                            <input type="radio" id="admin_status_rejected" name="admin_status" value="rejected" <?= $job['admin_status'] == 'rejected' ? 'checked' : '' ?> class="status-radio">
                            <label for="admin_status_rejected" class="status-label status-rejected">
                                <div class="status-icon">
                                    <i class="fa-solid fa-times-circle"></i>
                                </div>
                                <div class="status-info">
                                    <span class="status-title">Rejected</span>
                                    <span class="status-description">Job has been rejected by admin</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Update Job</button>
                    <a href="<?= SITE_URL ?>/admin/jobs" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
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