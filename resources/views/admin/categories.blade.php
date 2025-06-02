@extends('layouts.master')

@section('content')
<div id="layoutSidenav">
<div class="container-fluid px-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h1 class="mb-0">Categories</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Category</button>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Categories</li>
    </ol>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-table me-1"></i> Categories Table</div>
            <div>
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search...">
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover" id="categoriesTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoriesTableBody">
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-warning me-1"
                                onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')">Edit</button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteCategory({{ $category->id }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <nav>
                <ul class="pagination justify-content-center" id="pagination">
                    @if ($categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $categories->lastPage() > 1)
                        <li class="page-item {{ ($categories->currentPage() == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->url(1) }}">First</a>
                        </li>
                        <li class="page-item {{ ($categories->currentPage() == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->previousPageUrl() }}">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                            <li class="page-item {{ ($categories->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ ($categories->currentPage() == $categories->lastPage()) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->nextPageUrl() }}">Next</a>
                        </li>
                        <li class="page-item {{ ($categories->currentPage() == $categories->lastPage()) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}">Last</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this category?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('categoriesTableBody');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchTerm));
                row.style.display = match ? '' : 'none';
            });
        });
    });
</script>


<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addCategoryForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="categoryName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="categoryDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCategoryForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editCategoryId" name="id">
                <div class="mb-3">
                    <label for="editCategoryName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="editCategoryName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="editCategoryDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="editCategoryDescription" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/admin/dashboard/categories', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchCategories();
                this.reset();
                bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
            });
        });

        document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('editCategoryId').value;
            const formData = new FormData(this);

            fetch(`/admin/dashboard/categories/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchCategories();
                bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide();
            });
        });
    });

    function fetchCategories() {
        location.reload(); // Or use AJAX to dynamically update the table
    }

    function editCategory(id, name, description) {
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryDescription').value = description;
        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }

    function deleteCategory(id) {
        const confirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        const confirmButton = document.getElementById('confirmDeleteButton');

        confirmButton.onclick = function () {
            fetch(`/admin/dashboard/categories/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'DELETE'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchCategories();
                confirmationModal.hide();
            });
        };

        confirmationModal.show();
    }
</script>
@endpush
