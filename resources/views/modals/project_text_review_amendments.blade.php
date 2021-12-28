<div class="modal fade" id="project_text_review_amendments_modal" tabindex="-1" role="dialog"
     aria-labelledby="project_text_view_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('project.send_amendments', ['project' => $project]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Amendments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" name="text"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-outline-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
