<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalTitle">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div>
                        <p class="info-text" id="infoModal-text"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="$('#infoModal').modal('hide'); $('#infoModal-text').text('')">
                        Ok
                    </button>
                </div>
        </div>
    </div>
</div>
