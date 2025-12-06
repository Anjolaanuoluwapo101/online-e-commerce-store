<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa fa-shopping-cart"></i> Order Details</h2>
            <a href="/admin/orders" class="btn-admin">
                <i class="fa fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-info-circle me-2"></i> Order Information</h5>
                    </div>
                    <div class="card-admin-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                                <p><strong>Customer Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                                <p><strong>Total Amount:</strong> ₦<?= number_format($order['total_amount'], 2) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Order Status:</strong> 
                                    <span class="badge bg-<?= $order['status'] === 'completed' ? 'success' : ($order['status'] === 'cancelled' ? 'danger' : ($order['status'] === 'processing' ? 'warning' : 'secondary')) ?>">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </p>
                                <p><strong>Payment Status:</strong> 
                                    <span class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : ($order['payment_status'] === 'refunded' ? 'danger' : 'secondary') ?>">
                                        <?= ucfirst($order['payment_status']) ?>
                                    </span>
                                </p>
                                <p><strong>Created At:</strong> <?= date('M j, Y H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                        </div>
                        
                        <?php if ($order['cart_data']): ?>
                            <hr>
                            <h6><strong>Cart Items:</strong></h6>
                            <?php 
                            $cartData = json_decode($order['cart_data'], true);
                            if ($cartData && is_array($cartData)):
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cartData as $item): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($item['productname']) ?></td>
                                                    <td>₦<?= number_format($item['price'], 2) ?></td>
                                                    <td><?= $item['quantity'] ?></td>
                                                    <td>₦<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Cart data not available.</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-edit me-2"></i> Update Status</h5>
                    </div>
                    <div class="card-admin-body">
                        <form action="/admin/orders/<?= $order['id'] ?>/update-status" method="POST">
                            <div class="mb-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-select" id="payment_status" name="payment_status" disabled>
                                    <option value="unpaid" <?= $order['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                    <option value="paid" <?= $order['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="refunded" <?= $order['payment_status'] === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-admin w-100">
                                <i class="fa fa-save me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <?php if (!empty($payments)): ?>
                    <div class="card-admin">
                        <div class="card-admin-header">
                            <h5 class="mb-0"><i class="fa fa-credit-card me-2"></i> Payment Records</h5>
                        </div>
                        <div class="card-admin-body">
                            <?php foreach ($payments as $payment): ?>
                                <div class="mb-3 p-3 border rounded">
                                    <p class="mb-1"><strong>Reference:</strong> <?= $payment['reference'] ?></p>
                                    <p class="mb-1"><strong>Amount:</strong> ₦<?= number_format($payment['amount'], 2) ?></p>
                                    <p class="mb-1"><strong>Status:</strong> 
                                        <span class="badge bg-<?= $payment['status'] === 'success' ? 'success' : ($payment['status'] === 'failed' ? 'danger' : 'secondary') ?>">
                                            <?= ucfirst($payment['status']) ?>
                                        </span>
                                    </p>
                                    <a href="/admin/payments/<?= $payment['id'] ?>" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fa fa-eye me-1"></i> View Payment
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>