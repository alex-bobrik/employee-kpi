<div class="modal fade" id="updateKpiModal" tabindex="-1" role="dialog" aria-labelledby="updateKpiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateKpiModalTitle">Обновить</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-kpi') }}" method="post" id="updateKpiForm">
                <div class="modal-body">
                    @csrf
                    <div>
                        <label for="kpi_name">Название</label>
                        <input type="text" class="form-control" name="name" maxlength="50" required id="kpi_name">
                    </div>
                    <br>
                    <div>
                        <label for="kpi_description">Описание</label>
                        <textarea name="description" id="kpi_description" cols="10" rows="2" class="form-control"></textarea>
                    </div>
                    <br>
                    <div>
                        <label for="kpi_weight">Вес коэффициента, % (Чем выше вес, тем выше влияние на коэфф)</label>
                        <input type="number" min="0" step="1" max="100" class="form-control" name="weight_value" required id="kpi_weight">
                    </div>
                    <br>
                    <div>
                        <input type="hidden" name="kpi_id" id="kpi_id" value="">
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
