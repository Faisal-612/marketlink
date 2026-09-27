@extends('layouts.farmer')

@section('title', 'Edit Produce Item')
@section('page-title', 'Edit Produce Item: ' . $product->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Update Produce Information</h5>

            <form action="{{ route('farmer.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Produce Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Measurement Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-select" required>
                            @foreach(['kg', 'gram', 'dozen', 'bunch', 'piece', 'box', 'jar'] as $u)
                                <option value="{{ $u }}" {{ old('unit', $product->unit) === $u ? 'selected' : '' }}>{{ ucfirst($u) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Available Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Image URL</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image', $product->image) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description / Harvest Details</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_weekly_template" value="1" id="templateCheck" {{ old('is_weekly_template', $product->is_weekly_template) ? 'checked' : '' }}>
                            <label class="form-check-label" for="templateCheck">
                                <strong>Include in Weekly Stock Template</strong>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('farmer.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Update Produce</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
