<div class="modal fade" id="updateKpiModal" tabindex="-1" role="dialog" aria-labelledby="updateKpiModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateKpiModalTitle">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update-kpi') }}" method="post" id="updateKpiForm">
                <div class="modal-body">
                    @csrf
                    <div>
                        <label for="kpi_name">Name</label>
                        <input type="text" class="form-control" name="name" required id="kpi_name">
                    </div>

                    <div>
                        <label for="kpi_description">Description</label>
                        <input type="text" class="form-control" name="description" required id="kpi_description">
                    </div>

                    <div>
                        <label for="kpi_weight">Weight</label>
                        <input type="number" min="0" step="1" max="100" class="form-control" name="weight_value" required id="kpi_weight">
                    </div>
                    
                    <div>
                        <input type="hidden" name="kpi_id" id="kpi_id" value="">
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
