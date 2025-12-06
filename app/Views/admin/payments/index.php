<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4"><i class="fa fa-credit-card"></i> Payments Management</h2>
        
        <div class="card-admin mb-4">
            <div class="card-admin-header">
                <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Payments</h5>
            </div>
            <div class="card-admin-body">
                <?php if (empty($payments)): ?>
                    <div class="alert alert-info">
                        <p class="mb-0"><i class="fa fa-info-circle me-2"></i> No payments found.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Channel</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td><?= $payment['id'] ?></td>
                                        <td>#<?= $payment['order_id'] ?></td>
                                        <td><?= htmlspecialchars($payment['order_email']) ?></td>
                                        <td><?= $payment['reference'] ?></td>
                                        <td>₦<?= number_format($payment['amount'], 2) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $payment['status'] === 'success' ? 'success' : ($payment['status'] === 'failed' ? 'danger' : 'secondary') ?>">
                                                <?= ucfirst($payment['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= $payment['channel'] ?? 'N/A' ?></td>
                                        <td><?= date('M j, Y H:i', strtotime($payment['created_at'])) ?></td>
                                        <td>
                                            <a href="/admin/payments/<?= $payment['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i> View
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
</div>