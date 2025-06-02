@extends('layouts.master')

@section('content')
    <div id="layoutSidenav">
        <div class="container-fluid px-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h1>Items</h1>
                <form method="GET" action="{{ route('items.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                </form>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEditModal">Add Item</button>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                @foreach ($items as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ $item->image ? $item->image : 'https://placehold.co/600x400?text=No+Image' }}"
                                class="card-img-top img-fluid" alt="{{ $item->name }}"
                                style="max-height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <p class="card-text">Price: Rs.{{ $item->price }}</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addEditModal"
                                        data-id="{{ $item->id }}">Edit</button>
                                    <form method="POST" action="{{ route('items.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            
        </div>

        <!-- Add/Edit Modal -->
        <div class="modal fade" id="addEditModal" tabindex="-1" aria-labelledby="addEditModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditModalLabel">Add/Edit Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addEditForm" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image URL</label>
                                <input type="text" class="form-control" id="image" name="image"
                                    placeholder="Enter image URL (e.g., https://example.com/image.jpg)">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addEditForm = document.getElementById('addEditForm');
        const addEditModal = document.getElementById('addEditModal');

        // Form submission handler
        if (addEditForm) {
            addEditForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = {
                    name: this.querySelector('#name').value,
                    description: this.querySelector('#description').value,
                    category_id: this.querySelector('#category_id').value,
                    price: this.querySelector('#price').value,
                    image: this.querySelector('#image').value,
                    _token: document.querySelector('meta[name="csrf-token"]').content
                };

                const method = this.dataset.id ? 'PUT' : 'POST';
                const url = this.dataset.id ? `/admin/dashboard/items/${this.dataset.id}` : '/admin/dashboard/items';

                fetch(url, {

                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData._token
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.errors) {
                        let errorMessages = [];
                        for (let field in error.errors) {
                            errorMessages.push(error.errors[field][0]);
                        }
                        alert('Validation errors:\n' + errorMessages.join('\n'));
                    } else {
                        alert('Failed to save the item. Please try again.');
                    }
                });
            });
        }

        // Edit modal handler
        if (addEditModal) {
            addEditModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const itemId = button.getAttribute('data-id');
                const form = addEditForm;

                if (itemId) {
                    fetch(`/admin/dashboard/items/${itemId}`)
                        .then(response => response.json())
                        .then(item => {
                            form.dataset.id = item.id;
                            form.querySelector('#name').value = item.name;
                            form.querySelector('#description').value = item.description;
                            form.querySelector('#price').value = item.price;
                            form.querySelector('#category_id').value = item.category_id;
                            form.querySelector('#image').value = item.image;
                        })
                        .catch(error => {
                            console.error('Error fetching item:', error);
                        });
                } else {
                    form.reset();
                    delete form.dataset.id;
                }
            });
        }

        // Delete function
        window.deleteItem = function (id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`/admin/dashboard/items/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => window.location.reload());
            }
        };
    });
</script>
@endpush