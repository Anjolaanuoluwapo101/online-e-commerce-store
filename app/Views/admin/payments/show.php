<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa fa-credit-card"></i> Payment Details</h2>
            <a href="/admin/payments" class="btn-admin">
                <i class="fa fa-arrow-left me-1"></i> Back to Payments
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-info-circle me-2"></i> Payment Information</h5>
                    </div>
                    <div class="card-admin-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment ID:</strong> #<?= $payment['id'] ?></p>
                                <p><strong>Reference:</strong> <?= $payment['reference'] ?></p>
                                <p><strong>Amount:</strong> ₦<?= number_format($payment['amount'], 2) ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-<?= $payment['status'] === 'success' ? 'success' : ($payment['status'] === 'failed' ? 'danger' : 'secondary') ?>">
                                        <?= ucfirst($payment['status']) ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Channel:</strong> <?= $payment['channel'] ?? 'N/A' ?></p>
                                <p><strong>Created At:</strong> <?= date('M j, Y H:i', strtotime($payment['created_at'])) ?></p>
                                <p><strong>Paid At:</strong> <?= $payment['paid_at'] ? date('M j, Y H:i', strtotime($payment['paid_at'])) : 'N/A' ?></p>
                            </div>
                        </div>
                        
                        <?php if ($payment['gateway_response']): ?>
                            <hr>
                            <h6><strong>Gateway Response:</strong></h6>
                            <pre class="bg-light p-3 rounded"><?= htmlspecialchars($payment['gateway_response']) ?></pre>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-shopping-cart me-2"></i> Order Information</h5>
                    </div>
                    <div class="card-admin-body">
                        <?php if ($order): ?>
                            <p><strong>Order ID:</strong> #<?= $order['id'] ?></p>
                            <p><strong>Customer:</strong> <?= htmlspecialchars($order['email']) ?></p>
                            <p><strong>Total Amount:</strong> ₦<?= number_format($order['total_amount'], 2) ?></p>
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
                            <a href="/admin/orders/<?= $order['id'] ?>" class="btn-admin w-100 mt-3">
                                <i class="fa fa-eye me-1"></i> View Order
                            </a>
                        <?php else: ?>
                            <p class="text-muted">Order information not available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-admin">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-edit me-2"></i> Update Payment Status</h5>
                    </div>
                    <div class="card-admin-body">
                        <form action="/admin/payments/<?= $payment['id'] ?>/update-status" method="POST">
                            <div class="mb-3">
                                <label for="status" class="form-label">Payment Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" <?= $payment['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="success" <?= $payment['status'] === 'success' ? 'selected' : '' ?>>Success</option>
                                    <option value="failed" <?= $payment['status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-admin w-100">
                                <i class="fa fa-save me-1"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>