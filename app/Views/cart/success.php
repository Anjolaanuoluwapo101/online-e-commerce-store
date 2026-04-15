<div class="container py-4 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
            
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white py-4">
                    <h1 class="mb-0 text-center">
                        <i class="fa fa-check-circle me-2"></i> Payment Successful!
                    </h1>
                </div>
                <div class="card-body py-5 text-center">
                    <div class="mb-4">
                        <i class="fa fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h2 class="mb-3">Thank You for Your Purchase!</h2>
                    
                    <p class="lead mb-4">
                        Your payment has been processed successfully. A confirmation email with your order details has been sent to your email address.
                    </p>
                    
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i> Order Summary</h5>
                        <p class="mb-0">Order #<?= $orderId ?? 'N/A' ?></p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/products" class="btn btn-outline-danger btn-lg me-2">
                            <i class="fa fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                        <a href="/" class="btn btn-outline-secondary btn-lg">
                            <i class="fa fa-home me-2"></i> Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Button Enhancement */
.btn {
    transition: all 0.3s ease;
    border-radius: 50px;
    font-weight: 600;
    letter-spacing: 0.5px;
    border: none !important; /* Remove all button borders */
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border: none !important; /* Ensure no border on hover */
}

.btn:active {
    transform: translateY(-1px);
    border: none !important; /* Ensure no border on active state */
}

/* Override Bootstrap outline buttons to remove blue borders */
.btn-outline-danger {
    border: 1px solid #f33f3f !important;
    color: #f33f3f !important;
}

.btn-outline-danger:hover {
    background-color: #f33f3f !important;
    border: 1px solid #f33f3f !important;
    box-shadow: 0 10px 20px rgba(243, 63, 63, 0.2) !important;
}

.btn-outline-secondary {
    border: 1px solid #6c757d !important;
    color: #6c757d !important;
}

.btn-outline-secondary:hover {
    background-color: #6c757d !important;
    border: 1px solid #6c757d !important;
    box-shadow: 0 10px 20px rgba(108, 117, 125, 0.2) !important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .btn-lg {
        margin-bottom: 0.5rem;
        display: block;
        width: 100%;
    }
    
    .me-2 {
        margin-right: 0.5rem !important;
    }
}
</style>