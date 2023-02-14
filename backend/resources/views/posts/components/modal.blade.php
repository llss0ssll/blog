<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit-{{ $comment->id }}">
    <i class="fa-solid fa-pen"></i>
</button>


  <!-- Modal -->
  <div class="modal fade" id="edit-{{ $comment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <form action="{{ route('comment.update',$comment->id) }}" method="POST">
            @csrf
            @method('PATCH')


            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="comment" class="form-control"
                    value="{{ old('comment',$comment->body) }}">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
  </div>
