@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Crunchy Sweets Dashboard</h1>
        <div class="d-flex">
            
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Orders Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Today's Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orderCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.orders') }}" class="text-primary small font-weight-bold">
                            View all orders <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$orderRevenue  }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-success small font-weight-bold">
                            <i class="fas fa-arrow-up"></i> 12% from yesterday
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $itemCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cookie-bite fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('items.index') }}" class="text-info small font-weight-bold">
                            Manage products <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Product Categories</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoryCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('categories.index') }}" class="text-warning small font-weight-bold">
                            View categories <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="row">
    
        <div class="col-xl-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Weekly Revenue</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-xl-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Popular Products</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="...">
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">Chocolate Cake</div>
                                <span class="font-weight-bold">24 orders</span>
                            </div>
                            <div class="text-primary font-weight-bold">$12.99</div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="...">
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">Red Velvet</div>
                                <span class="font-weight-bold">18 orders</span>
                            </div>
                            <div class="text-primary font-weight-bold">$14.99</div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="...">
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">Cupcakes</div>
                                <span class="font-weight-bold">15 orders</span>
                            </div>
                            <div class="text-primary font-weight-bold">$8.99</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-circle me-3" alt="...">
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">Cookies</div>
                                <span class="font-weight-bold">12 orders</span>
                            </div>
                            <div class="text-primary font-weight-bold">$6.99</div>
                        </div>
                    </div>
                    <a href="{{ route('items.index') }}" class="btn btn-primary btn-sm btn-block">
                        View all products
                    </a>
                </div>
            </div>
        </div>
    </div> -->

    
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
            <a href="{{ route('admin.orders') }}" class="btn btn-primary btn-sm">
                View All Orders
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="recentOrders" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1001</td>
                            <td>John Doe</td>
                            <td>3</td>
                            <td>$45.97</td>
                            <td><span class="badge bg-success">Delivered</span></td>
                            <td>May 16, 2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>#1000</td>
                            <td>Jane Smith</td>
                            <td>5</td>
                            <td>$72.95</td>
                            <td><span class="badge bg-warning">Processing</span></td>
                            <td>May 15, 2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>#999</td>
                            <td>Robert Johnson</td>
                            <td>2</td>
                            <td>$28.98</td>
                            <td><span class="badge bg-danger">Cancelled</span></td>
                            <td>May 14, 2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
    <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="order-search" class="form-control"
                        placeholder="Search by customer, user, phone, or status...">
                </div>
            </div>
            <div class="table-responsive">
                <div id="orders-table"></div>
            </div>
            <nav>
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>
        </div>

</div>


<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="order-detail-body">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker"></script>

<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [450, 520, 480, 620, 780, 950, 1100],
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Date Range Picker
    $(function() {
        $('#dateRangePicker').daterangepicker({
            opens: 'left',
            locale: {
                format: 'MMM D, YYYY'
            }
        });
    });
</script>



