<?php if (isset($error) && $error): ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Hero Section -->
<div class="hero-section position-relative overflow-hidden">
    <!-- Background slideshow -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-slide" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)), url('<?= R2_PUBLIC_BUCKET_URL.'/manwithbags.jpg'?>') center/cover no-repeat; height: 100vh;">
                    <div class="container h-100 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-lg-8 mx-auto text-center">
                                <h1 class="display-2 fw-bold mb-4 animate__animated animate__fadeInDown" style="color: rgba(255, 255, 255, 1);">Premium Shopping Experience</h1>
                                <p class="lead fs-4 mb-5 animate__animated animate__fadeInUp" style="color: rgba(255, 255, 255, 0.65);">Discover amazing products at unbeatable prices with fast delivery and exceptional service</p>
                                <div class="animate__animated animate__fadeInUp">
                                    <a href="/products" class="btn btn-danger btn-lg px-5 py-3 me-3 mb-3 mb-md-0">
                                        <i class="fa fa-shopping-bag me-2"></i>Start Shopping
                                    </a>
                                    <a href="/about" class="btn btn-outline-light btn-lg px-5 py-3">
                                        <i class="fa fa-info-circle me-2"></i>Our Story
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)), url('<?= R2_PUBLIC_BUCKET_URL.'/marketplace.jpg'?>') center/cover no-repeat; height: 100vh;">
                    <div class="container h-100 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-lg-8 mx-auto text-center">
                                <h2 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" style="color: rgba(255, 255, 255, 1);">Quality You Can Trust</h2>
                                <p class="lead fs-4 mb-5 animate__animated animate__fadeInUp" style="color: rgba(255, 255, 255, 0.65);">Handpicked products from trusted brands with guaranteed authenticity</p>
                                <div class="animate__animated animate__fadeInUp">
                                    <a href="/products" class="btn btn-danger btn-lg px-5 py-3 me-3 mb-3 mb-md-0">
                                        <i class="fa fa-certificate me-2"></i>Shop Quality
                                    </a>
                                    <!-- <a href="#features" class="btn btn-outline-light btn-lg px-5 py-3 smooth-scroll">
                                        <i class="fa fa-star me-2"></i>Why Choose Us
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)), url('<?= R2_PUBLIC_BUCKET_URL.'/pointingatlaptop.jpg'?>') center/cover no-repeat; height: 100vh;">
                    <div class="container h-100 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-lg-8 mx-auto text-center">
                                <h2 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" style="color: rgba(255, 255, 255, 1);">Fast & Secure Delivery</h2>
                                <p class="lead fs-4 mb-5 animate__animated animate__fadeInUp" style="color: rgba(255, 255, 255, 0.65);">Get your orders delivered quickly and securely to your doorstep</p>
                                <div class="animate__animated animate__fadeInUp">
                                    <!-- <a href="#features" class="btn btn-danger btn-lg px-5 py-3 me-3 mb-3 mb-md-0 smooth-scroll">
                                        <i class="fa fa-truck me-2"></i>Learn More
                                    </a> -->
                                    <a href="/contact" class="btn btn-danger btn-lg px-5 py-3">
                                        <i class="fa fa-phone me-2"></i>Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        <!-- Carousel Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <!-- Removed as per user request -->
</div>

<!-- Features Section -->
<div class="features-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row g-4 justify-content-center">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="color: #212529;">Why Choose Us</h2>
                <p class="lead text-muted mb-0">Experience the difference with our premium services</p>
            </div>
            
            <div class="col-lg-10 mx-auto">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card bg-white p-4 rounded-4 shadow-lg h-100 text-center position-relative overflow-hidden" style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: none;">
                            <div class="feature-number text-danger fw-bold display-3 mb-3" style="font-size: 3.5rem; opacity: 0.1; position: absolute; top: 10px; right: 20px;">01</div>
                            <div class="feature-content position-relative">
                                <h3 class="h4 mb-3 fw-bold" style="color: #f33f3f;">Free Shipping</h3>
                                <div class="feature-divider mx-auto mb-3" style="width: 50px; height: 3px; background: linear-gradient(90deg, #f33f3f 0%, #121212 100%); border-radius: 3px;"></div>
                                <p class="text-muted mb-0">On orders over ₦50,000. Fast and reliable delivery to your doorstep with real-time tracking.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="feature-card bg-white p-4 rounded-4 shadow-lg h-100 text-center position-relative overflow-hidden" style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: none;">
                            <div class="feature-number text-danger fw-bold display-3 mb-3" style="font-size: 3.5rem; opacity: 0.1; position: absolute; top: 10px; right: 20px;">02</div>
                            <div class="feature-content position-relative">
                                <h3 class="h4 mb-3 fw-bold" style="color: #f33f3f;">Secure Payments</h3>
                                <div class="feature-divider mx-auto mb-3" style="width: 50px; height: 3px; background: linear-gradient(90deg, #f33f3f 0%, #121212 100%); border-radius: 3px;"></div>
                                <p class="text-muted mb-0">Your payment information is protected with industry-leading security and encryption technology.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="feature-card bg-white p-4 rounded-4 shadow-lg h-100 text-center position-relative overflow-hidden" style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: none;">
                            <div class="feature-number text-danger fw-bold display-3 mb-3" style="font-size: 3.5rem; opacity: 0.1; position: absolute; top: 10px; right: 20px;">03</div>
                            <div class="feature-content position-relative">
                                <h3 class="h4 mb-3 fw-bold" style="color: #f33f3f;">24/7 Support</h3>
                                <div class="feature-divider mx-auto mb-3" style="width: 50px; height: 3px; background: linear-gradient(90deg, #f33f3f 0%, #121212 100%); border-radius: 3px;"></div>
                                <p class="text-muted mb-0">Our dedicated customer service team is ready to assist you anytime with personalized support.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hottest Products Section -->
