<div class="container py-4 fade-in">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
    
    <?php if (isset($_GET['cart_error']) && $_GET['cart_error'] == 1): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>An error occurred while processing your cart request. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white py-4">
                    <h1 class="mb-0 text-center"><i class="fa fa-shopping-cart me-2"></i> Your Shopping Cart</h1>
                </div>
                <div class="card-body py-4">
                    <?php if ($itemCount == 0): ?>
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-5x text-muted mb-4"></i>
                            <h3 class="mb-4">Your cart is empty</h3>
                            <p class="lead mb-4">Looks like you haven't added any items to your cart yet.</p>
                            <a href="/products" class="btn btn-danger btn-lg px-4 py-2">
                                <i class="fa fa-shopping-bag me-2"></i> Continue Shopping
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr class="hover-lift">
                                            <td><?= $item['productname'] ?></td>
                                            <td>₦<?= number_format($item['price']) ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>₦<?= number_format($item['price'] * $item['quantity']) ?></td>
                                            <td>
                                                <a href="/cart/remove/<?= $item['refId'] ?>" class="btn btn-outline-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Remove
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th>₦<?= number_format($total) ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Checkout Form -->
                        <div class="mt-5">
                            <h3 class="mb-4">Proceed to Checkout</h3>
                            <form id="checkoutForm" action="/payment/create" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="form-text">We'll send your receipt to this email address.</div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <h5><i class="fas fa-shield-alt me-2"></i> Secure Payment</h5>
                                    <p class="mb-0">You will be redirected to our secure payment processor (Paystack) to complete your purchase. Your payment information is never stored on our servers.</p>
                                </div>
                                
                                <!-- Cart Actions - Responsive Layout -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                                    <a href="/cart/clear" class="btn btn-warning px-4 py-2 w-100 w-md-auto">
                                        <i class="fa fa-trash me-2"></i> Clear Cart
                                    </a>
                                    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                        <a href="/products" class="btn btn-primary px-4 py-2 w-100 w-sm-auto">
                                            <i class="fa fa-shopping-bag me-2"></i> Continue Shopping
                                        </a>
                                        <button type="submit" class="btn btn-success px-4 py-2 w-100 w-sm-auto" id="checkoutButton">
                                            <i class="fa fa-credit-card me-2"></i> Proceed to Checkout
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const button = document.getElementById('checkoutButton');
    const originalText = button.innerHTML;
    
    // Disable the button and show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Processing...';
    
    // Allow form submission to continue
    return true;
});
</script>