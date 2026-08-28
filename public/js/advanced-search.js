/**
 * Advanced Search Functionality
 * Features:
 * - Real-time AJAX search
 * - Autocomplete suggestions
 * - Search history
 * - Keyboard navigation
 * - Search filters
 */

class AdvancedSearch {
    constructor() {
        this.searchInput = document.getElementById('search-input');
        this.searchResults = document.getElementById('search-results');
        this.searchSuggestions = document.getElementById('search-suggestions');
        this.searchHistory = JSON.parse(localStorage.getItem('searchHistory') || '[]');
        this.currentFocus = -1;
        this.searchTimeout = null;
        this.isSearching = false;

        this.init();
    }

    init() {
        if (!this.searchInput) return;

        // Event listeners
        this.searchInput.addEventListener('input', (e) => this.handleInput(e));
        this.searchInput.addEventListener('keydown', (e) => this.handleKeydown(e));
        this.searchInput.addEventListener('focus', () => this.showSuggestions());
        this.searchInput.addEventListener('blur', () => setTimeout(() => this.hideDropdowns(), 150));

        // Click outside to close suggestions/results
        document.addEventListener('mousedown', (e) => {
            if (!this.searchInput.contains(e.target) &&
                !this.searchResults?.contains(e.target) &&
                !this.searchSuggestions?.contains(e.target)) {
                this.hideDropdowns();
            }
        });

        // Initialize search form
        this.initSearchForm();
    }

    initSearchForm() {
        const searchForm = this.searchInput.closest('form');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }

    async handleInput(e) {
        const query = e.target.value.trim();
        
        // Clear previous timeout
        if (this.searchTimeout) {
            clearTimeout(this.searchTimeout);
        }

        // Hide dropdown if input is empty
        if (query.length < 2) {
            this.hideDropdowns();
            return;
        }

        // Debounce search
        this.searchTimeout = setTimeout(async () => {
            await this.performSearch(query);
        }, 300);
    }

