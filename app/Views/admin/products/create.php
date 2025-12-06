<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Add New Product</h2>
        
        <?php if (!empty($nameError)): ?>
            <div class="alert alert-danger">
                <?= $nameError ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($imageError)): ?>
            <div class="alert alert-danger">
                <?= $imageError ?>
            </div>
        <?php endif; ?>
        
        <div class="card-admin">
            <div class="card-admin-header">
                <h5><i class="fa fa-cube"></i> Product Details</h5>
            </div>
            <div class="card-admin-body">
                <form method="POST" action="/admin/products/store" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productname" class="form-label">Product Name *</label>
                                <input type="text" id="productname" name="productname" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" id="brand" name="brand" class="form-control">
                            </div>
                            
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select id="category_id" name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (₦) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" id="quantity" name="quantity" min="0" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image *</label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                                <div class="form-text">Supported formats: JPG, PNG</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn-admin">
                            <i class="fa fa-save"></i> Add Product
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