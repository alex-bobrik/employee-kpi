<div class="modal fade" id="deleteManagerModal" tabindex="-1" role="dialog" aria-labelledby="deleteManagerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteManagerModalLongTitle">Delete Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('delete-manager') }}" method="post" id="deleteManagerForm">
                @csrf
                <div class="modal-body">
                    Are you sure?
                    <div>
                        <input type="hidden" name="manager_delete_id" id="manager_delete_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Delete manager
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
