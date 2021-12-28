<div class="modal fade" id="project_text_review_modal" tabindex="-1" role="dialog"
     aria-labelledby="project_text_view_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Review Text</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $project->text !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a class="btn btn-outline-danger" href="{{ route('project.reject', ['project' => $project]) }}">Reject</a>
                @if(empty($project->amendment_comment))
                    <button class="btn btn-outline-warning" data-toggle="modal"
                            data-target="#project_text_review_amendments_modal">
                        Amendments
                    </button>
                @endif
                <a class="btn btn-primary" href="{{ route('project.accept', ['project' => $project]) }}">Accept</a>
            </div>
        </div>
    </div>
</div>
