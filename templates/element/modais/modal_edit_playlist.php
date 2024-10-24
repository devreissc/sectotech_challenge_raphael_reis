<div class="modal fade" id="editPlaylistModal" tabindex="-1" aria-labelledby="editPlaylistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPlaylistModalLabel">Edit Playlist</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editPlaylistForm">
          <input type="hidden" id="playlist-id" name="id">
          <div class="mb-3">
            <label for="playlist-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="playlist-title" name="title">
          </div>
          <div class="mb-3">
            <label for="playlist-description" class="form-label">Description</label>
            <textarea class="form-control" id="playlist-description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="playlist-author" class="form-label">Author</label>
            <input type="text" class="form-control" id="playlist-author" name="author">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savePlaylistChanges">Save changes</button>
      </div>
    </div>
  </div>
</div>