<main>
    <!-- Hero Section with SVG background -->
    <section class="hero-banner">
        <div class="image-container">
        <img src="/huntlyversion2/public/assets/images/home_image.svg" alt="Hero Background" class="hero-image">
            <div class="image-overlay"></div>
        </div>
    
        <!-- Hero search section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Bridging the gap between Talent and Opportunity!</h1>
                
                <div class="search-form-container">
                    <form class="search-form" action="/huntlyversion2/public/search.php" method="GET">
                        <div class="search-inputs">
                            <div class="input-group">
                                <i class="fa-solid fa-briefcase"></i>
                                <input type="text" name="keyword" placeholder="Job title or Company">
                            </div>
                            
                            <div class="input-group">
                                <i class="fa-solid fa-location-dot"></i>
                                <input type="text" name="location" placeholder="City, State">
                            </div>
                            
                            <div class="input-group">
                                <i class="fa-solid fa-house"></i>
                                <select name="work_model">
                                    <option value="">Work model</option>
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="onsite">On-site</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <i class="fa-solid fa-building"></i>
                                <select name="categories">
                                    <option value="">Categories</option>
                                    <option value="remote">...</option>
                                    <option value="hybrid">...</option>
                                    <option value="onsite">...</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="search-button-container">
                            <button type="submit" class="search-button">Find Jobs</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Jobs Section -->
    <section class="recent-jobs">
        <div class="container">
            <h2 class="section-title">RECENT JOBS<span class="title-underline"></span></h2>
            
            <div class="jobs-container">
                <!-- Job Item -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">
                            <img src="/huntlyversion2/public/assets/images/logo.png" alt="Company Logo" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                        </div>
                        <div class="job-info">
                            <h3 class="job-title">Senior Software Engineer</h3>
                            <p class="company-name">Tech Solutions Inc.</p>
                            <div class="job-tags">
                                <span class="job-tag">Hybrid</span>
                                <span class="job-tag">Full-stack</span>
                                <span class="job-tag">Senior</span>
                            </div>
                        </div>
                        <div class="job-meta">
                            <p class="job-location"><i class="fa-solid fa-location-dot"></i> New York, NY</p>
                            <p class="job-salary"><i class="fa-solid fa-money-bill"></i> $120K - $150K</p>
                        </div>
                    </div>
                </div>
                
                <!-- Job Item -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">
                            <img src="/huntlyversion2/public/assets/images/logo.png" alt="Company Logo" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                        </div>
                        <div class="job-info">
                            <h3 class="job-title">Data Scientist</h3>
                            <p class="company-name">Analytics Experts</p>
                            <div class="job-tags">
                                <span class="job-tag">Remote</span>
                                <span class="job-tag">Data Science</span>
                                <span class="job-tag">ML</span>
                            </div>
                        </div>
                        <div class="job-meta">
                            <p class="job-location"><i class="fa-solid fa-location-dot"></i> Remote</p>
                            <p class="job-salary"><i class="fa-solid fa-money-bill"></i> $90K - $120K</p>
                        </div>
                    </div>
                </div>
                
                <!-- Job Item -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">
                            <img src="/huntlyversion2/public/assets/images/logo.png" alt="Company Logo" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                        </div>
                        <div class="job-info">
                            <h3 class="job-title">Marketing Manager</h3>
                            <p class="company-name">Brand Masters</p>
                            <div class="job-tags">
                                <span class="job-tag">On-site</span>
                                <span class="job-tag">Marketing</span>
                                <span class="job-tag">Leadership</span>
                            </div>
                        </div>
                        <div class="job-meta">
                            <p class="job-location"><i class="fa-solid fa-location-dot"></i> San Francisco, CA</p>
                            <p class="job-salary"><i class="fa-solid fa-money-bill"></i> $85K - $110K</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- Top Companies Section -->
    <section class="top-companies">
        <div class="container">
            <h2 class="section-title">TOP COMPANIES REGISTERED<span class="title-underline"></span></h2>
            
            <div class="companies-container">
                <!-- Company Item -->
                <div class="company-card">
                    <div class="company-logo-large">
                        <img src="/huntlyversion2/public/assets/images/logo.png" alt="Microsoft" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                    </div>
                    <h3 class="company-title">Microsoft</h3>
                    <p class="company-location"><i class="fa-solid fa-location-dot"></i> Seattle, WA</p>
                    <p class="company-jobs">Open jobs - <span>24</span></p>
                </div>
                
                <!-- Company Item -->
                <div class="company-card">
                    <div class="company-logo-large">
                        <img src="/huntlyversion2/public/assets/images/logo.png" alt="Google" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                    </div>
                    <h3 class="company-title">Google</h3>
                    <p class="company-location"><i class="fa-solid fa-location-dot"></i> Mountain View, CA</p>
                    <p class="company-jobs">Open jobs - <span>18</span></p>
                </div>
                
                <!-- Company Item -->
                <div class="company-card">
                    <div class="company-logo-large">
                        <img src="/huntlyversion2/public/assets/images/logo.png" alt="Amazon" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                    </div>
                    <h3 class="company-title">Amazon</h3>
                    <p class="company-location"><i class="fa-solid fa-location-dot"></i> Seattle, WA</p>
                    <p class="company-jobs">Open jobs - <span>32</span></p>
                </div>
                
                <!-- Company Item -->
                <div class="company-card">
                    <div class="company-logo-large">
                        <img src="/huntlyversion2/public/assets/images/logo.png" alt="Apple" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                    </div>
                    <h3 class="company-title">Apple</h3>
                    <p class="company-location"><i class="fa-solid fa-location-dot"></i> Cupertino, CA</p>
                    <p class="company-jobs">Open jobs - <span>15</span></p>
                </div>

                <!-- Company Item -->
                <div class="company-card">
                    <div class="company-logo-large">
                        <img src="/huntlyversion2/public/assets/images/logo.png" alt="Netflix" onerror="this.src='/huntlyversion2/public/assets/images/default-logo.png'">
                    </div>
                    <h3 class="company-title">Netflix</h3>
                    <p class="company-location"><i class="fa-solid fa-location-dot"></i> Los Gatos, CA</p>
                    <p class="company-jobs">Open jobs - <span>12</span></p>
                </div>
            </div>
        </div>
    </section>
</main>