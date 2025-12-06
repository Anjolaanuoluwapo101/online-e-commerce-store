<div class="container py-4 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
                        <a href="/products" class="btn btn-primary btn-lg me-2">
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