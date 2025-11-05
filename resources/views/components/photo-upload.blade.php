<div class="mb-3">
    <label for="photos" class="form-label">{{ $label ?? 'Upload Photos' }} (Multiple)</label>
    <input type="file" 
           class="form-control" 
           id="photos" 
           name="photos[]" 
           multiple 
           accept="image/*"
           onchange="previewPhotos(event)">
    <small class="text-muted">You can select multiple images (JPEG, PNG, JPG, GIF - Max 2MB each)</small>
    
    <!-- Preview container -->
    <div id="photoPreview" class="mt-3 d-flex flex-wrap gap-2"></div>
</div>

<script>
function previewPhotos(event) {
    const previewContainer = document.getElementById('photoPreview');
    previewContainer.innerHTML = '';

    const files = event.target.files;
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative';
                imgContainer.style.width = '100px';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                
                imgContainer.appendChild(img);
                previewContainer.appendChild(imgContainer);
            };
            
            reader.readAsDataURL(file);
        }
    }
}
</script>