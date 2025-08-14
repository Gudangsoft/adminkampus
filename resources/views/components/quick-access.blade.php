@php
    $config = config('quick-access');
    $isEnabled = $config['enabled'] ?? true;
    $position = $config['position'] ?? 'right';
    $services = $config['services'] ?? [];
@endphp

@if($isEnabled)
<!-- Quick Access Buttons Component -->
<div class="quick-access-container" 
     data-position="{{ $position }}"
     x-data="quickAccess({{ json_encode($services) }})" 
     x-init="init()"
    <!-- Floating Quick Access Button -->
    <div class="quick-access-toggle" 
         :class="{ 'active': isOpen }"
         @click="console.log('Quick access toggle clicked'); toggleMenu()"
         x-show="!isOpen || isMobile">
        <div class="toggle-icon">
            <i class="fas" :class="isOpen ? 'fa-times' : 'fa-rocket'"></i>
        </div>
        <span class="toggle-text" x-show="!isMobile">Layanan Cepat</span>
    </div>

    <!-- Quick Access Menu -->
    <div class="quick-access-menu" 
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-300 delay-100"
         x-transition:enter-start="opacity-0 transform translateY(20px)"
         x-transition:enter-end="opacity-100 transform translateY(0)"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translateY(0)"
         x-transition:leave-end="opacity-0 transform translateY(20px)">
        
        <!-- Academic Services -->
        <div class="service-group">
            <h6 class="service-group-title">
                <i class="fas fa-graduation-cap text-primary me-2"></i>
                Layanan Akademik
            </h6>
            <div class="service-buttons">
                <template x-for="service in academicServices" :key="service.id">
                    <div class="service-button" @click="handleServiceClick(service)">
                        <div class="service-icon" :style="{ background: service.color }">
                            <i :class="service.icon"></i>
                        </div>
                        <div class="service-content">
                            <h6 class="service-title" x-text="service.title"></h6>
                            <p class="service-description" x-text="service.description"></p>
                        </div>
                        <div class="service-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Student Services -->
        <div class="service-group">
            <h6 class="service-group-title">
                <i class="fas fa-users text-success me-2"></i>
                Layanan Mahasiswa
            </h6>
            <div class="service-buttons">
                <template x-for="service in studentServices" :key="service.id">
                    <div class="service-button" @click="handleServiceClick(service)">
                        <div class="service-icon" :style="{ background: service.color }">
                            <i :class="service.icon"></i>
                        </div>
                        <div class="service-content">
                            <h6 class="service-title" x-text="service.title"></h6>
                            <p class="service-description" x-text="service.description"></p>
                        </div>
                        <div class="service-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Information Services -->
        <div class="service-group">
            <h6 class="service-group-title">
                <i class="fas fa-info-circle text-warning me-2"></i>
                Informasi
            </h6>
            <div class="service-buttons">
                <template x-for="service in informationServices" :key="service.id">
                    <div class="service-button" @click="handleServiceClick(service)">
                        <div class="service-icon" :style="{ background: service.color }">
                            <i :class="service.icon"></i>
                        </div>
                        <div class="service-content">
                            <h6 class="service-title" x-text="service.title"></h6>
                            <p class="service-description" x-text="service.description"></p>
                        </div>
                        <div class="service-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Contact Services -->
        <div class="service-group">
            <h6 class="service-group-title">
                <i class="fas fa-phone text-danger me-2"></i>
                Kontak Darurat
            </h6>
            <div class="contact-buttons">
                <template x-for="contact in emergencyContacts" :key="contact.id">
                    <div class="contact-button" @click="handleContactClick(contact)">
                        <div class="contact-icon" :style="{ background: contact.color }">
                            <i :class="contact.icon"></i>
                        </div>
                        <div class="contact-info">
                            <h6 class="contact-title" x-text="contact.title"></h6>
                            <p class="contact-detail" x-text="contact.detail"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Service Modal -->
    <div class="service-modal" x-show="showModal" @click.self="closeModal()"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="modal-content" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">
            <div class="modal-header">
                <h5 class="modal-title" x-text="selectedService?.title"></h5>
                <button class="modal-close" @click="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="service-detail" x-show="selectedService">
                    <div class="service-detail-icon" :style="{ background: selectedService?.color }">
                        <i :class="selectedService?.icon"></i>
                    </div>
                    <h6 x-text="selectedService?.title"></h6>
                    <p x-text="selectedService?.fullDescription"></p>
                    
                    <div class="service-actions" x-show="selectedService?.actions">
                        <template x-for="action in selectedService?.actions" :key="action.label">
                            <button class="btn btn-primary service-action-btn" @click="executeAction(action)">
                                <i :class="action.icon"></i>
                                <span x-text="action.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.quick-access-container {
    position: fixed;
    bottom: 80px;
    right: 20px;
    z-index: 999;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.quick-access-toggle {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    color: white;
    border-radius: 25px;
    padding: 12px 20px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    user-select: none;
}

