<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="tax_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('countries.save') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Country ({{$country->code}})</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">

                        <input type="hidden" name="id" value="{{ $country->id ?? '' }}">
                        <div class="input-group">
                            <span class="label input-group-addon">Name</span>
                            <input type="text" class="form-control" name="name" value="{{ $country->name ?? old('title')}}" required>
                        </div>
                        <div class="input-group mt-3">
                            <span class="label input-group-addon">Currency</span>
                            <input type="text" class="form-control" name="currency" value="{{ $country->currency ?? old('title')}}" required>
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


