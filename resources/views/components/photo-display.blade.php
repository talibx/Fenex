@if($photos && count($photos) > 0)
    <div class="d-flex flex-wrap gap-2">
        @foreach($photos as $photo)
            <img src="{{ asset('storage/app/public/' . $photo) }}" 
                 alt="Photo" 
                 class="img-thumbnail" 
                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                 onclick="showPhotoModal('{{ asset('storage/app/public/' . $photo) }}')">
        @endforeach
    </div>
    <small class="text-muted d-block mt-1">{{ count($photos) }} photo(s)</small>
@else
    <span class="text-muted">No photos</span>
@endif