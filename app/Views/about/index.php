<div class="position-relative">
    <!-- Hero Banner for About Page -->
    <div class="about-hero position-relative text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/slide_02.jpg') center/cover no-repeat; min-height: 400px; display: flex; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" style="color: rgba(255, 255, 255, 1);">About Shop Convenient</h1>
                    <p class="lead fs-4 animate__animated animate__fadeInUp" style="color: rgba(255, 255, 255, 0.7);">Your trusted partner for quality products and exceptional service</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container py-5 position-relative" style="margin-top: -50px; z-index: 10;">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white rounded-pill px-4 py-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <?php if (isset($error) && $error): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 py-3 shadow-sm" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row mb-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
            <div class="col-12">
                <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-4 g-lg-5">
                            <div class="col-lg-6">
                                <div class="mb-4 mb-lg-5">
                                    <h2 class="display-5 fw-bold mb-4 text-danger">Our Story</h2>
                                    <p class="lead mb-4">We are dedicated to providing quality products with exceptional customer service.</p>
                                    
                                    <p class="mb-4">At Shop Convenient, we believe in offering our customers the best shopping experience possible. Our team is committed to sourcing high-quality products and delivering them promptly to your doorstep.</p>
                                    
                                    <p class="mb-4">We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
                                </div>
                                
                                <div class="row mt-4 mt-lg-5 g-4">
                                    <div class="col-md-6">
                                        <div class="card border-0 rounded-3 h-100 hover-lift" style="background-color: #f8f9fa;">
                                            <div class="card-body p-4">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-wrapper bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                        <i class="fa fa-check-circle fa-lg"></i>
                                                    </div>
                                                    <h5 class="mb-0 text-danger">Quality Assured</h5>
                                                </div>
                                                <p class="mb-0">All products are carefully vetted for quality and authenticity.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="card border-0 rounded-3 h-100 hover-lift" style="background-color: #f8f9fa;">
                                            <div class="card-body p-4">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-wrapper bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                        <i class="fa fa-truck fa-lg"></i>
                                                    </div>
                                                    <h5 class="mb-0 text-danger">Fast Delivery</h5>
                                                </div>
                                                <p class="mb-0">Quick and reliable shipping across the nation.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="position-relative h-100">
                                    <div class="bg-light rounded-3 p-4 p-lg-5 h-100 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                        <h3 class="mb-4">Why Choose Us?</h3>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0; border: 2px solid #dc3545;">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Quality Products</h5>
                                                <p class="mb-0 text-muted">Guaranteed authentic products from trusted brands.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0; border: 2px solid #dc3545;">
                                                <i class="fa fa-truck"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Fast Delivery</h5>
                                                <p class="mb-0 text-muted">Nationwide shipping with tracking.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0; border: 2px solid #dc3545;">
                                                <i class="fa fa-headphones"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">24/7 Support</h5>
                                                <p class="mb-0 text-muted">Round-the-clock customer assistance.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mb-4">
                                            <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0; border: 2px solid #dc3545;">
                                                <i class="fa fa-refresh"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Easy Returns</h5>
                                                <p class="mb-0 text-muted">30-day hassle-free return policy.</p>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex">
                                            <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; flex-shrink: 0; border: 2px solid #dc3545;">
                                                <i class="fa fa-shield"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-1">Secure Payments</h5>
                                                <p class="mb-0 text-muted">Multiple secure payment options.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mb-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
            <div class="col-md-6">
                <div class="card border-0 rounded-3 h-100 hover-lift">
                    <div class="card-header py-4 text-center" style="background-color: #f8f9fa;">
                        <i class="fa fa-bullseye fa-2x mb-3 text-danger"></i>
                        <h3 class="mb-0 text-danger">Our Mission</h3>
                    </div>
                    <div class="card-body p-4 d-flex align-items-center">
                        <p class="mb-0 fs-5">To provide quality products and exceptional service that exceed our customers' expectations, making online shopping convenient, reliable, and enjoyable for everyone.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 rounded-3 h-100 hover-lift">
                    <div class="card-header py-4 text-center" style="background-color: #f8f9fa;">
                        <i class="fa fa-eye fa-2x mb-3 text-danger"></i>
                        <h3 class="mb-0 text-danger">Our Vision</h3>
                    </div>
                    <div class="card-body p-4 d-flex align-items-center">
                        <p class="mb-0 fs-5">To be the most trusted and convenient online shopping destination in Nigeria, recognized for our commitment to quality, service, and customer satisfaction.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
            <div class="col-12 text-center py-5">
                <h2 class="display-4 fw-bold mb-4">Meet Our Developer</h2>
                <p class="lead mb-5">The talented individual behind this platform</p>
                
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card border-0 rounded-3 hover-lift" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <div class="card-body p-4 p-lg-5 text-center">
                                <div class="developer-avatar bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; border: 3px solid #f33f3f;">
                                    <i class="fa fa-user fa-3x text-danger"></i>
                                </div>
                                <h3 class="mb-2">Akinsoyin Anjola Anuoluwapo</h3>
                                <p class="text-danger fw-bold mb-3">Lead Developer</p>
                                <p class="mb-0 text-muted">Passionate developer dedicated to creating exceptional digital experiences. Committed to delivering high-quality, user-friendly solutions that exceed expectations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .about-hero {
        min-height: 300px;
    }
    
    .display-3 {
        font-size: 2rem;
    }
    
    .display-4 {
        font-size: 1.75rem;
    }
    
    .display-5 {
        font-size: 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .p-5 {
        padding: 1.5rem !important;
    }
    
    .rounded-3 {
        border-radius: 1rem !important;
    }
    
    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.075) !important;
    }
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.fade-in-element {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}
</style>

<script>
// Fade in elements when they come into view
function checkFadeElements() {
    const fadeElements = document.querySelectorAll('.fade-in-element');
    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
}

// Check on scroll and initial load
window.addEventListener('scroll', checkFadeElements);
window.addEventListener('load', checkFadeElements);

// Initial check in case element is already in view
setTimeout(checkFadeElements, 100);
</script>