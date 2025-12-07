<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $product['productname'] ?? 'Product Details' ?></li>
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
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <h1 class="mb-0 text-center">Product Details</h1>
                </div>
                <div class="card-body py-4">
                    <?php if (isset($product) && $product): ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-center mb-4">
                                    <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" class="img-fluid rounded shadow" style="max-height: 400px;">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <h2 class="mb-3"><?= $product['productname'] ?></h2>
                                
                                <div class="mb-4">
                                    <span class="h3 text-danger fw-bold">₦<?= number_format($product['price']) ?></span>
                                    <span class="badge bg-secondary ms-2"><?= $product['brand'] ?></span>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="lead"><strong>Description:</strong></p>
                                    <p><?= $product['description'] ?></p>
                                </div>
                                
                                <div class="mb-4">
                                    <?php include 'components/rating.php'; ?>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="h5">
                                        <i class="fa fa-thumbs-up text-primary me-1"></i> 
                                        <span id="upvotes"> <?= $product['upvotes'] ?> </span> <?= ($product['upvotes'] == 1) ? 'Upvote' : 'Upvotes' ?>
                                    </span>
                                </div>
                                
                                <?php 
                                // Get product tags
                                $productModel = new \App\Models\Product();
                                $tags = $productModel->getTags($product['id']);
                                if (!empty($tags)): ?>
                                    <div class="mb-4">
                                        <p class="mb-2"><strong>Tags:</strong></p>
                                        <div>
                                            <?php foreach ($tags as $tag): ?>
                                                <span class="badge bg-primary me-1 mb-1"><?= $tag['name'] ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mb-4">
                                    <?php include 'components/upvote_button.php'; ?>
                                </div>
                                
                                <div class="border-top pt-4">
                                    <form action="/cart/add" method="POST">
                                        <input type="hidden" name="productname" value="<?= urlencode($product['productname']) ?>">
                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                        <input type="hidden" name="origin" value="<?= $product['category_slug'] ?>">
                                        
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity:</label>
                                            <div class="input-group" style="max-width: 200px;">
                                                <input class="form-control" max="<?= $product['quantity'] ?>" type="number" name="quantity" id="quantity" value="1" min="1">
                                                <span class="input-group-text">Max: <?= $product['quantity'] ?></span>
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-danger btn-lg px-4 py-2" type="submit" <?= ($product['price'] == 0) ? 'disabled' : '' ?>>
                                            <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <h4>Product Not Available</h4>
                            <p>The product you're looking for is not available at the moment.</p>
                            <a href="/products" class="btn btn-primary">Browse Other Products</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function upvote() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == 1){
                document.getElementById('upvotes').innerHTML = parseInt(document.getElementById('upvotes').innerHTML) + 1;            
                alert('Thank you for upvoting!');
            }else{
                alert('You have already upvoted this product.');
            }

        }else{
            console.log('Debug Purpose', this.responseText)
        }
    };
    xhttp.open("GET", "/upvote/<?= $product['category_slug'] ?? '' ?>/<?= isset($product) ? urlencode($product['productname']) : '' ?>/<?= $product['id'] ?? '' ?>", true);
    xhttp.send();
}
</script>