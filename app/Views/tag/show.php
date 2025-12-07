<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products tagged "<?= $tag['name'] ?? 'Tag' ?>"</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <?php if (isset($error) && $error): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Products tagged "<?= $tag['name'] ?? 'Tag' ?>"</h1>
                <!-- <span class="text-muted"><?= $totalCount ?? 0 ?> products</span> -->
            </div>
        </div>
    </div>
    
    <?php if (isset($products) && !empty($products)): ?>
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
        
        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Product pagination">
                        <ul class="pagination justify-content-center">
                            <?php if (isset($currentPage) && $currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= (isset($currentPage) && $currentPage == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if (isset($currentPage) && $currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>No products found</h4>
                    <p>There are no products tagged with "<?= $tag['name'] ?? 'this tag' ?>".</p>
                    <a href="/" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
@media (max-width: 768px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .img-fluid {
        max-height: 250px !important;
    }
    
    .h5 {
        font-size: 1.1rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
}

.shadow {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.hover-zoom {
    transition: transform 0.3s ease;
}

.hover-zoom:hover {
    transform: scale(1.05);
}
</style>