@if($photos && count($photos) > 0)
    <div class="mb-3">
        <label class="form-label">Existing Photos</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach($photos as $photo)
                <div class="position-relative">
                    <img src="{{ asset('storage/app/public/' . $photo) }}" 
                         alt="Photo" 
                         class="img-thumbnail" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="form-check position-absolute top-0 end-0 m-1 bg-white rounded">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="remove_photos[]" 
                               value="{{ $photo }}"
                               id="remove_{{ $loop->index }}">
                        <label class="form-check-label text-danger" for="remove_{{ $loop->index }}">
                            <i class="bi bi-trash"></i>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <small class="text-muted">Check photos you want to remove</small>
    </div>
@endif