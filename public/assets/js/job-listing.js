document.addEventListener('DOMContentLoaded', function() {
    // Base URL for AJAX requests
    const baseUrl = document.querySelector('body').dataset.baseUrl || '/huntly';

    // Elements
    const jobSearchForm = document.getElementById('job-search-form');
    const jobsContainer = document.getElementById('jobs-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    const totalJobsCount = document.getElementById('total-jobs-count');
    const sortBySelect = document.getElementById('sort-by');
    const jobCardTemplate = document.getElementById('job-card-template');
    const toggleAdvancedFilters = document.getElementById('toggle-advanced-filters');
    const advancedFilters = document.querySelector('.advanced-filters');

    // Search form inputs
    const keywordInput = document.getElementById('keyword-input');
    const locationInput = document.getElementById('location-input');
    const workModelInput = document.getElementById('work-model-input');
    const categoryInput = document.getElementById('category-input');
    const experienceInput = document.getElementById('experience-input');
    const jobTypeInput = document.getElementById('job-type-input');

    // Initial search parameters from URL
    const initialParams = new URLSearchParams(window.location.search);
    let searchParams = {
        keyword: initialParams.get('keyword') || '',
        location: initialParams.get('location') || '',
        work_model: initialParams.get('work_model') || '',
        category: initialParams.get('category') || '',
        experience: initialParams.get('experience') || '',
        job_type: initialParams.get('job_type') || '',
        sort: initialParams.get('sort') || 'newest',
        page: parseInt(initialParams.get('page')) || 1
    };

    // Initialize pagination with a callback for page changes
    const pagination = new Pagination('pagination-container', {
        onPageChange: (page) => {
            searchParams.page = page;
            loadJobs();
        },
        scrollToElement: '.jobs-listing'
    });

    // Initialize the page
    initPage();

    /**
     * Initialize the page
     */
    function initPage() {
        // Toggle advanced filters
        if (toggleAdvancedFilters) {
            toggleAdvancedFilters.addEventListener('click', function(e) {
                e.preventDefault();
                const toggleContainer = this.parentElement;
                toggleContainer.classList.toggle('active');
                
                if (advancedFilters) {
                    advancedFilters.style.display = advancedFilters.style.display === 'block' ? 'none' : 'block';
                }
            });
            
            // Show advanced filters if any are set
            if (searchParams.work_model || searchParams.category || searchParams.experience || searchParams.job_type) {
                advancedFilters.style.display = 'block';
                toggleAdvancedFilters.parentElement.classList.add('active');
            }
        }

        // Job search form submission
        if (jobSearchForm) {
            jobSearchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Update search params from form
                updateSearchParamsFromForm();
                searchParams.page = 1; // Reset to page 1 for new searches
                
                loadJobs();
            });
        }
        
        // Sort change
        if (sortBySelect) {
            sortBySelect.addEventListener('change', function() {
                searchParams.sort = this.value;
                searchParams.page = 1; // Reset to page 1 when changing sort
                loadJobs();
            });
        }
        
        // Add input event listeners to form fields for auto-search
        setupAutoSearch();
    }

    /**
     * Set up auto-search on input change with debounce
     */
    function setupAutoSearch() {
        // Debounce function to limit how often a function can be called
        function debounce(func, delay) {
            let timeoutId;
            return function(...args) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    func.apply(this, args);
                }, delay);
            };
        }
        
        // Auto-search on field change (with debounce)
        const debouncedSearch = debounce(() => {
            updateSearchParamsFromForm();
            searchParams.page = 1; // Reset to page 1 for new searches
            loadJobs();
        }, 500);
        
        // Add listeners to all inputs
        if (keywordInput) keywordInput.addEventListener('input', debouncedSearch);
        if (locationInput) locationInput.addEventListener('input', debouncedSearch);
        if (workModelInput) workModelInput.addEventListener('change', debouncedSearch);
        if (categoryInput) categoryInput.addEventListener('change', debouncedSearch);
        if (experienceInput) experienceInput.addEventListener('change', debouncedSearch);
        if (jobTypeInput) jobTypeInput.addEventListener('change', debouncedSearch);
    }

    /**
     * Update search parameters from form inputs
     */
    function updateSearchParamsFromForm() {
        if (keywordInput) searchParams.keyword = keywordInput.value;
        if (locationInput) searchParams.location = locationInput.value;
        if (workModelInput) searchParams.work_model = workModelInput.value;
        if (categoryInput) searchParams.category = categoryInput.value;
        if (experienceInput) searchParams.experience = experienceInput.value;
        if (jobTypeInput) searchParams.job_type = jobTypeInput.value;
    }

    /**
     * Format salary for display
     */
    function formatSalary(min, max) {
        if (!min && !max) {
            return 'Negotiable';
        }
        
        if (!min) {
            return 'Up to $' + new Intl.NumberFormat().format(max);
        }
        
        if (!max) {
            return 'From $' + new Intl.NumberFormat().format(min);
        }
        
        return '$' + new Intl.NumberFormat().format(min) + ' - $' + new Intl.NumberFormat().format(max);
    }

    /**
     * Format relative time (time ago)
     */
    function formatRelativeTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffMs = now - date;
        const diffSeconds = Math.floor(diffMs / 1000);
        const diffMinutes = Math.floor(diffSeconds / 60);
        const diffHours = Math.floor(diffMinutes / 60);
        const diffDays = Math.floor(diffHours / 24);
        const diffWeeks = Math.floor(diffDays / 7);
        const diffMonths = Math.floor(diffDays / 30);
        
        if (diffSeconds < 60) {
            return 'just now';
        } else if (diffMinutes < 60) {
            return diffMinutes + (diffMinutes === 1 ? ' minute ago' : ' minutes ago');
        } else if (diffHours < 24) {
            return diffHours + (diffHours === 1 ? ' hour ago' : ' hours ago');
        } else if (diffDays < 7) {
            return diffDays + (diffDays === 1 ? ' day ago' : ' days ago');
        } else if (diffWeeks < 4) {
            return diffWeeks + (diffWeeks === 1 ? ' week ago' : ' weeks ago');
        } else {
            return diffMonths + (diffMonths === 1 ? ' month ago' : ' months ago');
        }
    }

    /**
     * Load jobs via AJAX
     */
    function loadJobs() {
        // Show loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'flex';
        }
        
        // Build query string
        const queryParams = new URLSearchParams(searchParams);
        
        // Make the AJAX request
        fetch(`${baseUrl}/job/search?${queryParams.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update the total jobs count
            if (totalJobsCount) {
                totalJobsCount.textContent = data.totalJobs;
            }
            
            // Clear the current jobs
            if (jobsContainer) {
                jobsContainer.innerHTML = '';
                
                if (data.jobs && data.jobs.length > 0) {
                    // Create and append job cards
                    data.jobs.forEach(job => {
                        const jobCard = createJobCard(job);
                        jobsContainer.appendChild(jobCard);
                    });
                    
                    // Update pagination using our pagination class
                    pagination.update({
                        currentPage: data.pagination.currentPage,
                        totalPages: data.pagination.totalPages,
                        totalItems: data.totalJobs
                    });
                } else {
                    // Show "no jobs found" message
                    jobsContainer.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h3>No Jobs Found</h3>
                            <p>Try adjusting your search criteria or check back later for new opportunities.</p>
                        </div>
                    `;
                    
                    // Clear pagination
                    pagination.update({
                        currentPage: 1,
                        totalPages: 0,
                        totalItems: 0
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error loading jobs:', error);
            if (jobsContainer) {
                jobsContainer.innerHTML = `
                    <div class="error-message">
                        <h3>Error loading jobs</h3>
                        <p>There was a problem loading jobs. Please try again later.</p>
                    </div>
                `;
            }
        })
        .finally(() => {
            // Hide loading indicator
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            
            // Update the URL with the current search params (without triggering a page reload)
            updateBrowserUrl();
        });
    }

    /**
     * Create a job card DOM element from job data
     */
    function createJobCard(job) {
        // Existing createJobCard implementation...
        if (!jobCardTemplate) return document.createElement('div');
        
        const template = jobCardTemplate.content.cloneNode(true);
        const card = template.querySelector('.job-card');
        
        // Set job ID and click handler
        card.dataset.jobId = job.job_id;
        card.onclick = (e) => {
            // Don't redirect if clicking on the view details button (it has its own link)
            if (e.target.closest('.view-job-btn')) return;
            window.location.href = `${baseUrl}/job/viewJob/${job.job_id}`;
        };
        
        // Set logo
        const logoImg = card.querySelector('.company-logo img');
        logoImg.src = `${baseUrl}/public/${job.logo_path || 'assets/images/default-logo.png'}`;
        logoImg.alt = job.company_name;
        
        // Set job info
        card.querySelector('.job-title').textContent = job.title;
        card.querySelector('.company-name').textContent = job.company_name;
        
        // Set work model, category, and job type (if available)
        const workModelTag = card.querySelector('.job-tag.work-model');
        const categoryTag = card.querySelector('.job-tag.category');
        const jobTypeTag = card.querySelector('.job-tag.job-type');
        
        if (job.work_model) {
            workModelTag.querySelector('.work-model-text').textContent = job.work_model;
        } else {
            workModelTag.style.display = 'none';
        }
        
        if (job.category_name) {
            categoryTag.querySelector('.category-text').textContent = job.category_name;
        } else {
            categoryTag.style.display = 'none';
        }
        
        if (job.job_type) {
            jobTypeTag.querySelector('.job-type-text').textContent = job.job_type;
        } else {
            jobTypeTag.style.display = 'none';
        }
        
        // Set job meta info
        card.querySelector('.location-text').textContent = job.location;
        card.querySelector('.salary-text').textContent = formatSalary(job.salary_min, job.salary_max);
        card.querySelector('.date-text').textContent = formatRelativeTime(job.created_at);
        
        // Set view details link
        const viewButton = card.querySelector('.view-job-btn');
        viewButton.href = `${baseUrl}/job/viewJob/${job.job_id}`;
        
        return card;
    }

    /**
     * Update browser URL with current search parameters
     */
    function updateBrowserUrl() {
        const url = new URL(window.location.href);
        
        // Clear existing parameters
        [...url.searchParams.keys()].forEach(key => {
            url.searchParams.delete(key);
        });
        
        // Add current search parameters
        Object.keys(searchParams).forEach(key => {
            if (searchParams[key]) {
                url.searchParams.set(key, searchParams[key]);
            }
        });
        
        // Update the URL without reloading the page
        window.history.pushState({}, '', url);
    }
});