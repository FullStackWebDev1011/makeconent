<div class="modal fade" id="project_text_view_modal" tabindex="-1" role="dialog"
     aria-labelledby="project_text_view_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
                <h5 class="modal-title" id="exampleModalLabel">Review Text
                    <br><small>Character : {{strlen($project->text)}}</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $project->text !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <a class="btn btn-primary" href="#">Finish Project</a> -->
            </div>
        </div>
    </div>
</div>