.quick-access-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
}

.quick-access-toggle.active {
    background: linear-gradient(135deg, #ff4757 0%, #c44569 100%);
}

.toggle-icon {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.toggle-text {
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
}

.quick-access-menu {
    position: absolute;
    bottom: 60px;
    right: 0;
    width: 380px;
    max-height: 70vh;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    overflow-y: auto;
    padding: 20px;
}

.service-group {
    margin-bottom: 25px;
}

.service-group:last-child {
    margin-bottom: 0;
}

.service-group-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f2f6;
}

.service-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.service-button {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.service-button:hover {
    background: #e9ecef;
    transform: translateX(5px);
    border-color: #dee2e6;
}

.service-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    margin-right: 15px;
    flex-shrink: 0;
}

.service-content {
    flex: 1;
}

.service-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0 0 5px 0;
    font-size: 14px;
}

.service-description {
    color: #6c757d;
    margin: 0;
    font-size: 12px;
    line-height: 1.3;
}

.service-arrow {
    color: #6c757d;
    font-size: 12px;
    opacity: 0.7;
    transition: transform 0.2s ease;
}

.service-button:hover .service-arrow {
    transform: translateX(3px);
}

.contact-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.contact-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 10px;
    background: #f8f9fa;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    border: 1px solid transparent;
}

.contact-button:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    border-color: #dee2e6;
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    margin-bottom: 10px;
}

.contact-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0 0 5px 0;
    font-size: 13px;
}

.contact-detail {
    color: #6c757d;
    margin: 0;
    font-size: 11px;
}

.service-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1001;
}

.modal-content {
    background: white;
    border-radius: 15px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 0;
}

.modal-title {
    color: #2c3e50;
    font-weight: 600;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    color: #6c757d;
    font-size: 20px;
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    transition: background 0.2s;
}

.modal-close:hover {
    background: #f8f9fa;
}

.modal-body {
    padding: 20px;
}

.service-detail {
    text-align: center;
}

.service-detail-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    margin: 0 auto 20px;
}

.service-detail h6 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
}

.service-detail p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
}

.service-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.service-action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .quick-access-container {
        bottom: 70px;
        right: 10px;
    }
    
    .quick-access-menu {
        width: calc(100vw - 20px);
        max-width: 350px;
        right: -10px;
    }
    
    .toggle-text {
        display: none;
    }
    
    .quick-access-toggle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        padding: 0;
        justify-content: center;
    }
    
    .contact-buttons {
        grid-template-columns: 1fr;
    }
    
    .service-button {
        padding: 12px;
    }
    
    .service-icon {
        width: 40px;
        height: 40px;
        margin-right: 12px;
    }
}

/* Custom scrollbar */
.quick-access-menu::-webkit-scrollbar {
    width: 6px;
}

