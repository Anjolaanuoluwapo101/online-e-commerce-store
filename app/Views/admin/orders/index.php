<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><i class="fa fa-shopping-cart"></i> Orders Management</h2>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Filter Section -->
        <div class="card-admin mb-4">
            <div class="card-admin-header">
                <h5 class="mb-0"><i class="fa fa-filter me-2"></i> Filter Orders</h5>
            </div>
            <div class="card-admin-body">
                <!-- First Row - Search and Status Filters -->
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <label for="searchFilter" class="form-label">Search (Email)</label>
                        <input type="text" id="searchFilter" class="form-control" placeholder="Search by email...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="statusFilter" class="form-label">Order Status</label>
                        <select id="statusFilter" class="form-select">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="paymentStatusFilter" class="form-label">Payment Status</label>
                        <select id="paymentStatusFilter" class="form-select">
                            <option value="all">All Statuses</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row - Sorting Options and Action Buttons -->
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label for="sortFilter" class="form-label">Sort By</label>
                        <select id="sortFilter" class="form-select">
                            <option value="id">ID</option>
                            <option value="email">Email</option>
                            <option value="total_amount">Total Amount</option>
                            <option value="status">Order Status</option>
                            <option value="payment_status">Payment Status</option>
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

        <div id="ordersContainer">
            <div class="card-admin mb-4">
                <div class="card-admin-header">
                    <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Orders</h5>
                </div>
                <div class="card-admin-body">
                    <?php if (empty($orders)): ?>
                        <div class="alert alert-info">
                            <p class="mb-0"><i class="fa fa-info-circle me-2"></i> No orders found.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Email</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="hover-lift">
                                            <td><?= $order['id'] ?></td>
                                            <td><?= htmlspecialchars($order['email']) ?></td>
                                            <td>₦<?= number_format($order['total_amount'], 2) ?></td>
                                            <td>
                                                <span
                                                    class="badge bg-<?= $order['status'] === 'completed' ? 'success' : ($order['status'] === 'cancelled' ? 'danger' : ($order['status'] === 'processing' ? 'warning' : 'secondary')) ?>">
                                                    <?= ucfirst($order['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : ($order['payment_status'] === 'refunded' ? 'danger' : 'secondary') ?>">
                                                    <?= ucfirst($order['payment_status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M j, Y H:i', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <a href="/admin/orders/<?= $order['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const searchFilter = document.getElementById('searchFilter');
        const statusFilter = document.getElementById('statusFilter');
        const paymentStatusFilter = document.getElementById('paymentStatusFilter');
        const sortFilter = document.getElementById('sortFilter');
        const directionFilter = document.getElementById('directionFilter');
        const applyFilter = document.getElementById('applyFilter');
        const resetFilter = document.getElementById('resetFilter');
        const ordersContainer = document.getElementById('ordersContainer');

        // Apply filter
        applyFilter.addEventListener('click', function () {
            const searchTerm = searchFilter.value.trim();
            const status = statusFilter.value;
            const paymentStatus = paymentStatusFilter.value;
            const sortBy = sortFilter.value;
            const direction = directionFilter.value;

            // Show loading indicator
            ordersContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // Build query parameters
            let params = '';
            if (searchTerm) {
                params += 'search=' + encodeURIComponent(searchTerm);
            }
            if (status && status !== 'all') {
                params += (params ? '&' : '') + 'status=' + status;
            }
            if (paymentStatus && paymentStatus !== 'all') {
                params += (params ? '&' : '') + 'payment_status=' + paymentStatus;
            }
            if (sortBy) {
                params += (params ? '&' : '') + 'order_by=' + sortBy;
            }
            if (direction) {
                params += (params ? '&' : '') + 'direction=' + direction;
            }

            // Make AJAX request
            fetch('/admin/orders/filter' + (params ? '?' + params : ''))
                .then(response => response.json())
                .then(data => {
                    renderOrders(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    ordersContainer.innerHTML = '<div class="alert alert-danger">Error loading orders. Please try again.</div>';
                });
        });

        // Reset filter
        resetFilter.addEventListener('click', function () {
            searchFilter.value = '';
            statusFilter.value = 'all';
            paymentStatusFilter.value = 'all';
            sortFilter.value = 'id';
            directionFilter.value = 'DESC';

            // Reload all orders
            applyFilter.click();
        });

        // Render orders in table
        function renderOrders(orders) {
            if (orders.length === 0) {
                ordersContainer.innerHTML = `
                <div class="card-admin mb-4">
                    <div class="card-admin-header">
                        <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Orders</h5>
                    </div>
                    <div class="card-admin-body">
                        <div class="alert alert-info">No orders found.</div>
                    </div>
                </div>
            `;
                return;
            }

            let html = `
            <div class="card-admin mb-4">
                <div class="card-admin-header">
                    <h5 class="mb-0"><i class="fa fa-list me-2"></i> All Orders</h5>
                </div>
                <div class="card-admin-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Email</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

            orders.forEach(order => {
                const statusBadgeClass = order.status === 'completed' ? 'success' :
                    order.status === 'cancelled' ? 'danger' :
                        order.status === 'processing' ? 'warning' : 'secondary';

                const paymentStatusBadgeClass = order.payment_status === 'paid' ? 'success' :
                    order.payment_status === 'refunded' ? 'danger' : 'secondary';

                html += `
                <tr class="hover-lift">
                    <td>${order.id}</td>
                    <td>${order.email}</td>
                    <td>₦${parseFloat(order.total_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td>
                        <span class="badge bg-${statusBadgeClass}">
                            ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-${paymentStatusBadgeClass}">
                            ${order.payment_status.charAt(0).toUpperCase() + order.payment_status.slice(1)}
                        </span>
                    </td>
                    <td>${new Date(order.created_at).toLocaleString()}</td>
                    <td>
                        <a href="/admin/orders/${order.id}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
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

            ordersContainer.innerHTML = html;
        }
    });
</script>