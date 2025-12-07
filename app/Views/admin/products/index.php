<div class="row fade-in">
    <div class="col-md-12">
        <h2 class="mb-4">Products</h2>
        
        <!-- Filter Section -->
        <div class="card-admin mb-4">
            <div class="card-admin-header">
                <h5 class="mb-0"><i class="fa fa-filter me-2"></i> Filter Products</h5>
            </div>
            <div class="card-admin-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="categoryFilter" class="form-label">Category</label>
                        <select id="categoryFilter" class="form-select">
                            <option value="all">All Categories</option>
                            <?php 
                            $categoryModel = new \App\Models\Category();
                            $categories = $categoryModel->getAll();
                            foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="searchFilter" class="form-label">Search</label>
                        <input type="text" id="searchFilter" class="form-control" placeholder="Search products...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sortFilter" class="form-label">Sort By</label>
                        <select id="sortFilter" class="form-select">
                            <option value="created_at">Date Created</option>
                            <option value="productname">Name</option>
                            <option value="price">Price</option>
                            <option value="upvotes">Upvotes</option>
                            <option value="quantity">Quantity</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="directionFilter" class="form-label">Direction</label>
                        <select id="directionFilter" class="form-select">
                            <option value="DESC">Descending</option>
                            <option value="ASC">Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 float-right">
                        <button id="applyFilter" class="btn-admin me-2">
                            <i class="fa fa-search me-1"></i> Apply
                        </button>
                        <button id="resetFilter" class="btn btn-secondary">
                            <i class="fa fa-refresh me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-4">
            <a href="/admin/products/create" class="btn-admin">
                <i class="fa fa-plus me-1"></i> Add New Product
            </a>
        </div>
        
        <div id="productsContainer">
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <p>No products found.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Upvotes</th>
                                <th>Tags</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr class="hover-lift">
                                    <td><?= $product['id'] ?></td>
                                    <td>
                                        <?php if (!empty($product['imagepath'])): ?>
                                            <img src="<?= R2_PUBLIC_BUCKET_URL ?>/<?= $product['imagepath'] ?>" alt="<?= $product['productname'] ?>" style="width: 50px; height: 50px; object-fit: cover;" class="rounded hover-zoom">
                                        <?php else: ?>
                                            <div class="bg-light rounded" style="width: 50px; height: 50px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $product['productname'] ?></td>
                                    <td><?= $product['category_name'] ?></td>
                                    <td><?= $product['brand'] ?></td>
                                    <td>₦<?= number_format($product['price']) ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td><?= $product['upvotes'] ?></td>
                                    <td>
                                        <?php 
                                        // Get product tags
                                        $productModel = new \App\Models\Product();
                                        $tags = $productModel->getTags($product['id']);
                                        
                                        if (!empty($tags)): 
                                            foreach ($tags as $tag): ?>
                                                <span class="badge bg-info me-1"><?= $tag['name'] ?></span>
                                            <?php endforeach; 
                                        else: ?>
                                            <span class="text-muted">No tags</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/admin/products/<?= $product['id'] ?>/edit" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="/admin/products/<?= $product['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const searchFilter = document.getElementById('searchFilter');
    const sortFilter = document.getElementById('sortFilter');
    const directionFilter = document.getElementById('directionFilter');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');
    const productsContainer = document.getElementById('productsContainer');
    
    // Apply filter
    applyFilter.addEventListener('click', function() {
        const categoryId = categoryFilter.value;
        const searchTerm = searchFilter.value.trim();
        const sortBy = sortFilter.value;
        const direction = directionFilter.value;
        
        // Show loading indicator
        productsContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Build query parameters
        let params = '';
        if (categoryId && categoryId !== 'all') {
            params += 'category_id=' + categoryId;
        }
        if (searchTerm) {
            params += (params ? '&' : '') + 'search=' + encodeURIComponent(searchTerm);
        }
        if (sortBy) {
            params += (params ? '&' : '') + 'order_by=' + sortBy;
        }
        if (direction) {
            params += (params ? '&' : '') + 'direction=' + direction;
        }
        
        // Make AJAX request
        fetch('/admin/products/filter' + (params ? '?' + params : ''))
            .then(response => response.json())
            .then(data => {
                renderProducts(data);
            })
            .catch(error => {
                console.error('Error:', error);
                productsContainer.innerHTML = '<div class="alert alert-danger">Error loading products. Please try again.</div>';
            });
    });
    
    // Reset filter
    resetFilter.addEventListener('click', function() {
        categoryFilter.value = 'all';
        searchFilter.value = '';
        sortFilter.value = 'created_at';
        directionFilter.value = 'DESC';
        
        // Reload all products
        applyFilter.click();
    });
    
    // Render products in table
    function renderProducts(products) {
        if (products.length === 0) {
            productsContainer.innerHTML = '<div class="alert alert-info">No products found.</div>';
            return;
        }
        
        let html = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Upvotes</th>
                            <th>Tags</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        products.forEach(product => {
            const imageUrl = product.imagepath ? '<?= R2_PUBLIC_BUCKET_URL ?>/' + product.imagepath : '';
            const imageHtml = product.imagepath ? 
                `<img src="${imageUrl}" alt="${product.productname}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded hover-zoom">` :
                `<div class="bg-light rounded" style="width: 50px; height: 50px;"></div>`;
            
            // Render tags
            let tagsHtml = '';
            if (product.tags && product.tags.length > 0) {
                product.tags.forEach(tag => {
                    tagsHtml += `<span class="badge bg-info me-1">${tag.name}</span>`;
                });
            } else {
                tagsHtml = '<span class="text-muted">No tags</span>';
            }
            
            html += `
                <tr class="hover-lift">
                    <td>${product.id}</td>
                    <td>${imageHtml}</td>
                    <td>${product.productname}</td>
                    <td>${product.category_name}</td>
                    <td>${product.brand}</td>
                    <td>₦${parseFloat(product.price).toLocaleString()}</td>
                    <td>${product.quantity}</td>
                    <td>${product.upvotes}</td>
                    <td>${tagsHtml}</td>
                    <td>
                        <a href="/admin/products/${product.id}/edit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="/admin/products/${product.id}/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
        `;
        
        productsContainer.innerHTML = html;
    }
});
</script>