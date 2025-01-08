<div class="modal fade" id="updateEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="updateEmployeeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmployeeModalTitle">Обновить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-employee') }}" method="post" id="updateEmployeeForm" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div>
                        <label for="employee_image">Фото сотрудника</label>
                        <input type="file" class="form-control" name="image" id="employee_image" accept="image/*">
                    </div>
                    <br>
                    <div>
                        <label for="employee_firstname">Имя</label>
                        <input type="text" class="form-control" name="firstname" maxlength="50" required id="employee_firstname">
                    </div>
                    <br>
                    <div>
                        <label for="employee_lastname">Фамилия</label>
                        <input type="text" class="form-control" name="lastname" maxlength="50" required id="employee_lastname">
                    </div>
                    <br>
                    <div>
                        <label for="employee_department">Отдел</label>
                        <select name="department" id="employee_department" required class="form-control">
                            <option value="Первый" selected>Первый</option>
                            <option value="Второй">Второй</option>
                            <option value="Третий">Третий</option>
                        </select>
                        {{-- <input type="text" class="form-control" name="department" maxlength="50" required id="employee_department"> --}}
                    </div>
                    <br>
                    <div>
                        <label for="employee_base_value">Базовая ставка (BYN/ч)</label>
                        <input type="number" min="1" step="0.1" max="999" class="form-control" name="base_value" required id="employee_base_value">
                    </div>
                    <br>
                    
                    <div>
                        <input type="hidden" name="employee_id" id="employee_id" value="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Отмена
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
