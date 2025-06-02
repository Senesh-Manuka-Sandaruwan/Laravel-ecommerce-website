@extends('layouts.master')

@section('content')
    <div id="layoutSidenav">
        <div class="container-fluid mt-4">
            <h2>Order Management</h2>
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
    </div>

    <!-- Modal for order details -->
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
@endsection