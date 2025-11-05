@extends('layouts.fenex')
@section('title', 'Edit Product')

@section('content')
<div class="container py-4">
    <h1>Edit Product</h1>

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

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Main Photo --}}
        <div class="mb-3">
            <label for="main_photo" class="form-label">Main Photo</label>

            @if($product->main_photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/app/public/' . $product->main_photo) }}"
                        alt="Main Photo"
                        class="img-thumbnail"
                        style="width: 180px; height: 180px; object-fit: cover;">
                </div>
            @endif

            <input type="file" class="form-control" id="main_photo" name="main_photo" accept="image/*">
            <small class="text-muted">Upload a new image to replace the current main photo.</small>
        </div>


        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="cost_of_goods" class="form-label">Cost of Goods</label>
            <input type="number" class="form-control" id="cost_of_goods" name="cost_of_goods" step="0.01" value="{{ old('cost_of_goods', $product->cost_of_goods) }}" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="{{ old('weight', $product->weight) }}" required>
        </div>

        {{-- Show existing photos with photo-edit component (lets user remove photos) --}}
        @include('components.photo-edit', ['photos' => $product->photos])

        {{-- Upload more photos if needed --}}
        @include('components.photo-upload', ['label' => 'Add More Photos'])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Product
            </button>
        </div>
    </form>
</div>

@include('components.photo-modal')
@endsection
