<!-- Hero Section -->
<div class="hero-section bg-gradient-primary text-white py-5 py-md-7">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Welcome to Shop Convenient</h1>
                <p class="lead mb-4">Discover amazing products at unbeatable prices. Quality you can trust, service you can rely on.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="/products" class="btn btn-light btn-lg px-4 py-2">
                        <i class="fa fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <a href="/about" class="btn btn-outline-light btn-lg px-4 py-2">
                        <i class="fa fa-info-circle me-2"></i>Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container rounded-3 overflow-hidden shadow-lg">
                    <div class="bg-light p-5 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                        <i class="fa fa-shopping-cart fa-5x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features-section py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card bg-white p-4 rounded-3 shadow-sm h-100 text-center">
                    <div class="feature-icon bg-primary text-white rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; line-height: 70px;">
                        <i class="fa fa-truck fa-2x"></i>
                    </div>
                    <h3 class="h5 mb-3">Free Shipping</h3>
                    <p class="text-muted mb-0">On orders over ₦50,000. Fast and reliable delivery to your doorstep.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card bg-white p-4 rounded-3 shadow-sm h-100 text-center">
                    <div class="feature-icon bg-success text-white rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; line-height: 70px;">
                        <i class="fa fa-shield fa-2x"></i>
                    </div>
                    <h3 class="h5 mb-3">Secure Payments</h3>
                    <p class="text-muted mb-0">Your payment information is protected with industry-leading security.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card bg-white p-4 rounded-3 shadow-sm h-100 text-center">
                    <div class="feature-icon bg-danger text-white rounded-circle mx-auto mb-3" style="width: 70px; height: 70px; line-height: 70px;">
                        <i class="fa fa-headphones fa-2x"></i>
                    </div>
                    <h3 class="h5 mb-3">24/7 Support</h3>
                    <p class="text-muted mb-0">Our customer service team is ready to assist you anytime.</p>
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
        <a href="/products" class="btn btn-outline-primary btn-lg">View All Products</a>
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
                            <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- About Section -->
<div class="about-section py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image-container rounded-3 overflow-hidden shadow-lg">
                    <div class="bg-light p-5 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                        <i class="fa fa-building fa-5x text-muted"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="display-6 fw-bold mb-4">About Shop Convenient</h2>
                <p class="lead mb-4">We offer premium quality products with the best customer service. Our commitment is to provide you with an exceptional shopping experience.</p>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Quality Products</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Original Products. Best Quality</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> 24/7 Online Support</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Quick Response</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Door Step Delivery</li>
                            <li class="mb-3"><i class="fa fa-check-circle text-success me-2"></i> Easy Returns</li>
                        </ul>
                    </div>
                </div>
                
                <a href="/about" class="btn btn-primary btn-lg px-4 py-2">Read More</a>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #f33f3f 0%, #121212 100%);
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

@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 0;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .display-5 {
        font-size: 2rem;
    }
    
    .feature-card {
        margin-bottom: 1.5rem;
    }
}
</style>