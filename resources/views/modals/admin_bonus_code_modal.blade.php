<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }

</style>
<div class="modal fade bd-example-modal-xl" id="bonus_code_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('/bonus-code/save') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Bonus Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
                        <!-- <div class="input-group">
                            <span class="label input-group-addon">Code</span>
                            <input type="text" class="form-control" name="code" value="" required><br>
                            <span class="label input-group-addon">Value of Code</span>
                            <input type="number" class="form-control" name="Value" value="0.00" required>
                            <input type="radio" id="male" name="onetime" value="One Time">
                            <label for="male">One Time Use</label><br>
                            <input type="radio" id="female" name="multimuse" value="Multi Use">
                            <label for="female">Multi Use</label><br>
                            <button type="button" onclick="generate()" class="input-group-append btn btn-primary">Generate</button>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="code">Code <span class="text-red">*</span></label>
                                    </div>
                                    <div class="col-md-12 row">
                                        <div class="col-md-8">
                                           <input type="text" class="form-control" id="code" name="code" placeholder="Code" value="" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" onclick="generate()" class="input-group-append btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div> <label>Type <span class="text-red">*</span></label></div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="once" id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1"> One Time Use </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" value="multiple" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2"> Multi Use </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
