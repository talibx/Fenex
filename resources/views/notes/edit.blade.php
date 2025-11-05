@extends('layouts.fenex')

@section('title', 'Edit Note')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Edit Note</h1>

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

    <form action="{{ route('notes.update', $note) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Title</label>
            <input 
                type="text" 
                class="form-control" 
                id="title" 
                name="title" 
                value="{{ old('title', $note->title) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label fw-semibold">Details</label>
            <textarea 
                class="form-control" 
                id="details" 
                name="details" 
                rows="5" 
                required>{{ old('details', $note->details) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label fw-semibold">Tags <small class="text-muted">(optional)</small></label>
            <input 
                type="text" 
                class="form-control" 
                id="tags" 
                name="tags" 
                value="{{ old('tags', $note->tags) }}" 
                placeholder="e.g., amazon, inventory, reminders">
            <small class="form-text text-muted">Separate multiple tags with commas.</small>
        </div>

        @include('components.photo-edit', ['photos' => $note->photos])
        @include('components.photo-upload', ['label' => 'Add More Photos'])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Note
            </button>
        </div>
    </form>
</div>
@include('components.photo-modal')
@endsection
