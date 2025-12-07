<div class="container py-4 fade-in">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
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
    
    <div class="row mb-4 slide-up">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white py-4">
                    <h1 class="mb-0 text-center">Our Products</h1>
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
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <?php include 'components/product_card.php'; ?>
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
        </div>
    </div>
</div>

<?php include 'components/filter_js.php'; ?>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.hover-zoom {
    transition: transform 0.3s ease;
}

.hover-zoom:hover {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .card-img-top {
        height: 200px !important;
    }
}
</style>