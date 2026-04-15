<div class="card h-100 product-item shadow-sm">
    <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="text-decoration-none">
        <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
    </a>
    <div class="card-body down-content">
        <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="text-decoration-none">
            <h5 class="card-title"><?= $product['productname'] ?></h5>
        </a>
        <p class="card-text small text-muted"><?= substr($product['description'], 0, 80) ?>...</p>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="text-danger h5">₦<?= number_format($product['price']) ?></strong>
            <div>
                <span class="badge bg-secondary"><?= $product['brand'] ?></span>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
                <small class="text-muted ms-1">(5.0)</small>
            </div>
            <a href="/products/<?= $product['category_slug'] ?>/<?= urlencode($product['productname']) ?>/<?= $product['id'] ?>" class="btn btn-sm btn-outline-danger">
                <i class="fa fa-eye me-1"></i> View
            </a>
        </div>
    </div>
</div>