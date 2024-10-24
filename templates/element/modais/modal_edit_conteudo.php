<div class="modal fade" id="editConteudoModal" tabindex="-1" aria-labelledby="editConteudoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editConteudoModalLabel">Edit Conteudo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editConteudoForm">
          <input type="hidden" id="conteudo-id" name="id">
          <div class="mb-3">
            <label for="conteudo-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="conteudo-title" name="title">
          </div>
          <div class="mb-3">
            <label for="conteudo-description" class="form-label">Description</label>
            <textarea class="form-control" id="conteudo-description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="conteudo-author" class="form-label">Author</label>
            <input type="text" class="form-control" id="conteudo-author" name="author">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveConteudoChanges">Save changes</button>
      </div>
    </div>
  </div>
</div>