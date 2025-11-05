@extends('layouts.fenex')
@section('title', 'Add a Product')
@section('content')
<div class="container py-4">
    <h1>Add New Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Main Photo Upload --}}
        <div class="mb-3" id="MainPhotoPreview">
            <label for="main_photo" class="form-label">Main Photo</label>
            <input type="file" class="form-control" id="main_photo" name="main_photo" accept="image/*">
            <small class="text-muted">This will be the main photo for the product (displayed in listings).</small>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="cost_of_goods" class="form-label">Cost of Goods</label>
            <input type="number" class="form-control" id="cost_of_goods" name="cost_of_goods" step="0.01" value="{{ old('cost_of_goods') }}" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="{{ old('weight') }}" required>
        </div>

        {{-- Use the shared photo-upload component --}}
        @include('components.photo-upload', ['label' => 'Upload Product Photos (multiple allowed)'])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </button>
        </div>
    </form>
</div>
@include('components.photo-modal')
@endsection
