<div class="dashboard-section">
    <div class="section-header">
        <div class="section-actions">
            <button type="button" id="editProfileBtn" class="btn-primary">
                <i class="fa-solid fa-pencil"></i> Edit Profile
            </button>
        </div>
    </div>
    
    <div class="profile-container">
        <div class="dashboard-card profile-card">
            <div class="card-header">
                <h2>Company Information</h2>
            </div>
            <div class="card-body">
                <div class="company-header">
                    <div class="company-logo-container">
                        <?php if (!empty($company['logo_path'])): ?>
                            <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $company['logo_path'] ?>" alt="<?= htmlspecialchars($company['company_name']) ?>" class="company-logo">
                        <?php else: ?>
                            <div class="company-logo-placeholder">
                                <?= substr($company['company_name'], 0, 1) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="company-basic-info">
                        <h1 class="company-name"><?= htmlspecialchars($company['company_name']) ?></h1>
                        <p class="company-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($company['location']) ?></p>
                        <?php if (!empty($company['website'])): ?>
                            <p class="company-website"><i class="fa-solid fa-globe"></i> <a href="<?= htmlspecialchars($company['website']) ?>" target="_blank"><?= htmlspecialchars($company['website']) ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="profile-section">
                    <h3>About the Company</h3>
                    <div class="profile-content">
                        <?php if (!empty($company['description'])): ?>
                            <p><?= nl2br(htmlspecialchars($company['description'])) ?></p>
                        <?php else: ?>
                            <p class="empty-text">No company description available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Edit Profile Form (Initially Hidden) -->
        <div id="editProfileForm" class="dashboard-card profile-form-card" style="display: none;">
            <div class="card-header">
                <h2>Edit Company Profile</h2>
            </div>
            <div class="card-body">
                <form action="<?= SITE_URL ?>/employer/profile/update" method="POST" enctype="multipart/form-data">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($company['company_name']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" value="<?= htmlspecialchars($company['location']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="website">Website URL</label>
                            <input type="url" id="website" name="website" value="<?= htmlspecialchars($company['website'] ?? '') ?>" placeholder="https://example.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Company Description</label>
                            <textarea id="description" name="description" rows="6"><?= htmlspecialchars($company['description'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="logo">Company Logo</label>
                            <div class="file-upload-container">
                                <input type="file" id="logo" name="logo" class="custom-file-input" accept="image/*">
                                <label for="logo" class="custom-file-label"><?= !empty($company['logo_path']) ? basename($company['logo_path']) : 'Choose file' ?></label>
                            </div>
                            <?php if (!empty($company['logo_path'])): ?>
                                <div class="current-logo">
                                    <p>Current logo:</p>
                                    <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $company['logo_path'] ?>" alt="Current Logo" class="logo-preview">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" id="cancelEditBtn" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editProfileBtn = document.getElementById('editProfileBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const profileCard = document.querySelector('.profile-card');
    const editProfileForm = document.getElementById('editProfileForm');
    
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function() {
            profileCard.style.display = 'none';
            editProfileForm.style.display = 'block';
        });
    }
    
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            editProfileForm.style.display = 'none';
            profileCard.style.display = 'block';
        });
    }
    
    // File input preview for company logo
    const fileInput = document.getElementById('logo');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            const fileLabel = document.querySelector('.custom-file-label');
            if (fileName) {
                fileLabel.textContent = fileName;
            } else {
                fileLabel.textContent = 'Choose file';
            }
        });
    }
});
</script>