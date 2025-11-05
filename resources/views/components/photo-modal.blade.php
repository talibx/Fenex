<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Photo" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
function showPhotoModal(photoUrl) {
    document.getElementById('modalImage').src = photoUrl;
    new bootstrap.Modal(document.getElementById('photoModal')).show();
}
</script>