<script>
        let allOrders = [];
        let filteredOrders = [];
        let currentPage = 1;
        const pageSize = 7;

        document.addEventListener('DOMContentLoaded', function () {
            fetchOrders();
            document.getElementById('order-search').addEventListener('input', function () {
                filterOrders(this.value);
            });
        });

        function fetchOrders() {
            fetch('/admin/dashboard/orders/list', {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(data => {
                    allOrders = data.orders;
                    filterOrders(document.getElementById('order-search').value);
                });
        }

        function filterOrders(query) {
            query = query.toLowerCase();
            filteredOrders = allOrders.filter(order =>
                order.user_name.toLowerCase().includes(query) ||
                order.user_name.toLowerCase().includes(query) ||
                order.user_email.toLowerCase().includes(query) ||
                order.customer_phone.toLowerCase().includes(query) ||
                order.order_status.toLowerCase().includes(query)
            );
            currentPage = 1;
            renderOrdersTable();
            renderPagination();
        }

        function renderOrdersTable() {
            let start = (currentPage - 1) * pageSize;
            let end = start + pageSize;
            let pageOrders = filteredOrders.slice(start, end);
            let html = `<table class="table table-bordered table-hover align-middle"><thead class="table-light"><tr>
                            <th>ID</th><th>User</th><th>Customer</th><th>Phone</th><th>Status</th><th>Total</th><th>Created</th><th>Action</th>
                        </tr></thead><tbody>`;
            if (pageOrders.length === 0) {
                html += '<tr><td colspan="8" class="text-center">No orders found.</td></tr>';
            } else {
                pageOrders.forEach(order => {
                    html += `<tr>
                                    <td>${order.id}</td>
                                    <td>${order.user_name} <br><small>${order.user_email}</small></td>
                                    <td>${order.user_name}</td>
                                    <td>${order.customer_phone}</td>
                                    <td><span class="badge bg-info">${order.order_status}</span></td>
                                    <td>${order.total_amount}</td>
                                    <td>${order.created_at}</td>
                                    <td><button class="btn btn-sm btn-primary" onclick="showOrderDetail(${order.id})">View</button></td>
                                </tr>`;
                });
            }
            html += '</tbody></table>';
            document.getElementById('orders-table').innerHTML = html;
        }

        function renderPagination() {
            let totalPages = Math.ceil(filteredOrders.length / pageSize);
            let html = '';
            if (totalPages > 1) {
                html += `<li class="page-item${currentPage === 1 ? ' disabled' : ''}"><a class="page-link" href="#" onclick="gotoPage(${currentPage - 1});return false;">Previous</a></li>`;
                for (let i = 1; i <= totalPages; i++) {
                    html += `<li class="page-item${currentPage === i ? ' active' : ''}"><a class="page-link" href="#" onclick="gotoPage(${i});return false;">${i}</a></li>`;
                }
                html += `<li class="page-item${currentPage === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" onclick="gotoPage(${currentPage + 1});return false;">Next</a></li>`;
            }
            document.getElementById('pagination').innerHTML = html;
        }

        function gotoPage(page) {
            let totalPages = Math.ceil(filteredOrders.length / pageSize);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderOrdersTable();
            renderPagination();
        }

        function showOrderDetail(orderId) {
            fetch(`/admin/dashboard/orders/${orderId}/detail`, {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(data => {
                    let order = data.order;
                    let items = data.items;
                    let html = `<h5>Order #${order.id}</h5>
                                <p><b>Status:</b> <span class="badge bg-info">${order.order_status}</span></p>
                                <p><b>Customer:</b> ${order.user_name} | <b>Phone:</b> ${order.customer_phone}</p>
                                <p><b>Address:</b> ${order.customer_address}</p>
                                <p><b>Payment:</b> ${order.payment_type} | <b>Total:</b> ${order.total_amount}</p>
                                <hr><h6>Items</h6>
                                <table class="table table-sm"><thead><tr><th>Item</th><th>Qty</th><th>Price</th></tr></thead><tbody>`;
                    items.forEach(item => {
                        html += `<tr><td>${item.item_name}</td><td>${item.quantity}</td><td>${item.price}</td></tr>`;
                    });
                    html += '</tbody></table>';
                    html += `<hr><form onsubmit="return updateStatus(event, ${order.id})">
                                <div class="mb-3">
                                    <label for="order_status" class="form-label">Update Status</label>
                                    <select class="form-select" id="order_status" name="order_status">
                                        <option value="pending" ${order.order_status === 'pending' ? 'selected' : ''}>Pending</option>
                                        <option value="processing" ${order.order_status === 'processing' ? 'selected' : ''}>Processing</option>
                                        <option value="shipped" ${order.order_status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                        <option value="delivered" ${order.order_status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                        <option value="cancelled" ${order.order_status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Update Status</button>
                            </form>`;
                    document.getElementById('order-detail-body').innerHTML = html;
                    var modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                    modal.show();
                });
        }

        function updateStatus(event, orderId) {
            event.preventDefault();
            let status = document.getElementById('order_status').value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch(`/admin/dashboard/orders/${orderId}/status`, {
    method: 'PATCH',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({ order_status: status })
})

                .then(res => res.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);

                        // Close the modal
                        const modalEl = document.getElementById('orderDetailModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        modalInstance.hide();

                        // Refresh the orders list to reflect the updated status
                        fetchOrders();
                    } else if (data.error) {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    alert('Something went wrong while updating the status.');
                });

            return false;
        }

    </script>
@endpush