.quick-access-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.quick-access-menu::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.quick-access-menu::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
function quickAccess(configServices = {}) {
    return {
        isOpen: false,
        isMobile: window.innerWidth <= 768,
        showModal: false,
        selectedService: null,
        
        // Convert config data to component format
        academicServices: [],
        studentServices: [],
        informationServices: [],
        contactServices: [],

        init() {
            this.loadServicesFromConfig(configServices);
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth <= 768;
            });
        },

        loadServicesFromConfig(services) {
            // Academic services
            if (services.academic && services.academic.enabled) {
                this.academicServices = services.academic.items.map((item, index) => ({
                    id: `academic_${index}`,
                    title: item.title,
                    description: item.title,
                    icon: item.icon,
                    color: this.getServiceColor(index),
                    url: item.url,
                    external: item.external,
                    actions: [
                        { 
                            label: item.external ? 'Buka Link' : 'Lihat Halaman', 
                            icon: 'fas fa-arrow-right', 
                            action: 'navigate', 
                            url: item.url 
                        }
                    ]
                }));
            }

            // Student services
            if (services.student && services.student.enabled) {
                this.studentServices = services.student.items.map((item, index) => ({
                    id: `student_${index}`,
                    title: item.title,
                    description: item.title,
                    icon: item.icon,
                    color: this.getServiceColor(index + 10),
                    url: item.url,
                    external: item.external,
                    actions: [
                        { 
                            label: item.external ? 'Buka Link' : 'Lihat Halaman', 
                            icon: 'fas fa-arrow-right', 
                            action: 'navigate', 
                            url: item.url 
                        }
                    ]
                }));
            }

            // Information services
            if (services.information && services.information.enabled) {
                this.informationServices = services.information.items.map((item, index) => ({
                    id: `info_${index}`,
                    title: item.title,
                    description: item.title,
                    icon: item.icon,
                    color: this.getServiceColor(index + 20),
                    url: item.url,
                    external: item.external,
                    actions: [
                        { 
                            label: item.external ? 'Buka Link' : 'Lihat Halaman', 
                            icon: 'fas fa-arrow-right', 
                            action: 'navigate', 
                            url: item.url 
                        }
                    ]
                }));
            }

            // Contact services
            if (services.contact && services.contact.enabled) {
                this.contactServices = services.contact.items.map((item, index) => ({
                    id: `contact_${index}`,
                    title: item.title,
                    description: item.title,
                    icon: item.icon,
                    color: this.getServiceColor(index + 30),
                    url: item.url,
                    external: item.external,
                    actions: [
                        { 
                            label: item.external ? 'Buka Link' : 'Lihat Halaman', 
                            icon: 'fas fa-arrow-right', 
                            action: 'navigate', 
                            url: item.url 
                        }
                    ]
                }));
            }
        },

        getServiceColor(index) {
            const colors = [
                'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
                'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
                'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)',
                'linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%)',
                'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
            ];
            return colors[index % colors.length];
        },
                id: 'scholarship',
                title: 'Info Beasiswa',
                description: 'Informasi beasiswa dan bantuan',
                fullDescription: 'Temukan berbagai program beasiswa internal dan eksternal. Panduan lengkap syarat dan cara pendaftaran beasiswa.',
                icon: 'fas fa-graduation-cap',
                color: 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                actions: [
                    { label: 'Lihat Beasiswa', icon: 'fas fa-list', action: 'navigate', url: '/beasiswa' },
                    { label: 'Konsultasi', icon: 'fas fa-comments', action: 'chat', message: 'Saya ingin konsultasi tentang beasiswa' }
                ]
            },
            {
                id: 'dormitory',
                title: 'Asrama Mahasiswa',
                description: 'Informasi dan pendaftaran asrama',
                fullDescription: 'Layanan asrama mahasiswa dengan fasilitas lengkap. Pendaftaran online dan informasi ketersediaan kamar.',
                icon: 'fas fa-bed',
                color: 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
                actions: [
                    { label: 'Daftar Asrama', icon: 'fas fa-home', action: 'navigate', url: '/asrama' },
                    { label: 'Virtual Tour', icon: 'fas fa-street-view', action: 'navigate', url: '/asrama/tour' }
                ]
            }
        ],

        informationServices: [
            {
                id: 'news',
                title: 'Berita Kampus',
                description: 'Berita dan pengumuman terbaru',
                fullDescription: 'Update terkini tentang kegiatan kampus, prestasi mahasiswa, dan pengumuman penting dari berbagai fakultas.',
                icon: 'fas fa-newspaper',
                color: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                actions: [
                    { label: 'Baca Berita', icon: 'fas fa-newspaper', action: 'navigate', url: '/berita' },
                    { label: 'Subscribe Newsletter', icon: 'fas fa-envelope', action: 'newsletter', email: true }
                ]
            },
            {
                id: 'events',
                title: 'Event & Kegiatan',
                description: 'Kalender event dan kegiatan kampus',
                fullDescription: 'Jadwal lengkap seminar, workshop, kompetisi, dan kegiatan kemahasiswaan. Jangan lewatkan event menarik!',
                icon: 'fas fa-calendar-check',
                color: 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
                actions: [
                    { label: 'Lihat Event', icon: 'fas fa-calendar', action: 'navigate', url: '/events' },
                    { label: 'Daftar Event', icon: 'fas fa-ticket-alt', action: 'navigate', url: '/events/register' }
                ]
            },
            {
                id: 'career',
                title: 'Pusat Karir',
                description: 'Lowongan kerja dan magang',
                fullDescription: 'Pusat informasi karir dengan lowongan kerja, program magang, dan bimbingan pengembangan karir untuk mahasiswa dan alumni.',
                icon: 'fas fa-briefcase',
                color: 'linear-gradient(135deg, #ffd89b 0%, #19547b 100%)',
                actions: [
                    { label: 'Cari Lowongan', icon: 'fas fa-search', action: 'navigate', url: '/karir' },
                    { label: 'Upload CV', icon: 'fas fa-upload', action: 'navigate', url: '/karir/cv' }
                ]
            }
        ],

        emergencyContacts: [
            {
                id: 'security',
                title: 'Keamanan Kampus',
                detail: '(021) 123-4567',
                icon: 'fas fa-shield-alt',
                color: 'linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%)',
                phone: '02112345678'
            },
            {
                id: 'medical',
                title: 'Unit Kesehatan',
                detail: '(021) 234-5678',
                icon: 'fas fa-heartbeat',
                color: 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)',
                phone: '02123456789'
            },
            {
                id: 'admin',
                title: 'Admin Kampus',
                detail: '(021) 345-6789',
                icon: 'fas fa-phone',
                color: 'linear-gradient(135deg, #3498db 0%, #2980b9 100%)',
                phone: '02134567890'
            },
            {
                id: 'whatsapp',
                title: 'WhatsApp Bantuan',
                detail: '+62 812-3456-7890',
                icon: 'fab fa-whatsapp',
                color: 'linear-gradient(135deg, #25d366 0%, #128c7e 100%)',
                whatsapp: '6281234567890'
            }
        ],

        toggleMenu() {
            console.log('toggleMenu called. Current isOpen:', this.isOpen);
            this.isOpen = !this.isOpen;
            console.log('toggleMenu updated. New isOpen:', this.isOpen);
        },

        handleServiceClick(service) {
            this.selectedService = service;
            this.showModal = true;
            this.isOpen = false;
        },

        handleContactClick(contact) {
            if (contact.phone) {
                window.open(`tel:${contact.phone}`, '_self');
            } else if (contact.whatsapp) {
                window.open(`https://wa.me/${contact.whatsapp}`, '_blank');
            }
        },

        executeAction(action) {
            switch (action.action) {
                case 'navigate':
                    window.open(action.url, '_blank');
                    break;
                case 'download':
                    window.open(action.url, '_blank');
                    break;
                case 'chat':
                    // Trigger chat widget with predefined message
                    if (window.chatWidget) {
                        window.chatWidget.sendQuickMessage(action.message);
                    }
                    break;
                case 'newsletter':
                    // Open newsletter subscription
                    this.openNewsletterModal();
                    break;
            }
            this.closeModal();
        },

        closeModal() {
            this.showModal = false;
            this.selectedService = null;
        },

        openNewsletterModal() {
            // Could integrate with newsletter component
            alert('Newsletter subscription akan segera tersedia!');
        }
    }
}
</script>

@endif
