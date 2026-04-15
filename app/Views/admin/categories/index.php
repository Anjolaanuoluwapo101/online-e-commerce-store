<div class="row fade-in">
    <div class="col-md-12">
        <h2 class="mb-4">Categories</h2>
        
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
        
        <!-- Filter Section -->
        <div class="card-admin mb-4">
            <div class="card-admin-header">
                <h5 class="mb-0"><i class="fa fa-filter me-2"></i> Filter Categories</h5>
            </div>
            <div class="card-admin-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="searchFilter" class="form-label">Search</label>
                        <input type="text" id="searchFilter" class="form-control" placeholder="Search categories...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="sortFilter" class="form-label">Sort By</label>
                        <select id="sortFilter" class="form-select">
                            <option value="id">ID</option>
                            <option value="name">Name</option>
                            <option value="created_at">Date Created</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="directionFilter" class="form-label">Direction</label>
                        <select id="directionFilter" class="form-select">
                            <option value="ASC">Ascending</option>
                            <option value="DESC">Descending</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
            <a href="/admin/categories/create" class="btn-admin">
                <i class="fa fa-plus me-1"></i> Add New Category
            </a>
        </div>
        
        <div id="categoriesContainer">
            <?php if (empty($categories)): ?>
                <div class="alert alert-info">
                    <p>No categories found.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr class="hover-lift">
                                    <td><?= $category['id'] ?></td>
                                    <td><?= $category['name'] ?></td>
                                    <td><?= $category['slug'] ?></td>
                                    <td><?= $category['description'] ?? 'No description' ?></td>
                                    <td>
                                        <a href="/admin/categories/<?= $category['id'] ?>/edit" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="/admin/categories/<?= $category['id'] ?>/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">
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
    const searchFilter = document.getElementById('searchFilter');
    const sortFilter = document.getElementById('sortFilter');
    const directionFilter = document.getElementById('directionFilter');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');
    const categoriesContainer = document.getElementById('categoriesContainer');
    
    // Apply filter
    applyFilter.addEventListener('click', function() {
        const searchTerm = searchFilter.value.trim();
        const sortBy = sortFilter.value;
        const direction = directionFilter.value;
        
        // Show loading indicator
        categoriesContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Build query parameters
        let params = '';
        if (searchTerm) {
            params += 'search=' + encodeURIComponent(searchTerm);
        }
        if (sortBy) {
            params += (params ? '&' : '') + 'order_by=' + sortBy;
        }
        if (direction) {
            params += (params ? '&' : '') + 'direction=' + direction;
        }
        
        // Make AJAX request
        fetch('/admin/categories/filter' + (params ? '?' + params : ''))
            .then(response => response.json())
            .then(data => {
                renderCategories(data);
            })
            .catch(error => {
                console.error('Error:', error);
                categoriesContainer.innerHTML = '<div class="alert alert-danger">Error loading categories. Please try again.</div>';
            });
    });
    
    // Reset filter
    resetFilter.addEventListener('click', function() {
        searchFilter.value = '';
        sortFilter.value = 'id';
        directionFilter.value = 'ASC';
        
        // Reload all categories
        applyFilter.click();
    });
    
    // Render categories in table
    function renderCategories(categories) {
        if (categories.length === 0) {
            categoriesContainer.innerHTML = '<div class="alert alert-info">No categories found.</div>';
            return;
        }
        
        let html = `
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        categories.forEach(category => {
            html += `
                <tr class="hover-lift">
                    <td>${category.id}</td>
                    <td>${category.name}</td>
                    <td>${category.slug}</td>
                    <td>${category.description || 'No description'}</td>
                    <td>
                        <a href="/admin/categories/${category.id}/edit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="/admin/categories/${category.id}/delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">
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
        
        categoriesContainer.innerHTML = html;
    }
});
</script>