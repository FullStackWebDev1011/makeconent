<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="project_price_change" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('project.price.update', ['project' => $project]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">New Price</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
                        <h4>New Per 1k ZZS: <span id="price_per_1k_symbols">XX,xx</span> PLN</h4>
                        <h4>You must pay addly : <span id="price_extra_cost">XX,xx</span> PLN</h4>
                        {{--<input type="hidden" value="{{ $project->id }}" name="id">--}}
                        <div class="input-group">
                            <div style="display: none" id="project_total_symbols">{{ $project->min_chars }}</div>
                            <div style="display: none" id="project_min_price_per_1k_by_category">{{ $project->category->q1_min ?? '0' }}</div>
                            <input type="number" step="0.1" class="form-control" name="budget"
                                   min="{{ $project->budget }}" value="{{ old('budget') ?? $project->budget?:0 }}"
                                   required>
                            <span class="label input-group-addon">PLN Brutto</span>
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
