<!-- FAQ Accordion Component -->
<div class="faq-container" x-data="faqAccordion()" x-init="loadFaqs()">
    <div class="faq-header">
        <h3 class="faq-title">
            <i class="fas fa-question-circle text-primary me-2"></i>
            Frequently Asked Questions
        </h3>
        <p class="faq-subtitle">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
    </div>

    <!-- FAQ Search -->
    <div class="faq-search-wrapper mb-4">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" 
                   class="form-control" 
                   placeholder="Cari pertanyaan..."
                   x-model="searchQuery"
                   @input.debounce.300ms="filterFaqs()">
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="faq-categories mb-4" x-show="categories.length > 0">
        <div class="btn-group-toggle" role="group">
            <button class="btn btn-outline-primary category-btn"
                    :class="{ 'active': selectedCategory === 'all' }"
                    @click="selectCategory('all')">
                Semua
            </button>
            <template x-for="category in categories" :key="category">
                <button class="btn btn-outline-primary category-btn"
                        :class="{ 'active': selectedCategory === category }"
                        @click="selectCategory(category)"
                        x-text="formatCategory(category)">
                </button>
            </template>
        </div>
    </div>

    <!-- Loading State -->
    <div class="faq-loading text-center py-5" x-show="loading">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Memuat FAQ...</p>
    </div>

    <!-- FAQ Items -->
    <div class="faq-list" x-show="!loading">
        <!-- No Results -->
        <div class="faq-no-results text-center py-5" x-show="filteredFaqs.length === 0">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h5>Tidak ada FAQ ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori berbeda</p>
        </div>

        <!-- FAQ Accordion -->
        <div class="accordion" id="faqAccordion">
            <template x-for="(faq, index) in filteredFaqs" :key="faq.id">
                <div class="accordion-item faq-item">
                    <h2 class="accordion-header" :id="'faq-heading-' + faq.id">
                        <button class="accordion-button collapsed faq-question"
                                type="button"
                                :data-bs-target="'#faq-collapse-' + faq.id"
                                :aria-controls="'faq-collapse-' + faq.id"
                                @click="toggleFaq(faq.id)"
                                data-bs-toggle="collapse">
                            <div class="faq-question-content">
                                <span class="faq-question-text" x-text="faq.question"></span>
                                <div class="faq-meta">
                                    <span class="faq-category badge bg-secondary" x-text="formatCategory(faq.category)"></span>
                                    <span class="faq-views" x-show="faq.views > 0">
                                        <i class="fas fa-eye"></i>
                                        <span x-text="faq.views"></span>
                                    </span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div :id="'faq-collapse-' + faq.id"
                         class="accordion-collapse collapse"
                         :aria-labelledby="'faq-heading-' + faq.id"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body faq-answer">
                            <div class="faq-answer-content" x-html="formatAnswer(faq.answer)"></div>
                            <div class="faq-actions mt-3">
                                <button class="btn btn-sm btn-outline-success faq-helpful"
                                        @click="markHelpful(faq.id)">
                                    <i class="fas fa-thumbs-up"></i>
                                    Membantu
                                </button>
                                <button class="btn btn-sm btn-outline-primary faq-share"
                                        @click="shareFaq(faq)">
                                    <i class="fas fa-share"></i>
                                    Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Popular FAQs Sidebar (if space allows) -->
    <div class="faq-sidebar" x-show="popularFaqs.length > 0 && !loading">
        <h5 class="sidebar-title">
            <i class="fas fa-fire text-warning me-2"></i>
            FAQ Populer
        </h5>
        <div class="popular-faqs">
            <template x-for="faq in popularFaqs.slice(0, 5)" :key="'popular-' + faq.id">
                <div class="popular-faq-item" @click="scrollToFaq(faq.id)">
                    <p class="popular-faq-question" x-text="faq.question"></p>
                    <div class="popular-faq-meta">
                        <span class="views">
                            <i class="fas fa-eye"></i>
                            <span x-text="faq.views"></span>
                        </span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<style>
.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.faq-header {
    text-align: center;
    margin-bottom: 2rem;
}

.faq-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.faq-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

.faq-search-wrapper .input-group-text {
    background: #f8f9fa;
    border-right: none;
}

.faq-search-wrapper .form-control {
    border-left: none;
    background: #f8f9fa;
}

