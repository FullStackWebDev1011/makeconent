<div class="modal fade" id="admin_market" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:1100px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Large Modal</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <div class="">
                                    <div class="card-header">
                                        <div class="card-title">Add your text to sell here:</div>
                                    </div>
                                    <div class="card-body">
                                <textarea id="tinymce"></textarea>
                                    </div>

                                    <div class="form-group ">
                                        <label class="font-secondary">Category</label>
                                        <p id="category"></p>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <p id="price"></p>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Enter Keywords</label>
                                        <p id="keyword"></p>
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
                        Close
                    </button>
                    <button style="display: none" type="button" id="submit" class="btn btn-primary" data-id="">Approve</button>
                </div>

        </div>
    </div>
</div>


