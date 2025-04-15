<main>
    <section class="application-confirmation-section">
        <div class="container">
            <div class="confirmation-card">
                <div class="confirmation-icon">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                
                <h1 class="confirmation-title">Application Submitted!</h1>
                
                <p class="confirmation-message">
                    Thank you for applying to <strong><?= htmlspecialchars($job['title']) ?></strong> at 
                    <strong><?= htmlspecialchars($job['company_name']) ?></strong>.
                </p>
                
                <div class="confirmation-details">
                    <h2>What happens next?</h2>
                    <ol class="next-steps">
                        <li>The employer will review your application</li>
                        <li>If they're interested, they'll contact you directly using the contact information you provided</li>
                        <li>You may be asked to participate in interviews or further assessments</li>
                    </ol>
                </div>
                
                <div class="application-summary">
                    <h2>Application Summary</h2>
                    <div class="summary-item">
                        <span class="summary-label">Application ID:</span>
                        <span class="summary-value"><?= $applicationId ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Job Title:</span>
                        <span class="summary-value"><?= htmlspecialchars($job['title']) ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Company:</span>
                        <span class="summary-value"><?= htmlspecialchars($job['company_name']) ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Date Applied:</span>
                        <span class="summary-value"><?= date('F j, Y') ?></span>
                    </div>
                </div>
                
                <div class="confirmation-actions">
                    <a href="<?= SITE_URL ?>/jobs" class="btn-primary">Browse More Jobs</a>
                    <a href="<?= SITE_URL ?>" class="btn-secondary">Return to Home</a>
                </div>
                
                <div class="create-account-prompt">
                    <h3>Want to track your applications?</h3>
                    <p>Create an account to track the status of your applications, save jobs, and more.</p>
                    <a href="<?= SITE_URL ?>/auth?register=1" class="btn-outline">Create Account</a>
                </div>
            </div>
        </div>
    </section>
</main>