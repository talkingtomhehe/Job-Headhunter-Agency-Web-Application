<div class="company-header">
    <div class="company-banner"></div>
    <div class="company-info">
        <div class="company-logo">
            <?php if ($company['logo_path']): ?>
                <img src="<?php echo BASE_URL . '/public/' . ltrim($company['logo_path'], '/'); ?>"
                     alt="<?php echo htmlspecialchars($company['company_name']); ?> logo">
            <?php else: ?>
                <div class="no-logo">
                    <?php echo strtoupper(substr($company['company_name'] ?? 'A', 0, 1)); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="company-title">
            <h1 class="company-name"><?php echo htmlspecialchars($company['company_name']); ?></h1>
            <?php if ($company['headquarters_address']): ?>
                <div class="company-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo htmlspecialchars($company['headquarters_address']); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <button class="share-button">
            <i class="fas fa-share-alt"></i>
            Share
        </button>
    </div>

    <div class="company-tabs">
        <a href="<?php echo BASE_URL; ?>/public/?page=company-detail&id=<?php echo $company['company_id']; ?>"
           class="tab <?php echo !isset($_GET['tab']) || $_GET['tab'] === 'home' ? 'active' : ''; ?>">
            Home
        </a>
        <a href="<?php echo BASE_URL; ?>/public/?page=company-detail&id=<?php echo $company['company_id']; ?>&tab=about"
           class="tab <?php echo isset($_GET['tab']) && $_GET['tab'] === 'about' ? 'active' : ''; ?>">
            About
        </a>
        <a href="<?php echo BASE_URL; ?>/public/?page=company-detail&id=<?php echo $company['company_id']; ?>&tab=jobs"
           class="tab <?php echo isset($_GET['tab']) && $_GET['tab'] === 'jobs' ? 'active' : ''; ?>">
            Jobs
        </a>
    </div>
</div>