<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/products">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white py-4">
                    <h1 class="mb-0 text-center">Search Results<?php if (isset($search) && $search !== 'all'): ?> for "<?= htmlspecialchars($search) ?>"<?php endif; ?></h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Sidebar Filters Dropdown -->
        <div class="col-lg-3">
            <?php include 'components/filter_dropdown.php'; ?>
        </div>
        
        <!-- Products Display -->
        <div class="col-lg-9">
            <?php if (empty($products)): ?>
                <div class="alert alert-info text-center">
                    <h4>No products found</h4>
                    <p><?php if (isset($search) && $search !== 'all'): ?>Your search for "<?= htmlspecialchars($search) ?>" did not match any products.<?php else: ?>No products available at the moment.<?php endif; ?></p>
                    <a href="/products" class="btn btn-primary">View All Products</a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <?php 
                            // Set variables needed for product card component
                            include 'components/product_card.php'; 
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php 
                // Set variables needed for pagination component
                $totalPages = $totalPages ?? 1;
                $currentPage = $currentPage ?? 1;
                include 'components/pagination.php'; 
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'components/filter_js.php'; ?>
<script>
    // Override the handlePagination function for search page
    function handlePagination(page) {
        searchItem(page, '<?= isset($search) ? urlencode($search) : 'all' ?>', <?= isset($search) && $search !== 'all' ? 1 : 0 ?>);
    }
</script>