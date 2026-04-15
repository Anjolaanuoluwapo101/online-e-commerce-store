<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fa fa-credit-card"></i> Payments Management</h2>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <!-- Filter Section -->
        <div class="card-admin mb-4">
            <div class="card-admin-header">
                <h5 class="mb-0"><i class="fa fa-filter me-2"></i> Filter Payments</h5>
            </div>
            <div class="card-admin-body">
                <!-- First Row - Search and Status Filters -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="searchFilter" class="form-label">Search (Email or Reference)</label>
                        <input type="text" id="searchFilter" class="form-control" placeholder="Search by email or reference...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="statusFilter" class="form-label">Payment Status</label>
                        <select id="statusFilter" class="form-select">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
                
                <!-- Second Row - Sorting Options and Action Buttons -->
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="sortFilter" class="form-label">Sort By</label>
                        <select id="sortFilter" class="form-select">
                            <option value="id">ID</option>
                            <option value="order_email">Customer Email</option>
                            <option value="reference">Reference</option>
                            <option value="amount">Amount</option>
                            <option value="status">Status</option>
                            <option value="channel">Channel</option>
                            <option value="created_at">Date Created</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="directionFilter" class="form-label">Direction</label>
                        <select id="directionFilter" class="form-select">
                            <option value="DESC">Descending</option>
                            <option value="ASC">Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex gap-2">
                            <button id="applyFilter" class="btn-admin flex-grow-1">
                                <i class="fa fa-search me-1"></i> Apply Filters
                            </button>
                            <button id="resetFilter" class="btn btn-secondary flex-grow-1">
                                <i class="fa fa-refresh me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="paymentsContainer">
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
                            <table class="table table-hover">
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
                                        <tr class="hover-lift">
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
                                                <a href="/admin/payments/<?= $payment['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchFilter = document.getElementById('searchFilter');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const directionFilter = document.getElementById('directionFilter');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');
    const paymentsContainer = document.getElementById('paymentsContainer');
    
    // Apply filter
    applyFilter.addEventListener('click', function() {
        const searchTerm = searchFilter.value.trim();
        const status = statusFilter.value;
        const sortBy = sortFilter.value;
        const direction = directionFilter.value;
        
        // Show loading indicator
        paymentsContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Build query parameters
        let params = '';
        if (searchTerm) {
            params += 'search=' + encodeURIComponent(searchTerm);
        }
        if (status && status !== 'all') {
            params += (params ? '&' : '') + 'status=' + status;
        }
        if (sortBy) {
            params += (params ? '&' : '') + 'order_by=' + sortBy;
        }
        if (direction) {
            params += (params ? '&' : '') + 'direction=' + direction;
        }
        
        // Make AJAX request
        fetch('/admin/payments/filter' + (params ? '?' + params : ''))
            .then(response => response.json())
            .then(data => {
                renderPayments(data);
            })
            .catch(error => {
                console.error('Error:', error);
                paymentsContainer.innerHTML = '<div class="alert alert-danger">Error loading payments. Please try again.</div>';
            });
    });
    
    // Reset filter
    resetFilter.addEventListener('click', function() {
        searchFilter.value = '';
        statusFilter.value = 'all';
        sortFilter.value = 'id';
        directionFilter.value = 'DESC';
        
        // Reload all payments
        applyFilter.click();
    });
    
    // Render payments in table
    function renderPayments(payments) {
        if (payments.length === 0) {
            paymentsContainer.innerHTML = `
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Payments</h5>
                    </div>
                    <div class="card-admin-body">
                        <div class="alert alert-info">No payments found.</div>
                    </div>
                </div>
            `;
            return;
        }
        
        let html = `
            <div class="card-admin mb-4">
                <div class="card-admin-header">
                    <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Payments</h5>
                </div>
                <div class="card-admin-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
        `;
        
        payments.forEach(payment => {
            const statusBadgeClass = payment.status === 'success' ? 'success' : 
                                   payment.status === 'failed' ? 'danger' : 'secondary';
            
            html += `
                <tr class="hover-lift">
                    <td>${payment.id}</td>
                    <td>#${payment.order_id}</td>
                    <td>${payment.order_email}</td>
                    <td>${payment.reference}</td>
                    <td>₦${parseFloat(payment.amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td>
                        <span class="badge bg-${statusBadgeClass}">
                            ${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}
                        </span>
                    </td>
                    <td>${payment.channel || 'N/A'}</td>
                    <td>${new Date(payment.created_at).toLocaleString()}</td>
                    <td>
                        <a href="/admin/payments/${payment.id}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                    </td>
                </tr>
            `;
        });
        
        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
        
        paymentsContainer.innerHTML = html;
    }
});
</script>