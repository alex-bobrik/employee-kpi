<div class="modal fade" id="deleteKpiModal" tabindex="-1" role="dialog" aria-labelledby="deleteKpiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteKpiModalLongTitle">Delete KPI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('delete-kpi') }}" method="post" id="deleteKpiForm">
                @csrf
                <div class="modal-body">
                    Are you sure?
                    <div>
                        <input type="hidden" name="kpi_delete_id" id="kpi_delete_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Delete kpi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
