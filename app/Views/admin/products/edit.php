<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Edit Product</h2>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errorMessage']) && $_SESSION['errorMessage']): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($_SESSION['errorMessage']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['errorMessage']); ?>
        <?php endif; ?>
        
        <?php if (isset($product) && $product): ?>
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
                                
                                <!-- Tags Section -->
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" id="tags" name="tags" class="form-control" placeholder="Enter tags separated by commas" value="<?php 
                                        $tagNames = [];
                                        foreach ($tags as $tag) {
                                            $tagNames[] = $tag['name'];
                                        }
                                        echo implode(', ', $tagNames);
                                    ?>">
                                    <div class="form-text">Separate multiple tags with commas (e.g., electronics, smartphone, android)</div>
                                    
                                    <?php if (!empty($tags)): ?>
                                    <div class="mt-3">
                                        <label class="form-label">Existing Tags (click to select/deselect):</label>
                                        <div id="tag-list" class="d-flex flex-wrap gap-2">
                                            <?php foreach ($tags as $tag): ?>
                                                <?php 
                                                    // Check if this tag is already assigned to the product
                                                    $isSelected = false;
                                                    if (!empty($productTags)) {
                                                        foreach ($productTags as $productTag) {
                                                            if ($productTag['id'] == $tag['id']) {
                                                                $isSelected = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                ?>
                                                <span class="badge <?= $isSelected ? 'bg-primary' : 'bg-secondary' ?> tag-item" 
                                                      style="cursor: pointer;" 
                                                      data-tag="<?= htmlspecialchars($tag['name']) ?>">
                                                    <?= htmlspecialchars($tag['name']) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const tagInput = document.getElementById('tags');
                                    const tagItems = document.querySelectorAll('.tag-item');
                                    
                                    // Handle tag selection/deselection
                                    tagItems.forEach(item => {
                                        item.addEventListener('click', function() {
                                            const tagName = this.getAttribute('data-tag');
                                            const currentTags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
                                            
                                            // Check if tag is already selected
                                            const tagIndex = currentTags.indexOf(tagName);
                                            
                                            if (tagIndex === -1) {
                                                // Add tag
                                                currentTags.push(tagName);
                                                this.classList.remove('bg-secondary');
                                                this.classList.add('bg-primary');
                                            } else {
                                                // Remove tag
                                                currentTags.splice(tagIndex, 1);
                                                this.classList.remove('bg-primary');
                                                this.classList.add('bg-secondary');
                                            }
                                            
                                            // Update input field
                                            tagInput.value = currentTags.join(', ');
                                        });
                                    });
                                    
                                    // Handle manual input changes to sync with tag items
                                    tagInput.addEventListener('input', function() {
                                        const currentTags = this.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
                                        
                                        tagItems.forEach(item => {
                                            const tagName = item.getAttribute('data-tag');
                                            if (currentTags.includes(tagName)) {
                                                item.classList.remove('bg-secondary');
                                                item.classList.add('bg-primary');
                                            } else {
                                                item.classList.remove('bg-primary');
                                                item.classList.add('bg-secondary');
                                            }
                                        });
                                    });
                                });
                                </script>
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
        <?php else: ?>
            <div class="alert alert-info">
                <p>Product not found or an error occurred while loading the product.</p>
                <a href="/admin/products" class="btn btn-primary">Back to Products</a>
            </div>
        <?php endif; ?>
    </div>
</div>