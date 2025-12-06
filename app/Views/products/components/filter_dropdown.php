<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 d-flex justify-content-between align-items-center">
            <span><i class="fa fa-filter me-2"></i> Filters</span>
            <button class="btn btn-sm btn-outline-secondary" type="button" id="resetFilters">
                <i class="fa fa-refresh"></i> Reset
            </button>
        </h5>
    </div>
    <div class="card-body">
        <!-- Search Filter -->
        <div class="mb-4">
            <label class="form-label fw-bold">Search Products</label>
            <div class="input-group" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <input type="text" class="form-control border-0" placeholder="Search by name..." id="searchInput" 
                       value="<?= isset($search) && $search !== 'all' ? htmlspecialchars($search) : '' ?>">
                <button class="btn btn-outline-danger border-0" type="button" onclick="searchItem(1,null,1)">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Category Filter -->
        <div>
            <label class="form-label fw-bold">Categories</label>
            <div class="list-group">
                <a href="#" 
                   class="list-group-item list-group-item-action <?= !isset($category) ? 'active' : '' ?>" 
                   onclick="searchItem(1,'all')">
                    <i class="fa fa-th me-2"></i> All Products
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="#" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= (isset($category) && isset($category['id']) && $category['id'] == $cat['id']) ? 'active' : '' ?>"
                       onclick="changePage(1,'<?= $cat['slug'] ?>')">
                        <span><i class="fa fa-tag me-2"></i> <?= $cat['name'] ?></span>
                        <!-- You can add product counts here if available -->
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>