    async performSearch(query) {
        if (this.isSearching) return;
        
        this.isSearching = true;
        this.showLoading();

        try {
            const response = await fetch(`/search/ajax?q=${encodeURIComponent(query)}&limit=8`);
            const data = await response.json();

            if (data.results && data.results.length > 0) {
                this.displaySearchResults(data.results, query);
                this.displaySuggestions(data.suggestions, query);
            } else {
                this.showNoResults(query);
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showError();
        } finally {
            this.isSearching = false;
            this.hideLoading();
        }
    }

    displaySearchResults(results, query) {
        if (!this.searchResults) return;

        const resultsHTML = results.map(product => `
            <div class="search-result-item" onclick="window.location.href='/produk/${product.id}'">
                <div class="search-result-image">
                    <img src="${product.preview_image ? '/storage/' + product.preview_image : '/images/placeholder.jpg'}" 
                         alt="${product.title}" 
                         onerror="this.src='/images/placeholder.jpg'">
                </div>
                <div class="search-result-content">
                    <div class="search-result-title">${this.highlightQuery(product.title, query)}</div>
                    <div class="search-result-category">${product.file_type}</div>
                    <div class="search-result-price">
                        ${product.price == 0 ? 'Gratis' : 'Rp ' + this.formatNumber(product.price)}
                    </div>
                </div>
            </div>
        `).join('');

        this.searchResults.innerHTML = `
            <div class="search-results-header">
                <span>Hasil Pencarian (${results.length})</span>
                <a href="/search?q=${encodeURIComponent(query)}" class="view-all-link">Lihat Semua</a>
            </div>
            <div class="search-results-list">
                ${resultsHTML}
            </div>
        `;

        this.searchResults.style.display = 'block';
    }

    displaySuggestions(suggestions, query) {
        if (!this.searchSuggestions) return;

        let suggestionsHTML = '';

        // Add search history
        const historySuggestions = this.searchHistory
            .filter(item => item.toLowerCase().includes(query.toLowerCase()))
            .slice(0, 3);

        if (historySuggestions.length > 0) {
            suggestionsHTML += `
                <div class="suggestion-group">
                    <div class="suggestion-group-title">Pencarian Terakhir</div>
                    ${historySuggestions.map(item => `
                        <div class="suggestion-item" onclick="selectSuggestion('${item}')">
                            <i class="fas fa-history"></i>
                            <span>${this.highlightQuery(item, query)}</span>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        // Add product title suggestions
        if (suggestions.titles && suggestions.titles.length > 0) {
            suggestionsHTML += `
                <div class="suggestion-group">
                    <div class="suggestion-group-title">Produk</div>
                    ${suggestions.titles.map(title => `
                        <div class="suggestion-item" onclick="selectSuggestion('${title}')">
                            <i class="fas fa-box"></i>
                            <span>${this.highlightQuery(title, query)}</span>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        // Add category suggestions
        if (suggestions.categories && suggestions.categories.length > 0) {
            suggestionsHTML += `
                <div class="suggestion-group">
                    <div class="suggestion-group-title">Kategori</div>
                    ${suggestions.categories.map(category => `
                        <div class="suggestion-item" onclick="selectSuggestion('${category}')">
                            <i class="fas fa-tag"></i>
                            <span>${this.highlightQuery(category, query)}</span>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        if (suggestionsHTML) {
            this.searchSuggestions.innerHTML = suggestionsHTML;
            this.searchSuggestions.style.display = 'block';
        }
    }

    selectSuggestion(text) {
        this.searchInput.value = text;
        this.hideDropdowns();
        this.addToHistory(text);
        
        // Submit search
        const form = this.searchInput.closest('form');
        if (form) {
            form.submit();
        }
    }

    handleKeydown(e) {
        const suggestions = this.searchSuggestions?.querySelectorAll('.suggestion-item');
        if (!suggestions || suggestions.length === 0) {
            if (e.key === 'Escape') this.hideDropdowns();
            return;
        }

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.currentFocus++;
                this.updateFocus(suggestions);
                break;
            case 'ArrowUp':
                e.preventDefault();
                this.currentFocus--;
                this.updateFocus(suggestions);
                break;
            case 'Enter':
                e.preventDefault();
                if (this.currentFocus > -1 && suggestions[this.currentFocus]) {
                    suggestions[this.currentFocus].click();
                } else {
                    this.handleSubmit(e);
                }
                break;
            case 'Escape':
                this.hideDropdowns();
                this.searchInput.blur();
                break;
        }
    }

    updateFocus(suggestions) {
        // Remove focus from all items
        suggestions.forEach(item => item.classList.remove('suggestion-focus'));

        // Add focus to current item
        if (this.currentFocus >= suggestions.length) this.currentFocus = 0;
        if (this.currentFocus < 0) this.currentFocus = suggestions.length - 1;

        if (suggestions[this.currentFocus]) {
            suggestions[this.currentFocus].classList.add('suggestion-focus');
        }
    }

    handleSubmit(e) {
        const query = this.searchInput.value.trim();
        if (query.length < 2) {
            e.preventDefault();
            this.showError('Masukkan minimal 2 karakter untuk mencari');
            return;
        }

        this.addToHistory(query);
        this.hideDropdowns();
    }

    addToHistory(query) {
        if (!query || query.length < 2) return;

        // Remove if already exists
        this.searchHistory = this.searchHistory.filter(item => item.toLowerCase() !== query.toLowerCase());
        
        // Add to beginning
        this.searchHistory.unshift(query);
        
        // Keep only last 10 searches
        this.searchHistory = this.searchHistory.slice(0, 10);
        
        // Save to localStorage
        localStorage.setItem('searchHistory', JSON.stringify(this.searchHistory));
    }

    showSuggestions() {
        if (this.searchSuggestions) {
            this.searchSuggestions.style.display = 'block';
        }
    }

    hideDropdowns() {
        if (this.searchSuggestions) this.searchSuggestions.style.display = 'none';
        if (this.searchResults) this.searchResults.style.display = 'none';
        this.currentFocus = -1;
    }

    showLoading() {
        if (this.searchResults) {
            this.searchResults.innerHTML = `
                <div class="search-loading">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Mencari...</span>
                </div>
            `;
            this.searchResults.style.display = 'block';
        }
    }

    hideLoading() {
        // Loading will be replaced by results or no results
    }

    showNoResults(query) {
        if (this.searchResults) {
            this.searchResults.innerHTML = `
                <div class="search-no-results">
                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                    <div class="text-muted">Tidak ada hasil untuk "${query}"</div>
                    <small class="text-muted">Coba kata kunci lain atau periksa ejaan</small>
                </div>
            `;
            this.searchResults.style.display = 'block';
        }
    }

    showError(message = 'Terjadi kesalahan saat mencari') {
        if (this.searchResults) {
            this.searchResults.innerHTML = `
                <div class="search-error">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <div class="text-danger">${message}</div>
                </div>
            `;
            this.searchResults.style.display = 'block';
        }
    }

    highlightQuery(text, query) {
        if (!query) return text;
        
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }

    formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
}

// Initialize advanced search when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new AdvancedSearch();
});

// Global function for suggestion selection
function selectSuggestion(text) {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.value = text;
        const form = searchInput.closest('form');
        if (form) {
            form.submit();
        }
    }
} 