.faq-search-wrapper .form-control:focus {
    background: white;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.faq-categories {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.category-btn {
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.category-btn.active {
    background: #667eea;
    border-color: #667eea;
    color: white;
}

.faq-item {
    border: none;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.faq-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.faq-question {
    background: white;
    border: none;
    padding: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    text-align: left;
    width: 100%;
    position: relative;
}

.faq-question:not(.collapsed) {
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.faq-question-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.faq-question-text {
    font-size: 1rem;
    line-height: 1.4;
}

.faq-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
}

.faq-category {
    font-size: 0.75rem;
}

.faq-views {
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.faq-answer {
    padding: 1.25rem;
    background: #fafafa;
}

.faq-answer-content {
    line-height: 1.6;
    color: #495057;
}

.faq-answer-content p {
    margin-bottom: 1rem;
}

.faq-answer-content p:last-child {
    margin-bottom: 0;
}

.faq-actions {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.faq-helpful,
.faq-share {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

.faq-sidebar {
    margin-top: 3rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.sidebar-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
}

.popular-faq-item {
    padding: 0.75rem;
    background: white;
    border-radius: 6px;
    margin-bottom: 0.5rem;
    cursor: pointer;
    transition: background 0.2s ease;
}

.popular-faq-item:hover {
    background: #e9ecef;
}

.popular-faq-question {
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.popular-faq-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.popular-faq-meta .views {
    font-size: 0.75rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.faq-no-results {
    color: #6c757d;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .faq-categories {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    
    .category-btn {
        flex-shrink: 0;
    }
    
    .faq-question {
        padding: 1rem;
    }
    
    .faq-answer {
        padding: 1rem;
    }
    
    .faq-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .faq-actions button {
        text-align: center;
    }
}

/* Animation for FAQ opening */
.accordion-collapse {
    transition: height 0.3s ease;
}

/* Custom scrollbar for mobile */
.faq-categories::-webkit-scrollbar {
    height: 4px;
}

.faq-categories::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.faq-categories::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.faq-categories::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
function faqAccordion() {
    return {
        faqs: [],
        filteredFaqs: [],
        popularFaqs: [],
        categories: [],
        selectedCategory: 'all',
        searchQuery: '',
        loading: true,

        async loadFaqs() {
            try {
                const response = await fetch('/api/faqs');
                const data = await response.json();
                
                // Flatten grouped FAQs
                this.faqs = [];
                Object.values(data.faqs).forEach(categoryFaqs => {
                    this.faqs = this.faqs.concat(categoryFaqs);
                });
                
                this.categories = data.categories;
                this.filteredFaqs = this.faqs;
                
                // Get popular FAQs (sorted by views)
                this.popularFaqs = [...this.faqs]
                    .sort((a, b) => b.views - a.views)
                    .slice(0, 10);
                
                this.loading = false;
            } catch (error) {
                console.error('Error loading FAQs:', error);
                this.loading = false;
            }
        },

        selectCategory(category) {
            this.selectedCategory = category;
            this.filterFaqs();
        },

        filterFaqs() {
            let filtered = this.faqs;

            // Filter by category
            if (this.selectedCategory !== 'all') {
                filtered = filtered.filter(faq => faq.category === this.selectedCategory);
            }

            // Filter by search query
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(faq => 
                    faq.question.toLowerCase().includes(query) ||
                    faq.answer.toLowerCase().includes(query) ||
                    (faq.keywords && faq.keywords.some(keyword => 
                        keyword.toLowerCase().includes(query)
                    ))
                );
            }

            this.filteredFaqs = filtered;
        },

        formatCategory(category) {
            return category
                .split('_')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        },

        formatAnswer(answer) {
            // Convert newlines to paragraphs and make URLs clickable
            return answer
                .split('\n\n')
                .map(paragraph => `<p>${paragraph.replace(/\n/g, '<br>')}</p>`)
                .join('')
                .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank" class="text-primary">$1</a>');
        },

        async toggleFaq(faqId) {
            // Track FAQ view
            try {
                await fetch(`/api/faqs/${faqId}`, {
                    method: 'GET'
                });
                
                // Update local views count
                const faq = this.faqs.find(f => f.id === faqId);
                if (faq) {
                    faq.views++;
                }
            } catch (error) {
                console.error('Error tracking FAQ view:', error);
            }
        },

        async markHelpful(faqId) {
            // Could implement helpful voting system
            alert('Terima kasih atas feedback Anda!');
        },

        shareFaq(faq) {
            if (navigator.share) {
                navigator.share({
                    title: faq.question,
                    text: faq.answer,
                    url: window.location.href + '#faq-' + faq.id
                });
            } else {
                // Fallback: copy to clipboard
                const text = `${faq.question}\n\n${faq.answer}\n\n${window.location.href}#faq-${faq.id}`;
                navigator.clipboard.writeText(text).then(() => {
                    alert('FAQ berhasil disalin ke clipboard!');
                });
            }
        },

        scrollToFaq(faqId) {
            const element = document.getElementById(`faq-heading-${faqId}`);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.querySelector('button').click();
            }
        }
    }
}
</script>
