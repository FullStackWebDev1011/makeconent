<div class="modal fade" id="project_info_preview_modal" tabindex="-1" role="dialog"
     aria-labelledby="project_text_view_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Project preview (<span
                            class="project_title_container"></span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>#<span class="project_id_container"></span> <span class="project_title_container"></span></div>
                Category: <span class="project_category_title_container"></span>
                <br>
                Start date: <span class="project_start_date_container"></span>
                <br>
                End date: <span class="project_end_date_container"></span>
                <br>
                <br>
                Creator: <span class="project_user_fullname_container"></span>
                <br>
                Seller/writer: <span class="project_seller_fullname_container"></span>
                <br>
                <br>
                Rate: <span class="project_rate_container"></span>
                <br>
                Budget: <span class="project_budget_container"></span> PLN

                <hr>
                <h5>Text:</h5>
                <div class="project_text_container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        function projectInfoPreviewPopup(projectId) {
            $('#project_info_preview_modal').modal('show');

            var loadingText = 'Loading...';

            $('#project_info_preview_modal .project_id_container').text(loadingText);
            $('#project_info_preview_modal .project_title_container').text(loadingText);
            $('#project_info_preview_modal .project_text_container').text(loadingText);
            $('#project_info_preview_modal .project_start_date_container').text(loadingText);
            $('#project_info_preview_modal .project_end_date_container').text(loadingText);
            $('#project_info_preview_modal .project_user_fullname_container').text(loadingText);
            $('#project_info_preview_modal .project_seller_fullname_container').text(loadingText);
            $('#project_info_preview_modal .project_rate_container').text(loadingText);
            $('#project_info_preview_modal .project_budget_container').text(loadingText);
            $('#project_info_preview_modal .project_category_title_container').text(loadingText);

            $.ajax({
                dataType: "json",
                url: '{{ route('project.get_text') }}' + '?id=' + projectId
            }).done(function (data) {
                $('#project_info_preview_modal .project_id_container').text(data.id);
                $('#project_info_preview_modal .project_title_container').text(data.seller_title);
                $('#project_info_preview_modal .project_text_container').html(data.text);
                $('#project_info_preview_modal .project_start_date_container').html(data.created_at);
                $('#project_info_preview_modal .project_end_date_container').html(data.updated_at);
                $('#project_info_preview_modal .project_user_fullname_container').html(data.user.fullname);
                if (data.seller !== undefined) {
                    $('#project_info_preview_modal .project_seller_fullname_container').html('—');
                } else {
                    $('#project_info_preview_modal .project_seller_fullname_container').html(data.seller.fullname);
                }
                $('#project_info_preview_modal .project_rate_container').html(data.rate);
                $('#project_info_preview_modal .project_budget_container').html(data.budget);
                $('#project_info_preview_modal .project_category_title_container').html(data.category.title);
            });
        }
    </script>
@endsection
