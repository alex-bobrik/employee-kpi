<div class="modal fade" id="deleteSalaryModal" tabindex="-1" role="dialog" aria-labelledby="deleteSalaryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSalaryModalLongTitle">Delete salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('salary.delete') }}" method="post" id="deleteSalaryForm">
                @csrf
                <div class="modal-body">
                    Are you sure?
                    <div>
                        <input type="hidden" name="salary_delete_id" id="salary_delete_id" value="">
                        <input type="hidden" name="salary_employee_id" id="salary_employee_id" value="">

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