<div class="container py-5">
    <div class="section-header text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Hottest Products</h2>
        <p class="lead text-muted mb-4">Check out our most popular items loved by customers</p>
        <a href="/products" class="btn btn-outline-danger btn-lg">View All Products</a>
    </div>
    
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 product-item shadow-sm hover-lift border-0">
                    <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>">
                        <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" class="card-img-top hover-zoom" style="height: 250px; object-fit: cover;">
                    </a>
                    <div class="card-body down-content">
                        <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="text-decoration-none">
                            <h5 class="card-title"><?= $product['productname'] ?></h5>
                        </a>
                        <p class="card-text small text-muted"><?= substr($product['description'], 0, 100) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="text-danger h5">₦<?= number_format($product['price']) ?></strong>
                            <div>
                                <span class="badge bg-secondary"><?= $product['brand'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <i class="fa fa-star text-warning"></i>
                                <span class="small text-muted ms-1">(5.0)</span>
                            </div>
                            <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="btn btn-outline-primary me-2">
                                <i class="fa fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tags Section -->
<?php if (isset($tagsWithProducts) && !empty($tagsWithProducts)): ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Shop by Tags</h2>
                <p class="lead text-muted mb-4">Browse our products organized by categories and interests</p>
            </div>
        </div>
        
        <?php foreach ($tagsWithProducts as $index => $tag): ?>
            <?php if (!empty($tag['products'])): ?>
                <!-- Tag Section with Background and Separator -->
                <div class="tag-section mb-5 rounded-4 shadow-sm">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">
                                        <a href="/tag/<?= $tag['slug'] ?>" class="text-decoration-none text-dark">
                                            <?= $tag['name'] ?>
                                        </a>
                                    </h3>
                                    <a href="/tag/<?= $tag['slug'] ?>" class="btn btn-outline-primary me-2 rounded-pill px-3">View All</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Horizontal scrolling container -->
                        <div class="horizontal-scroll-container">
                            <div class="d-flex" style="gap: 1.5rem; padding: 1rem 0.5rem;">
                                <?php foreach ($tag['products'] as $product): ?>
                                    <div class="card product-item shadow-sm hover-lift border-0 flex-shrink-0" style="width: 16rem; transition: all 0.3s ease;">
                                        <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>">
                                            <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" class="card-img-top hover-zoom" style="height: 200px; object-fit: cover;">
                                        </a>
                                        <div class="card-body down-content p-3">
                                            <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="text-decoration-none">
                                                <h5 class="card-title fs-6 mb-2"><?= $product['productname'] ?></h5>
                                            </a>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-danger">₦<?= number_format($product['price']) ?></strong>
                                                <div>
                                                    <span class="badge bg-secondary"><?= $product['brand'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Separator between tag sections (except after the last one) -->
                <?php if ($index < count($tagsWithProducts) - 1): ?>
                    <hr class="my-4" style="border-top: 2px dashed #dee2e6; opacity: 0.5;">
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- About Section -->
<div class="about-section py-5 position-relative overflow-hidden" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= R2_PUBLIC_BUCKET_URL ?>/banner2.jpg') center/cover no-repeat;" id="aboutSection">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center text-white fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
                <h2 class="display-5 fw-bold mb-4">About Shop Convenient</h2>
                <p class="lead mb-4 fs-5">We offer premium quality products with the best customer service. Our commitment is to provide you with an exceptional shopping experience.</p>
                
                <div class="row mb-4 justify-content-center">
                    <div class="col-md-5 mb-3 mb-md-0">
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Quality Products</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Original Products. Best Quality</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> 24/7 Online Support</li>
                        </ul>
                    </div>
                    <div class="col-md-5">
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Quick Response</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Door Step Delivery</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Easy Returns</li>
                        </ul>
                    </div>
                </div>
                
                <a href="/about" class="btn btn-light btn-lg px-4 py-2 mt-3 rounded-pill">Read More</a>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #f33f3f 0%, #121212 100%);
}

/* Hero Section Styles */
.hero-section {
    min-height: 100vh;
}

.hero-slide {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.carousel-item {
    transition: transform 1s ease-in-out;
}

/* Feature Cards Enhancement */
.feature-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transform: translateY(0);
    border-radius: 1.5rem !important; /* More rounded corners */
}

.feature-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #f33f3f 0%, #121212 100%);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
    border-radius: 1.5rem 1.5rem 0 0 !important; /* Match card rounding */
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-number {
    transition: all 0.3s ease;
}

.feature-card:hover .feature-number {
    opacity: 0.2 !important;
    transform: scale(1.1);
}

/* Product Items Enhancement */
.product-item {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.product-item:hover {
    transform: translateY(-10px);
}

/* About Section Enhancement */
.about-section {
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
}

/* Tag Section Enhancement */
.tag-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    border-radius: 1.5rem !important;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important;
    margin-bottom: 2rem !important;
    padding: 2rem 1rem !important;
    transition: all 0.3s ease;
}

.tag-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* Buttons Enhancement */
.btn {
    transition: all 0.3s ease;
    border-radius: 50px;
    font-weight: 600;
    letter-spacing: 0.5px;
    border: none !important; /* Remove all button borders */
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border: none !important; /* Ensure no border on hover */
}

.btn:active {
    transform: translateY(-1px);
    border: none !important; /* Ensure no border on active state */
}

/* Override Bootstrap outline buttons to remove blue borders */
.btn-outline-primary {
    border: 1px solid #f33f3f !important;
    color: #f33f3f !important;
}

.btn-outline-primary:hover {
    background-color: #f33f3f !important;
    border: 1px solid #f33f3f !important;
    box-shadow: 0 10px 20px rgba(243, 63, 63, 0.2) !important;
}

.btn-outline-danger {
    border: 1px solid #f33f3f !important;
    color: #f33f3f !important;
}

.btn-outline-danger:hover {
    background-color: #f33f3f !important;
    border: 1px solid #f33f3f !important;
    box-shadow: 0 10px 20px rgba(243, 63, 63, 0.2) !important;
}

.btn-outline-light {
    border: 1px solid rgba(255, 255, 255, 0.5) !important;
    color: white !important;
}

.btn-outline-light:hover {
    background-color: white !important;
    color: #212529 !important;
    border: 1px solid white !important;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
}

/* Horizontal Scroll Container */
.horizontal-scroll-container {
    scrollbar-width: thin;
    scrollbar-color: #f33f3f #f1f1f1;
}

.horizontal-scroll-container::-webkit-scrollbar {
    height: 8px;
}

.horizontal-scroll-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.horizontal-scroll-container::-webkit-scrollbar-thumb {
    background: #f33f3f;
    border-radius: 4px;
}

.horizontal-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #d73737;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding: 0;
        margin-top: 0 !important;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .display-5 {
        font-size: 2rem;
    }
    
    .feature-card {
        margin-bottom: 1.5rem;
        border-radius: 1.25rem !important; /* Slightly less rounding on mobile */
    }
    
    .hero-slide {
        min-height: 80vh;
    }
    
    .display-2 {
        font-size: 2.5rem;
    }
    
    .display-3 {
        font-size: 2rem;
    }
    
    .feature-number {
        font-size: 2.5rem !important;
    }
    
    .features-section {
        padding: 2rem 0;
    }
    
    /* Adjust horizontal scroll for mobile */
    .horizontal-scroll-container .card {
        width: 14rem;
    }
    
    /* Tag section adjustments for mobile */
    .tag-section {
        padding: 1.5rem 0.5rem !important;
        border-radius: 1.25rem !important;
    }
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.hover-zoom {
    transition: transform 0.3s ease;
}

.hover-zoom:hover {
    transform: scale(1.05);
}

.feature-card {
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.section-header h2 {
    position: relative;
    display: inline-block;
}

.section-header h2::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: #f33f3f;
    border-radius: 2px;
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
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a.smooth-scroll').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Scroll down indicator - Removed as per user request
</script>