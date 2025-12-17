{{-- Dynamic UI Enhancements untuk semua halaman Guru --}}
<style>
    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(2px);
    }

    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #2E7D32;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Fade In Animation */
    .fade-in {
        animation: fadeIn 0.4s ease-in;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(-10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    /* Card Animations */
    .card {
        transition: all 0.3s ease;
        animation: fadeIn 0.4s ease-in;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    /* Form Controls */
    .form-select, .form-control {
        transition: all 0.2s ease;
    }

    .form-select:focus, .form-control:focus {
        transform: scale(1.02);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
        border-color: #2E7D32;
    }

    /* Button Animations */
    .btn {
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn:active {
        transform: translateY(0);
    }

    /* Table Animations */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    /* Alert Animations */
    .alert {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Success Notification */
    .success-feedback {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
        display: none;
        animation: slideInRight 0.3s ease-out;
        min-width: 250px;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Error Notification */
    .error-feedback {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #dc3545;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
        display: none;
        animation: slideInRight 0.3s ease-out;
        min-width: 250px;
    }

    /* Pulse Animation */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    /* Ripple Effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Validation Feedback */
    .is-valid {
        border-color: #28a745 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none'%3e%3ccircle cx='6' cy='6' r='4.5' stroke='%23dc3545' stroke-width='1'/%3e%3cpath stroke='%23dc3545' stroke-linecap='round' d='m5.8 3.6.4.4.4-.4m0 4.8-.4-.4-.4.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Stagger Animation untuk Table Rows */
    .table tbody tr {
        opacity: 0;
        animation: fadeInRow 0.3s ease forwards;
    }

    .table tbody tr:nth-child(1) { animation-delay: 0.05s; }
    .table tbody tr:nth-child(2) { animation-delay: 0.1s; }
    .table tbody tr:nth-child(3) { animation-delay: 0.15s; }
    .table tbody tr:nth-child(4) { animation-delay: 0.2s; }
    .table tbody tr:nth-child(5) { animation-delay: 0.25s; }
    .table tbody tr:nth-child(6) { animation-delay: 0.3s; }
    .table tbody tr:nth-child(7) { animation-delay: 0.35s; }
    .table tbody tr:nth-child(8) { animation-delay: 0.4s; }
    .table tbody tr:nth-child(9) { animation-delay: 0.45s; }
    .table tbody tr:nth-child(10) { animation-delay: 0.5s; }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Stagger Animation */
    .card {
        opacity: 0;
        animation: fadeInCard 0.4s ease forwards;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInCard {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Badge Animations */
    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.1);
    }

    /* Modal Animations */
    .modal-content {
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Page Transition */
    .page-content {
        animation: pageFadeIn 0.4s ease;
    }

    @keyframes pageFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
    // Global Dynamic UI Functions
    (function() {
        'use strict';

        // Loading Overlay Functions
        window.showLoadingOverlay = function() {
            let overlay = document.getElementById('loadingOverlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'loadingOverlay';
                overlay.className = 'loading-overlay';
                overlay.innerHTML = '<div class="loading-spinner"></div>';
                document.body.appendChild(overlay);
            }
            overlay.style.display = 'flex';
        };

        window.hideLoadingOverlay = function() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        };

        // Success Notification
        window.showSuccessNotification = function(message) {
            let notification = document.getElementById('successNotification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'successNotification';
                notification.className = 'success-feedback';
                document.body.appendChild(notification);
            }
            notification.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + message;
            notification.style.display = 'block';
            
            setTimeout(function() {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100px)';
                setTimeout(function() {
                    notification.style.display = 'none';
                    notification.style.opacity = '1';
                    notification.style.transform = 'translateX(0)';
                }, 300);
            }, 3000);
        };

        // Error Notification
        window.showErrorNotification = function(message) {
            let notification = document.getElementById('errorNotification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'errorNotification';
                notification.className = 'error-feedback';
                document.body.appendChild(notification);
            }
            notification.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + message;
            notification.style.display = 'block';
            
            setTimeout(function() {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100px)';
                setTimeout(function() {
                    notification.style.display = 'none';
                    notification.style.opacity = '1';
                    notification.style.transform = 'translateX(0)';
                }, 300);
            }, 4000);
        };

        // Initialize Dynamic UI saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts dengan animasi
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            });

            // Show success notification dari session
            @if(session('success'))
                setTimeout(function() {
                    showSuccessNotification('{{ session('success') }}');
                }, 500);
            @endif

            // Show error notification dari session
            @if(session('error'))
                setTimeout(function() {
                    showErrorNotification('{{ session('error') }}');
                }, 500);
            @endif

            // Loading overlay untuk semua form submit
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    showLoadingOverlay();
                    
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        
                        // Re-enable setelah 10 detik (fallback)
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                            hideLoadingOverlay();
                        }, 10000);
                    }
                });
            });

            // Real-time validation feedback
            const formInputs = document.querySelectorAll('form input[required], form select[required], form textarea[required]');
            formInputs.forEach(function(input) {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else if (this.value) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // Ripple effect untuk buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(function() {
                        ripple.remove();
                    }, 600);
                });
            });

            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href !== '#' && href.length > 1) {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
            });

            // Animate page content
            const pageContent = document.querySelector('.col-md-9.col-lg-10, .main-content, .container-fluid');
            if (pageContent) {
                pageContent.classList.add('page-content');
            }
        });

        // Handle modal animations
        document.addEventListener('shown.bs.modal', function(e) {
            const modalContent = e.target.querySelector('.modal-content');
            if (modalContent) {
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.9)';
                setTimeout(function() {
                    modalContent.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1)';
                }, 10);
            }
        });
    })();
</script>
