<div class="modal fade" id="detail-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action flex-column align-items-start"
                       v-for="(item, index) in detail"
                    >
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">@{{ index }}</h5>
                        </div>
                        <p class="mb-1">@{{ item }}</p>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>