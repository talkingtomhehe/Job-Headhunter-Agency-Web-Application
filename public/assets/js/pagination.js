class Pagination {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);
        this.options = {
            pageRange: 2, // How many pages to show before and after current page
            onPageChange: null, // Callback function when page changes
            scrollToElement: null, // Element to scroll to on page change
            scrollBehavior: 'smooth', // Scroll behavior
            ...options
        };
        
        // Bind methods
        this.changePage = this.changePage.bind(this);
        
        // Initialize event delegation
        if (this.container) {
            this.container.addEventListener('click', (e) => {
                const link = e.target.closest('.pagination-link');
                if (link && link.dataset.page) {
                    e.preventDefault();
                    this.changePage(parseInt(link.dataset.page));
                }
            });
        }
    }
    
    update(paginationData) {
        if (!this.container || !paginationData) return;
        
        const { currentPage, totalPages, totalItems } = paginationData;
        
        // Clear current pagination
        this.container.innerHTML = '';
        
        // Only show pagination if we have more than one page
        if (totalPages <= 1) return;
        
        // Previous button
        if (currentPage > 1) {
            const prevLink = document.createElement('a');
            prevLink.href = 'javascript:void(0)';
            prevLink.className = 'pagination-link prev';
            prevLink.dataset.page = currentPage - 1;
            prevLink.innerHTML = '<i class="fa-solid fa-angle-left"></i> Previous';
            this.container.appendChild(prevLink);
        }
        
        // Page numbers
        const startPage = Math.max(1, currentPage - this.options.pageRange);
        const endPage = Math.min(totalPages, currentPage + this.options.pageRange);
        
        for (let i = startPage; i <= endPage; i++) {
            const pageLink = document.createElement('a');
            pageLink.href = 'javascript:void(0)';
            pageLink.className = `pagination-link ${i === currentPage ? 'active' : ''}`;
            pageLink.textContent = i;
            pageLink.dataset.page = i;
            this.container.appendChild(pageLink);
        }
        
        // Next button
        if (currentPage < totalPages) {
            const nextLink = document.createElement('a');
            nextLink.href = 'javascript:void(0)';
            nextLink.className = 'pagination-link next';
            nextLink.dataset.page = currentPage + 1;
            nextLink.innerHTML = 'Next <i class="fa-solid fa-angle-right"></i>';
            this.container.appendChild(nextLink);
        }
        
        // Store current state
        this.currentPage = currentPage;
        this.totalPages = totalPages;
        this.totalItems = totalItems;
    }
    
    changePage(page) {
        if (typeof this.options.onPageChange === 'function') {
            this.options.onPageChange(page);
            
            // Scroll to element if configured
            if (this.options.scrollToElement) {
                const element = typeof this.options.scrollToElement === 'string' 
                    ? document.querySelector(this.options.scrollToElement) 
                    : this.options.scrollToElement;
                
                if (element) {
                    element.scrollIntoView({ behavior: this.options.scrollBehavior });
                }
            }
        }
    }
    
    getCurrentPage() {
        return this.currentPage || 1;
    }
    
    getTotalPages() {
        return this.totalPages || 0;
    }
}

// Make Pagination available globally
window.Pagination = Pagination;