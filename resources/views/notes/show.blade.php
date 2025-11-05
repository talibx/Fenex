@extends('layouts.fenex')

@section('title', 'Note Details')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Note Details</h1>
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to List
        </a>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <strong>Photos:</strong>
            @if($note->photos && count($note->photos) > 0)
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($note->photos as $photo)
                        <img src="{{ asset('storage/app/public/' . $photo) }}" 
                            alt="Photo" 
                            class="img-thumbnail" 
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                            onclick="showPhotoModal('{{ asset('storage/app/public/' . $photo) }}')">
                    @endforeach
                </div>
            @else
                <p class="text-muted">No photos available</p>
            @endif
        </div>
    </div>

    @include('components.photo-modal')

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h6 class="fw-bold text-muted mb-1">Title</h6>
                    <h3 class="text-primary">{{ $note->title }}</h3>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Category</h6>
                    <p class="fs-6">
                        <span class="badge bg-info text-dark">
                            {{ ucfirst($note->category ?? 'General') }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Priority</h6>
                    <p class="fs-6">
                        @if(isset($note->priority))
                            @if($note->priority == 'high')
                                <span class="badge bg-danger">High</span>
                            @elseif($note->priority == 'medium')
                                <span class="badge bg-warning text-dark">Medium</span>
                            @else
                                <span class="badge bg-success">Low</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Not Set</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <h6 class="fw-bold text-muted mb-2">Details</h6>
                <div class="border rounded p-4 bg-light" style="min-height: 200px;">
                    @if($note->details)
                        <div style="white-space: pre-wrap;">{{ $note->details }}</div>
                    @else
                        <p class="text-muted mb-0">No content available for this note.</p>
                    @endif
                </div>
            </div>

            @if(isset($note->tags) && $note->tags)
                <div class="mb-3">
                    <h6 class="fw-bold text-muted mb-2">Tags</h6>
                    <div>
                        @foreach(explode(',', $note->tags) as $tag)
                            <span class="badge bg-secondary me-1">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr>

            <div class="row text-muted small mt-3">
                <div class="col-md-4">
                    <p class="mb-0">
                        <i class="bi bi-person-circle"></i> 
                        Created by: {{ $note->user->name ?? 'Unknown' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="mb-0">Created: {{ $note->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="mb-0">Last Updated: {{ $note->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>

        <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

@endsection