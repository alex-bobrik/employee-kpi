<div class="modal fade" id="updateEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="updateEmployeeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmployeeModalTitle">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-employee') }}" method="post" id="updateEmployeeForm">
                <div class="modal-body">
                    @csrf
                    <div>
                        <label for="employee_firstname">Firstname</label>
                        <input type="text" class="form-control" name="firstname" required id="employee_firstname">
                    </div>

                    <div>
                        <label for="employee_lastname">Lastname</label>
                        <input type="text" class="form-control" name="lastname" required id="employee_lastname">
                    </div>

                    <div>
                        <label for="employee_department">Department</label>
                        <input type="text" class="form-control" name="department" required id="employee_department">
                    </div>

                    <div>
                        <label for="employee_base_value">Base Value</label>
                        <input type="number" min="0.1" step="0.1" class="form-control" name="base_value" required id="employee_base_value">
                    </div>

                    
                    <div>
                        <input type="hidden" name="employee_id" id="employee_id" value="">
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
