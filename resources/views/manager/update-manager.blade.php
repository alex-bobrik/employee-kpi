<div class="modal fade" id="updateManagerModal" tabindex="-1" role="dialog" aria-labelledby="updateManagerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateManagerModalTitle">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-manager') }}" method="post" id="updateManagerForm">
                <div class="modal-body">
                    @csrf
                    <div>
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" required id="username">
                    </div>

                    <div>
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" name="password" required id="password">
                    </div>
                    
                    <div>
                        <input type="hidden" name="manager_id" id="manager_id" value="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
