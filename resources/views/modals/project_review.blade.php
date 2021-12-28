<div class="modal fade" tabindex="-1" role="dialog" id="project_review_modal"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:1100px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Writing Text</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="market_create_modalbody">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 m-b-10">
                            <div class="card-header">
                                <div class="col-md-6 card-title text-left p-0">Title: {{$project->title}}</div>
                            </div>
                        </div>
                        <div class="col-md-12 m-b-30">
                            <div class="">
                                <div class="card-header row">
                                    <div class="col-md-6 card-title text-left">Add your text to sell here:</div>
                                    <div class="col-md-6 text-right">
                                        Characters : <span id="status" style="color: green;"> {{strlen($project->text)}}</span>
                                    </div>
                                </div>
                                <div class="card-body p-t-0">
                                    <p>{!! $project->text !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="alertBlock" class="alert alert-danger" style="display: none">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                <a class="btn btn-primary" href="{{ route('project.review.accept', ['project' => $project]) }}">Accept</a>
            </div>

        </div>
    </div>
</div>


