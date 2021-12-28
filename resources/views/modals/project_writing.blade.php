<div class="modal fade" tabindex="-1" role="dialog" id="project_writing_modal"
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
                                <div class="col-md-6 card-title text-left p-0">Title:</div>
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                        </div>
                        <div class="col-md-12 m-b-30">
                            <div class="">
                                <div class="card-header row">
                                    <div class="col-md-6 card-title text-left">Add your text to sell here:</div>
                                    <div class="col-md-6 text-right">
                                        Words : <span id="status" style="color: red;">0 / {{$project->min_chars}} required</span>
                                    </div>
                                </div>
                                <div class="card-body p-t-0">
                                    <textarea id="tinymce"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="alertBlock" class="alert alert-danger" style="display: none">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="submit" class="btn btn-primary" disabled>Save Text</button>
            </div>

        </div>
    </div>
</div>


