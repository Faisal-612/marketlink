@extends('layouts.farmer')

@section('title', 'Add Produce Item')
@section('page-title', 'Add Fresh Produce Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Produce Details</h5>

            <form action="{{ route('farmer.products.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Produce Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Organic Red Tomatoes" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (PKR) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="180" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Measurement Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-select" required>
                            <option value="kg">Per Kilogram (kg)</option>
                            <option value="gram">Per 500 Grams</option>
                            <option value="dozen">Per Dozen</option>
                            <option value="bunch">Per Bunch</option>
                            <option value="piece">Per Piece / Head</option>
                            <option value="box">Per Box / Basket</option>
                            <option value="jar">Per Jar</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Initial Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', 20) }}" min="0" required>
                        @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Image URL</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image') }}" placeholder="https://images.unsplash.com/...">
                        <small class="text-muted">Direct image URL (or leave blank for default image)</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description / Harvest Details</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Grown pesticide-free, freshly harvested on Friday morning...">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_weekly_template" value="1" id="templateCheck" {{ old('is_weekly_template') ? 'checked' : '' }}>
                            <label class="form-check-label" for="templateCheck">
                                <strong>Include in Weekly Stock Template</strong> (Auto-replenish this item every week)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('farmer.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Save & Publish Produce</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
