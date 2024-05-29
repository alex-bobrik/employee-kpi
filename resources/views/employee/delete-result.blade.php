<div class="modal fade" id="deleteResultModal" tabindex="-1" role="dialog" aria-labelledby="deleteResultModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteResultModalLongTitle">Delete result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('delete-result') }}" method="post" id="deleteResultForm">
                @csrf
                <div class="modal-body">
                    Are you sure?
                    <div>
                        <input type="hidden" name="result_delete_id" id="result_delete_id" value="">
                        <input type="hidden" name="result_employee_id" id="result_employee_id" value="">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Delete result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
