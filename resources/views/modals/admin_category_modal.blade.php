<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="category_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:1100px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('category.save') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Category</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">

                        <input type="hidden" name="id" value="{{ isset($category) ? $category->id:'' }}">
                        <div class="input-group">
                            <span class="label input-group-addon">Title</span>
                            <input type="text" class="form-control" name="title"
                                   value="{{ isset($category)? $category->title : old('title')}}" required>
                        </div>
                        <div class="input-group">
                            <span class="label input-group-addon">Currency</span>
                            <input type="text" class="form-control" name="currency"
                                   value="{{ isset($category)? strtoupper($category->currency) : old('currency')}}" required>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q1(min)</span>
                                    <input type="text" class="form-control" name="q1_min"
                                           value="{{ isset($category)?$category->q1_min : old('q1_min')}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q1(max)</span>
                                    <input type="text" class="form-control" name="q1_max"
                                           value="{{ isset($category)?$category->q1_max : old('q1_max')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q2(min)</span>
                                    <input type="text" class="form-control" name="q2_min"
                                           value="{{ isset($category)?$category->q2_min : old('q2_min')}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q2(max)</span>
                                    <input type="text" class="form-control" name="q2_max"
                                           value="{{ isset($category)?$category->q2_max : old('q2_max')}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q3(min)</span>
                                    <input type="text" class="form-control" name="q3_min"
                                           value="{{ isset($category)?$category->q3_min : old('q3_min')}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="label input-group-addon">Q3(max)</span>
                                    <input type="text" class="form-control" name="q3_max"
                                           value="{{ isset($category)?$category->q3_max : old('q3_max')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 m-b-30">

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
                    <button type="submit" id="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


