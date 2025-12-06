<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Edit Product</h2>
        
        <div class="card-admin">
            <div class="card-admin-header">
                <h5><i class="fa fa-cube"></i> Product Details</h5>
            </div>
            <div class="card-admin-body">
                <form method="POST" action="/admin/products/<?= $product['id'] ?>/update">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productname" class="form-label">Product Name *</label>
                                <input type="text" id="productname" name="productname" value="<?= htmlspecialchars($product['productname']) ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" class="form-control">
                            </div>
                            
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (₦) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" value="<?= $product['price'] ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" id="quantity" name="quantity" min="0" value="<?= $product['quantity'] ?>" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <?php if (!empty($product['imagepath'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div>
                                        <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" style="width: 150px; height: 150px; object-fit: cover;" class="rounded">
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn-admin">
                            <i class="fa fa-save"></i> Update Product
                        </button>
                        <a href="/admin/products" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>