/**
 * Admin Buttons Enhancement Script
 * Provides consistent button behavior, loading states, and user feedback
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Bootstrap tooltips
    initializeTooltips();
    
    // Handle form submissions with loading states
    handleFormSubmissions();
    
    // Handle delete confirmations
    handleDeleteConfirmations();
    
    // Handle modal interactions
    handleModalInteractions();
    
    // Handle status toggle buttons
    handleStatusToggles();
    
    // Auto-submit filters
    handleAutoFilters();
});

/**
 * Initialize Bootstrap tooltips for all elements
 */
function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Handle form submissions with loading states
 */
function handleFormSubmissions() {
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                // Store original content
                var originalContent = submitBtn.innerHTML;
                
                // Add loading state
                submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Memproses...';
                submitBtn.disabled = true;
                
                // Restore button after 5 seconds (fallback)
                setTimeout(function() {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
}

/**
 * Handle delete confirmations with enhanced styling
 */
function handleDeleteConfirmations() {
    document.querySelectorAll('button[onclick*="confirm"], a[onclick*="confirm"]').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            
            var message = this.getAttribute('onclick').match(/confirm\(['"](.+)['"]\)/);
            var confirmText = message ? message[1] : 'Yakin ingin menghapus item ini?';
            
            if (confirm(confirmText + '\n\nTindakan ini tidak dapat dibatalkan.')) {
                if (this.tagName === 'BUTTON') {
                    this.closest('form').submit();
                } else {
                    window.location.href = this.href;
                }
            }
        });
    });
}

/**
 * Handle modal interactions
 */
function handleModalInteractions() {
    // Add fade-in animation for modals
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('show.bs.modal', function() {
            this.style.opacity = '0';
            setTimeout(() => {
                this.style.opacity = '1';
            }, 100);
        });
    });
    
    // Focus first input when modal opens
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            var firstInput = this.querySelector('input:not([type="hidden"]), select, textarea');
            if (firstInput) {
                firstInput.focus();
            }
        });
    });
}

/**
 * Handle status toggle buttons with visual feedback
 */
function handleStatusToggles() {
    document.querySelectorAll('button[title*="Aktifkan"], button[title*="Nonaktifkan"]').forEach(function(button) {
        button.addEventListener('click', function(e) {
            // Add loading state for status toggle
            var icon = this.querySelector('i');
            var originalClass = icon.className;
            
            icon.className = 'fas fa-spinner fa-spin';
            this.disabled = true;
            
            // The form will submit and page will reload, but this provides immediate feedback
        });
    });
}

/**
 * Handle auto-submit for filter dropdowns
 */
function handleAutoFilters() {
    document.querySelectorAll('select[name="status"], select[name="structural_position"], select[name="category"], select[name="position"]').forEach(function(select) {
        select.addEventListener('change', function() {
            // Add loading indicator
            var form = this.closest('form');
            if (form) {
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-1"></i>Memfilter...';
                    submitBtn.disabled = true;
                }
                
                // Submit form after short delay for better UX
                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });
    });
}

/**
 * Add success/error message styling
 */
function enhanceFlashMessages() {
    // Find flash messages and enhance them
    document.querySelectorAll('.alert').forEach(function(alert) {
        // Add auto-hide for success messages
        if (alert.classList.contains('alert-success')) {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        }
        
        // Add close button if not present
        if (!alert.querySelector('.btn-close')) {
            var closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'btn-close';
            closeBtn.setAttribute('data-bs-dismiss', 'alert');
            closeBtn.setAttribute('aria-label', 'Close');
            alert.appendChild(closeBtn);
        }
    });
}

/**
 * Enhance button hover effects
 */
function enhanceButtonEffects() {
    document.querySelectorAll('.btn').forEach(function(button) {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.transition = 'all 0.2s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Call enhancement functions
enhanceFlashMessages();
enhanceButtonEffects();
