<div class="modal fade" id="project_copywriter_review_modal" tabindex="-1" role="dialog"
     aria-labelledby="project_copywriter_review_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('projects.review.add', ['project' => $project]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review for {{ $project->seller?$project->seller->getFullName():'-' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="js_copywriter_rating">
                        <i onclick="setCopywriterRating(1)" class="mdi mdi-star mdi-36px star selected"></i>
                        <i onclick="setCopywriterRating(2)" class="mdi mdi-star mdi-36px star selected"></i>
                        <i onclick="setCopywriterRating(3)" class="mdi mdi-star mdi-36px star selected"></i>
                        <i onclick="setCopywriterRating(4)" class="mdi mdi-star mdi-36px star selected"></i>
                        <i onclick="setCopywriterRating(5)" class="mdi mdi-star mdi-36px star selected"></i>
                    </div>
                    <textarea class="form-control" name="comment"></textarea>
                    <input type="hidden" name="rate" value="5">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-outline-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .star {
        cursor: pointer;
    }

    .selected {
        color: #ffcc4d;
    }
</style>

<script>
    function setCopywriterRating(rating) {
        $('#project_copywriter_review_modal [name=rate]').val(rating);
        $('.js_copywriter_rating .star').removeClass('selected');

        for (i = 0; i < 5; i++) {
            if (i < rating) {
                $('.js_copywriter_rating .star').eq(i).addClass('selected');
            }
        }
    }
</script>