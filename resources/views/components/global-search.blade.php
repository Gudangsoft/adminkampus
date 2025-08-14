<!-- Global Search Component -->
<div class="global-search-container" x-data="globalSearch()" x-init="init()">
    <!-- Search Input -->
    <div class="search-input-wrapper position-relative">
        <input type="text" 
               class="form-control search-input" 
               placeholder="Tekan Enter untuk mencari berita, pengumuman, informasi akademik..."
               x-model="query"
               @input.debounce.300ms="getSuggestions()"
               @keydown.enter="performSearch()"
               @keydown.arrow-down="highlightNext()"
               @keydown.arrow-up="highlightPrev()"
               @keydown.escape="closeSuggestions()"
               autocomplete="off">
        <i class="fas fa-search search-icon"></i>
        
        <!-- Search Suggestions Dropdown -->
        <div class="suggestions-dropdown" 
             x-show="showSuggestions && suggestions.length > 0"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">
            
            <div class="suggestions-list">
                <template x-for="(suggestion, index) in suggestions" :key="index">
                    <div class="suggestion-item"
                         :class="{ 'highlighted': highlightedIndex === index }"
                         @click="selectSuggestion(suggestion)"
                         @mouseenter="highlightedIndex = index">
                        <i class="fas fa-search text-muted me-2"></i>
                        <span x-text="suggestion"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    <!-- Loading State -->
    <div class="search-loading text-center py-3" x-show="loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="ms-2">Mencari...</span>
    </div>
    
    <!-- Search Results -->
    <div class="search-results mt-4" x-show="showResults && !loading">
        <!-- Results Summary -->
        <div class="results-summary mb-3" x-show="results.total_results > 0">
            <p class="text-muted">
                Ditemukan <strong x-text="results.total_results"></strong> hasil untuk 
                "<strong x-text="results.query"></strong>"
            </p>
        </div>
        
        <!-- No Results -->
        <div class="no-results text-center py-4" x-show="results.total_results === 0">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h5>Tidak ada hasil ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda</p>
        </div>
        
        <!-- News Results -->
        <template x-if="results.results && results.results.news && results.results.news.length > 0">
            <div class="result-section mb-4">
                <h6 class="result-section-title">
                    <i class="fas fa-newspaper text-primary me-2"></i>
                    Berita
                </h6>
                <div class="row">
                    <template x-for="item in results.results.news" :key="item.id">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="result-card">
                                <div class="result-image" x-show="item.image">
                                    <img :src="item.image" :alt="item.title" class="img-fluid">
                                </div>
                                <div class="result-content">
                                    <h6 class="result-title">
                                        <a :href="item.url" x-text="item.title"></a>
                                    </h6>
                                    <p class="result-excerpt" x-text="item.excerpt"></p>
                                    <div class="result-meta">
                                        <small class="text-muted">
                                            <span x-text="item.category" x-show="item.category"></span>
                                            <span x-show="item.category"> • </span>
                                            <span x-text="item.date"></span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        
        <!-- Announcements Results -->
        <template x-if="results.results && results.results.announcements && results.results.announcements.length > 0">
            <div class="result-section mb-4">
                <h6 class="result-section-title">
                    <i class="fas fa-bullhorn text-warning me-2"></i>
                    Pengumuman
                </h6>
                <div class="list-group">
                    <template x-for="item in results.results.announcements" :key="item.id">
                        <a :href="item.url" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1" x-text="item.title"></h6>
                                <small x-text="item.date"></small>
                            </div>
                            <p class="mb-1" x-text="item.excerpt"></p>
                            <small class="text-warning" x-show="item.featured">
                                <i class="fas fa-star"></i> Unggulan
                            </small>
                        </a>
                    </template>
                </div>
            </div>
        </template>
        
        <!-- Other results sections (pages, galleries, etc.) can be added here -->
    </div>
</div>

<style>
.global-search-container {
    max-width: 800px;
    margin: 0 auto;
}

.search-input-wrapper {
    position: relative;
}

.search-input {
    padding-right: 50px;
    border-radius: 25px;
    border: 2px solid #e9ecef;
    background: white;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.search-input:focus {
    border-color: #0d6efd;
    box-shadow: 0 2px 20px rgba(13,110,253,0.25);
    outline: none;
}

.search-input::placeholder {
    color: #6c757d;
    font-style: italic;
}

.search-icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 18px;
    pointer-events: none;
    z-index: 10;
}

.suggestions-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1000;
    background: white;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    max-height: 300px;
    overflow-y: auto;
}

.suggestion-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.15s ease-in-out;
}

.suggestion-item:hover,
.suggestion-item.highlighted {
    background-color: #f8f9fa;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.result-card {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    overflow: hidden;
    transition: transform 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    height: 100%;
}

.result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.result-image img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.result-content {
    padding: 1rem;
}

.result-title a {
    text-decoration: none;
    color: #212529;
    font-weight: 600;
}

.result-title a:hover {
    color: #0d6efd;
}

.result-excerpt {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.result-section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.search-filters .btn {
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .search-filters .btn-group {
        display: flex;
        flex-wrap: wrap;
    }
    
    .search-filters .btn {
        flex: 1;
        min-width: auto;
    }
}
</style>

<script>
function globalSearch() {
    return {
        query: '',
        suggestions: [],
        results: {},
        loading: false,
        showSuggestions: false,
        showResults: false,
        highlightedIndex: -1,
        
        init() {
            // Initialize component
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.closeSuggestions();
                }
            });
        },
        
        async getSuggestions() {
            if (this.query.length < 2) {
                this.suggestions = [];
                this.showSuggestions = false;
                return;
            }
            
            try {
                const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(this.query)}`);
                this.suggestions = await response.json();
                this.showSuggestions = this.suggestions.length > 0;
                this.highlightedIndex = -1;
            } catch (error) {
                console.error('Error fetching suggestions:', error);
            }
        },
        
        async performSearch() {
            if (!this.query.trim()) return;
            
            this.loading = true;
            this.showSuggestions = false;
            this.showResults = true;
            
            try {
                const params = new URLSearchParams({
                    q: this.query,
                    limit: 20
                });
                
                const response = await fetch(`/api/search?${params}`);
                this.results = await response.json();
            } catch (error) {
                console.error('Error performing search:', error);
                this.results = { status: 'error', message: 'Terjadi kesalahan saat mencari' };
            } finally {
                this.loading = false;
            }
        },
        
        selectSuggestion(suggestion) {
            this.query = suggestion;
            this.closeSuggestions();
            this.performSearch();
        },
        
        closeSuggestions() {
            this.showSuggestions = false;
            this.highlightedIndex = -1;
        },
        
        highlightNext() {
            if (this.suggestions.length === 0) return;
            this.highlightedIndex = Math.min(this.highlightedIndex + 1, this.suggestions.length - 1);
        },
        
        highlightPrev() {
            if (this.suggestions.length === 0) return;
            this.highlightedIndex = Math.max(this.highlightedIndex - 1, -1);
        }
    }
}
</script>
