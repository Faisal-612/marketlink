@extends('layouts.admin')

@section('title', 'Category Master Data')
@section('page-title', 'Produce Categories Master Data')

@section('content')
<div class="row g-4">
    <!-- Add Category Form -->
    <div class="col-lg-4">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-success me-1"></i> Add Category</h5>
            
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Organic Dairy" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Icon Class (Flaticon / FontAwesome / Bootstrap)</label>
                    <input type="text" name="icon" class="form-control" placeholder="fi fi-sr-carrot" value="fi fi-sr-carrot">
                    <small class="text-muted">e.g. fi fi-sr-carrot, fi fi-sr-apple, fi fi-sr-leaf, fi fi-sr-egg</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Category summary..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary-app w-100">Create Category</button>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm overflow-hidden p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>
                                    <div class="bg-success-subtle text-success p-2 rounded text-center d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        @if(str_contains($cat->icon, 'fi-') || str_contains($cat->icon, 'fa-') || str_contains($cat->icon, 'bi-'))
                                            <i class="{{ $cat->icon }} fs-5"></i>
                                        @else
                                            <i class="fi fi-sr-{{ $cat->icon }} fs-5"></i>
                                        @endif
                                    </div>
                                </td>
                                <td><strong>{{ $cat->name }}</strong></td>
                                <td><small class="text-muted">{{ Str::limit($cat->description, 50) }}</small></td>
                                <td><span class="badge bg-light text-dark border">{{ $cat->products_count }} items</span></td>
                                <td class="text-end">
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Category">
                                            <i class="fi fi-rr-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
