document.addEventListener('DOMContentLoaded', function() {
    const jobSearchInput = document.getElementById('job-search');
    const jobHintBox = document.getElementById('job-hint');

    const locationSearchInput = document.getElementById('location-search');
    const locationHintBox = document.getElementById('location-hint');
    
    const baseUrl = '/huntly';
    
    console.log('baseUrl:', baseUrl); // Debugging line

    function debounce(func, delay) {
        let timeoutId;
        return function(...args) {
            if (timeoutId) {
                clearTimeout(timeoutId);
            }
            timeoutId = setTimeout(() => {
                func.apply(this, args);
            }, delay);
        };
    }

    // Job & company search
    if(jobSearchInput && jobHintBox) {
        function performSearch(keyword) {
            if(keyword.length > 1) {
                fetch(baseUrl + '/public/assets/search-api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'query=' + encodeURIComponent(keyword)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Search results:', data);

                    if (data.status === 'success' && data.data.length > 0) {
                        let html = '';

                        data.data.sort((a, b) => {
                            const nameA = a.name.toLowerCase();
                            const nameB = b.name.toLowerCase();
                            const query = keyword.toLowerCase();
                            
                            const aStartsWithQuery = nameA.startsWith(query);
                            const bStartsWithQuery = nameB.startsWith(query);
                            
                            if (aStartsWithQuery && !bStartsWithQuery) return -1;
                            if (!aStartsWithQuery && bStartsWithQuery) return 1;
                            
                            // If same type, sort by alphabet
                            return nameA.localeCompare(nameB);
                        });
                        data.data.forEach(item => {
                            const itemName = item.name;
                            const queryPos = itemName.toLowerCase().indexOf(keyword.toLowerCase());
                            let highlightedName = itemName;
                            
                            if (queryPos >= 0) {
                                const before = itemName.substring(0, queryPos);
                                const match = itemName.substring(queryPos, queryPos + keyword.length);
                                const after = itemName.substring(queryPos + keyword.length);
                                highlightedName = `${before}<strong>${match}</strong>${after}`;
                            }

                            html += `<div class="search-item ${item.type}">
                                <a href="${baseUrl}/${item.type}s/${item.id}">${highlightedName}</a>
                            </div>`;
                        });
                        jobHintBox.innerHTML = html;
                        jobHintBox.style.display = 'block';
                    } else {
                        jobHintBox.innerHTML = '<div class="no-results">No result</div>';
                        jobHintBox.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    jobHintBox.innerHTML = '<div class="error">Error: ' + error.message + '</div>';
                    jobHintBox.style.display = 'block';
                });
            } else {
                jobHintBox.innerHTML = '';
                jobHintBox.style.display = 'none';
            }
        }
        
        const debouncedSearch = debounce(performSearch, 300);
        
        jobSearchInput.addEventListener('input', function() {
            debouncedSearch(this.value);
        });

        document.addEventListener('click', function(e) {
            if(e.target !== jobSearchInput && e.target !== jobHintBox) {
                jobHintBox.style.display = 'none';
            }
        });
    }

    // Location search
    if(locationSearchInput && locationHintBox) {
        function performLocationSearch(keyword) {
            if(keyword.length > 1) {
                fetch(baseUrl + '/public/assets/search-api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'location=' + encodeURIComponent(keyword)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Location search results:', data);

                    if (data.status === 'success' && data.data.length > 0) {
                        let html = '';

                        data.data.sort((a, b) => {
                            const nameA = a.name.toLowerCase();
                            const nameB = b.name.toLowerCase();
                            const query = keyword.toLowerCase();
                            
                            const aStartsWithQuery = nameA.startsWith(query);
                            const bStartsWithQuery = nameB.startsWith(query);
                            
                            if (aStartsWithQuery && !bStartsWithQuery) return -1;
                            if (!aStartsWithQuery && bStartsWithQuery) return 1;
                            
                            // If same type, sort by alphabet
                            return nameA.localeCompare(nameB);
                        });

                        data.data.forEach(item => {
                            const itemName = item.name;
                            const queryPos = itemName.toLowerCase().indexOf(keyword.toLowerCase());
                            let highlightedName = itemName;
                            
                            if (queryPos >= 0) {
                                const before = itemName.substring(0, queryPos);
                                const match = itemName.substring(queryPos, queryPos + keyword.length);
                                const after = itemName.substring(queryPos + keyword.length);
                                highlightedName = `${before}<strong>${match}</strong>${after}`;
                            }

                            html += `<div class="search-item ${item.type}">
                                <a href="${baseUrl}/locations/${item.id}">${highlightedName}</a>
                            </div>`;
                        });
                        locationHintBox.innerHTML = html;
                        locationHintBox.style.display = 'block';
                    } else {
                        locationHintBox.innerHTML = '<div class="no-results">No result</div>';
                        locationHintBox.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Location search error:', error);
                    locationHintBox.innerHTML = '<div class="error">Error: ' + error.message + '</div>';
                    locationHintBox.style.display = 'block';
                });
            } else {
                locationHintBox.innerHTML = '';
                locationHintBox.style.display = 'none';
            }
        }

        const debouncedLocationSearch = debounce(performLocationSearch, 300);
        
        locationSearchInput.addEventListener('input', function() {
            debouncedLocationSearch(this.value);
        });

        document.addEventListener('click', function(e) {
            if(e.target !== locationSearchInput && e.target !== locationHintBox) {
                locationHintBox.style.display = 'none';
            }
        });
    }
});