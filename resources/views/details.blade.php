<div class="modal fade" id="detail-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"  v-if="detail">
            <div class="modal-header">
                <h5 class="modal-title">@{{ detail.company }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="list-group list-group-flush">
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">@{{ detail.product }}</h5>
                        </div>
                        <p class="mb-1">@{{ detail.complaint_what_happened }}</p>
                    </div>
                    <div v-if="detail.company_response"
                            class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Company Response</h5>
                        </div>
                        <p class="mb-1">@{{detail.company_response}}</p>
                        <p class="mb-1">@{{detail.company_public_response}}</p>
                    </div>
                    <div v-if="detail.tags"
                         class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Tags</h5>
                        </div>
                        <p class="mb-1">@{{detail.tags}}</p>
                    </div>
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Date</h5>
                        </div>
                        <p class="mb-1">@{{detail.date_received}}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>