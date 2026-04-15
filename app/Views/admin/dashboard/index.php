<div class="row fade-in">
    <div class="col-md-12">
        <h2 class="mb-4">Admin Dashboard</h2>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card-admin hover-lift">
                    <div class="card-admin-header">
                        <h5><i class="fa fa-cube me-2"></i> Total Products</h5>
                    </div>
                    <div class="card-admin-body">
                        <h3><?= $totalProducts ?></h3>
                        <p class="text-muted">Products in inventory</p>
                        <a href="/admin/products" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fa fa-eye me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card-admin hover-lift">
                    <div class="card-admin-header">
                        <h5><i class="fa fa-folder me-2"></i> Categories</h5>
                    </div>
                    <div class="card-admin-body">
                        <h3><?= $totalCategories ?></h3>
                        <p class="text-muted">Product categories</p>
                        <a href="/admin/categories" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fa fa-eye me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card-admin hover-lift">
                    <div class="card-admin-header">
                        <h5><i class="fa fa-flash me-2"></i> Quick Actions</h5>
                    </div>
                    <div class="card-admin-body">
                        <a href="/admin/products/create" class="btn-admin d-block text-center mb-2">
                            <i class="fa fa-plus me-1"></i> Add New Product
                        </a>
                        <a href="/admin/categories/create" class="btn-admin d-block text-center">
                            <i class="fa fa-folder me-1"></i> Add New Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="card-admin hover-lift">
                <div class="card-admin-header">
                    <h5><i class="fa fa-history me-2"></i> Recent Activity</h5>
                </div>
                <div class="card-admin-body">
                    <p>No recent activity to display.</p>
                </div>
            </div>
        </div>
    </div>
</div>