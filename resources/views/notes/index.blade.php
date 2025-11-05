@extends('layouts.fenex')

@section('title', 'Notes')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="mb-2 mb-md-0">My Notes ({{ $notes->total() }})</h4>
        <a href="{{ route('notes.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-plus-circle"></i> Add New Note
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Photos</th>
                            <th>Tags</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th class="text-center" style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            <tr>
                                <td class="fw-semibold">{{ $note->title }}</td>

                                <td>
                                    <span class="details-text" data-fulltext="{{ $note->details }}">
                                        {{ Str::limit($note->details, 80) }}
                                    </span>
                                    @if(strlen($note->details) > 80)
                                        <a href="javascript:void(0);" class="read-more text-primary text-decoration-none ms-1">
                                            Read More
                                        </a>
                                    @endif
                                </td>

                                                            <td>
                                @include('components.photo-display', ['photos' => $note->photos])
                            </td>


                                <td>
                                    @if($note->tags)
                                        @foreach(explode(',', $note->tags) as $tag)
                                            <span class="badge bg-info text-dark me-1">{{ trim($tag) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>{{ $note->created_at->format('M d, Y') }}</td>
                                <td>{{ $note->updated_at->diffForHumans() }}</td>

                                <td class="text-center">
                                    <a href="{{ route('notes.show', $note) }}" class="btn btn-success btn-sm me-1">
                                        <i class="bi bi-eye"></i> Show
                                    </a>

                                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this note?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No notes yet. <a href="{{ route('notes.create') }}">Add one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $notes->links('pagination::bootstrap-4') }}
    </div>
</div>

{{-- JavaScript for "Read More" toggling --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".read-more").forEach(function(link) {
        link.addEventListener("click", function() {
            const span = this.previousElementSibling;
            const fullText = span.dataset.fulltext;
            const truncated = fullText.substring(0, 80) + '...';

            if (this.innerText === "Read More") {
                span.innerText = fullText;
                this.innerText = "Read Less";
            } else {
                span.innerText = truncated;
                this.innerText = "Read More";
            }
        });
    });
});
</script>
@include('components.photo-modal')
@endsection
