<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:1100px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Marketplace Create</h5>
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
                                <div class="card-header">
                                    <div class="card-title">Add your text to sell here:</div>
                                    <div class="text-right">Characters with spaces: <span id="status"></span></div>
                                </div>
                                <div class="card-body">
                                    <textarea id="tinymce"></textarea>
                                </div>

                                <div class="form-group ">
                                    <label class="font-secondary">Select Category</label>
                                    <select id="categoryId" class="form-control js-select2" style="width: 200px">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Enter your price</label>
                                    <input type="number" name="price" id="price" class="form-control" min="0"/>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Enter Keywords</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"/>
                                </div>

                                <h5>You Recive: <span id="profit">0</span> PLN</h5>
                                <small>Price per 1000 zzs is <span id="rate">0</span> PLN</small>
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
                <button type="button" id="submit" class="btn btn-primary">Public Offert</button>
            </div>

        </div>
    </div>
</div>


