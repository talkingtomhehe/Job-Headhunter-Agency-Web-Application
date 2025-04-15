<div class="dashboard-section">
    <div class="page-header">
        <div class="back-link">
            <a href="<?= SITE_URL ?>/employer/profile">
                <i class="fa-solid fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>
    
    <div class="profile-form-container">
        <div class="dashboard-card profile-form-card">
            <div class="card-header">
                <h2>Company Information</h2>
            </div>
            
            <div class="card-body">
                <form action="<?= SITE_URL ?>/employer/profile/update" method="POST" enctype="multipart/form-data" class="profile-edit-form">
                    <div class="form-grid">
                        <div class="form-column">
                            <div class="form-group">
                                <label for="company_name">Company Name <span class="required">*</span></label>
                                <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($company['company_name']) ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="headquarters_address">Location <span class="required">*</span></label>
                                <input type="text" id="headquarters_address" name="headquarters_address" value="<?= htmlspecialchars($company['headquarters_address'] ?? '') ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="website">Website URL</label>
                                <input type="url" id="website" name="website" value="<?= htmlspecialchars($company['website'] ?? '') ?>" placeholder="https://example.com">
                            </div>
                            
                            <div class="form-group">
                                <label for="industry">Industry</label>
                                <input type="text" id="industry" name="industry" value="<?= htmlspecialchars($company['industry'] ?? '') ?>" placeholder="e.g. Technology, Healthcare, Finance">
                            </div>
                            
                            <div class="form-group">
                                <label for="company_size">Company Size</label>
                                <select id="company_size" name="company_size">
                                    <option value="">Select company size</option>
                                    <option value="1-10" <?= ($company['company_size'] ?? '') == '1-10' ? 'selected' : '' ?>>1-10 employees</option>
                                    <option value="11-50" <?= ($company['company_size'] ?? '') == '11-50' ? 'selected' : '' ?>>11-50 employees</option>
                                    <option value="51-200" <?= ($company['company_size'] ?? '') == '51-200' ? 'selected' : '' ?>>51-200 employees</option>
                                    <option value="201-500" <?= ($company['company_size'] ?? '') == '201-500' ? 'selected' : '' ?>>201-500 employees</option>
                                    <option value="501-1000" <?= ($company['company_size'] ?? '') == '501-1000' ? 'selected' : '' ?>>501-1000 employees</option>
                                    <option value="1001+" <?= ($company['company_size'] ?? '') == '1001+' ? 'selected' : '' ?>>1001+ employees</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-column">
                            <div class="form-group logo-upload-group">
                                <label>Company Logo</label>
                                <div class="logo-upload-container">
                                    <div class="logo-preview-wrapper">
                                        <?php 
                                        $logoPath = !empty($company['logo_path']) ? $company['logo_path'] : 'uploads/logo/defaultlogo.jpg';
                                        ?>
                                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $logoPath ?>" alt="Company Logo" class="logo-preview" id="logoPreview">
                                    </div>
                                    <div class="logo-upload-actions">
                                        <div class="file-upload-wrapper">
                                            <input type="file" id="logo" name="logo" class="file-upload-input" accept="image/*">
                                            <label for="logo" class="file-upload-btn">
                                                <i class="fa-solid fa-upload"></i> Choose Logo
                                            </label>
                                        </div>
                                        <span class="upload-info">Recommended size: 400x400px, JPEG/PNG</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Company Description</label>
                                <textarea id="description" name="description" rows="8" placeholder="Tell potential applicants about your company..."><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
                                <p class="help-text">Describe your company's mission, values, and what makes it a great place to work.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        <a href="<?= SITE_URL ?>/employer/profile" class="btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logo preview functionality
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    
    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // If preview is currently showing the "No logo" placeholder
                    if (logoPreview.classList.contains('empty')) {
                        logoPreview.innerHTML = ''; // Clear placeholder content
                        logoPreview.classList.remove('empty');
                        
                        // Create image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('logo-preview');
                        logoPreview.appendChild(img);
                    } else {
                        // Just update the existing image
                        const img = logoPreview.querySelector('img');
                        if (img) {
                            img.src = e.target.result;
                        }
                    }
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Logo preview functionality
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    
    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Update the logo preview with the selected image
                    logoPreview.src = e.target.result;
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>