@extends('layouts.main')
@section('style')
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        var min_chars = '{{$project->min_chars}}';
        var nCharacters = 0;
        (function ($) {
            'use strict';

            tinymce.init({
                selector: '#tinymce',
                menubar: false,
                height: 600,
                // plugins: [
                //     'advlist autolink lists link image charmap print preview anchor textcolor',
                //     'searchreplace visualblocks code fullscreen',
                //     'insertdatetime media table contextmenu paste code help wordcount'
                // ],
                // toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                toolbar: 'undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'],
                init_instance_callback: function (editor) {
                    editor.on('change', function (e) {
                        nCharacters = tinymce.activeEditor.getContent({format: 'text'}).length;
                        updateStatus()
                    });
                    editor.on('keydown', function (e) {
                        if (editor.getContent({format: 'text'}) === '\n') {
                            nCharacters = 0;
                        } else {
                            nCharacters = editor.getContent({format: 'text'}).length;
                        }
                        updateStatus();
                    });
                }
            });

        })(window.jQuery);

        function updateStatus() {
            document.getElementById('status').innerHTML = (nCharacters + ' / ' + min_chars) + ' required';
            document.getElementById('status').style.color = "green";
            document.getElementById('submit').disabled = false;
            if (nCharacters < min_chars) {
                document.getElementById('submit').disabled = true;
                document.getElementById('status').style.color = "red";
            }
        }
    </script>
@endsection
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-12 text-white p-t-40 p-b-90">

                        <h4 class=""> <span class="btn btn-white-translucent">
                                <i class="mdi mdi-format-text "></i></span> Project #{{ $project->id }}
                        </h4>
                        <p class="opacity-75 ">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus culpa dolor
                            inventore reiciendis repellat temporibus ullam unde velit voluptatem. Accusamus
                            animi cupiditate eius expedita impedit nulla similique veniam voluptas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container  pull-up">
            <div class="row">
                <div class="col-md-12">
                    <!--widget card begin-->
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="m-b-0">
                                {{ $project->title }}
                            </h5>
                            <div class="text-md-right">
                                <span class=" badge badge-soft-primary"> {{ $project->status }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <h4>Description:</h4>
                                <p>{{ $project->description }}</p>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-2">
                                    <h5> Text Lenght: <br><span class="text-muted ml-3 small">{{ $project->min_chars }}
                                            ZZS</span>
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <h5> Price: <br><span class="text-muted ml-3 small">{{ roundPrice($project->budget) }}
                                            PLN</span>
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <h5> Rate: <br><span class="text-muted ml-3 small">{{ roundPrice($project->getRate()) }}
                                            PLN</span>
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="mt-0 mb-1"> Need Bold Keywords?: <br><span class="text-muted ml-3 small">
                                            {{ $project->cp_bold_keyword===1?'Yes':'No' }}
                                        </span>
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="mt-0 mb-1"> Need Text Tittle?: <br><span class="text-muted ml-3 small">
                                            {{ $project->cp_write_title===1?'Yes':'No' }}
                                        </span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @switch($project->status)
                            @case(\App\Project::STATUS_OPEN)
                            <div class="text-md-right">
                                <button type="button" class="btn m-b-15 ml-2 mr-2 btn-primary" onclick="reserve()">
                                    Reserve Project
                                </button>
                            </div>
                            @break
                            @default
                        @endswitch
                    </div>
                    @if($project->status !== \App\Project::STATUS_OPEN)
                        <h4>Your order text's</h4>
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="col-md-12 row">
                                    <div class="col-md-3">
                                        <h5 class="mt-0 mb-1"> Time to complete <br>
                                            <span class="text-muted ml-3 small js_left_time"
                                                  data-dead-line="{{ $project->getDeadLineDate() ? $project->getDeadLineDate() : '' }}">...</span>
                                            <span class="text-muted small">({{ $project->getDeadLineDate() ? userDate($project->getDeadLineDate(), true) : '' }}
                                                )</span>
                                        </h5>
                                    </div>
                                    <div class="col-md-2" style="padding: 0 2px;">
                                        <h5 class="mt-0 mb-1"> Status <br><span class="text-muted small">
                                            @switch($project->status)
                                                    @case(\App\Project::STATUS_OPEN)
                                                        Open
                                                    @break
                                                    @case(\App\Project::STATUS_PENDING)
                                                    @case(\App\Project::STATUS_ACCEPTED)
                                                    <span class="label-warning">Waiting for your text</span>
                                                    @break
                                                    @case(\App\Project::STATUS_AMENDMENT)
                                                    <span class="label-warning">Waiting fixes</span>
                                                    @break
                                                    @default
                                                    —
                                            @endswitch
                                        </span>
                                        </h5>
                                    </div>

                                    <div class="col-md-3">
                                        @if($project->status === \App\Project::STATUS_AMENDMENT)
                                            <h5 class="mt-0 mb-1"> Amendments <br><span class="text-muted ml-3 small">
                                            {{ $project->amendment_comment ?? '' }}
                                        </span>
                                            </h5>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        @switch($project->status)
                                            @case(\App\Project::STATUS_PENDING)
                                            <a class="btn btn-outline-primary" href="javascript: showWritingModal()">Start
                                                Writing</a>
                                            @break
                                            @case(\App\Project::STATUS_AMENDMENT)
                                            <a class="btn btn-outline-primary" href="javascript: showWritingModal()">Do fixes</a>
                                            @break
                                            
                                            @case(\App\Project::STATUS_WRITTEN)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#project_text_review_modal">Review Text
                                            </button>
                                            @break
                                            @default
                                        @endswitch
                                        <a class="btn btn-outline-primary" href="{{ route('chat') }}">Messange</a>
                                        <a class="btn btn-outline-primary" href="{{ route('project.jump_out', ['project' => $project]) }}">Resingne</a>
                                        
                                        @if($project->status === \App\Project::STATUS_CHECKING_PLAGIARISM)
                                            <a class="btn btn-outline-primary" href="javascript: showReviewModal()">Review</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- END PLACE PAGE CONTENT HERE -->
    </section>

    @include('modals.project_writing')
    @include('modals.project_review')
    @include('modals.project_text_review')
    @include('modals.project_text_review_amendments')
@endsection
@section('script')
    <script>
        $(function () {
            var deadLine = $('.js_left_time').attr('data-dead-line');
            console.log(deadLine);

            if (deadLine !== '') {
                var countDownDate = new Date(deadLine).getTime();

                var x = setInterval(function () {

                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"
                    $('.js_left_time').text(hours + "h "
                        + minutes + "m " + seconds + "s ");

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        $('.js_left_time').text("EXPIRED");
                    }
                }, 1000);
            }
        });
    </script>
    <script>
        var _token = '{{ csrf_token() }}';

        function reserve() {
            var projectId = '{{ $project->id }}';
            $.get('{{ route('projects.reserve') }}' + '?id=' + projectId).then(function (res) {
                location.reload();
            })
        }

        function showWritingModal() {
            $.get('{{ route('project.get_text') .'?id='.$project->id }}', function (res) {
                if (res) {
                    $('#title').val(res.seller_title);
                    tinymce.activeEditor.setContent(res.text);
                }
                if (tinymce.activeEditor.getContent({format: 'text'}) === '\n') {
                    nCharacters = 0;
                } else {
                    nCharacters = tinymce.activeEditor.getContent({format: 'text'}).length;
                }
                updateStatus();
            });
            $('#project_writing_modal').modal('show');
        }

        function showReviewModal() {
            $.get('{{ route('project.get_text') .'?id='.$project->id }}', function (res) {
                updateStatus();
            });
            $('#project_review_modal').modal('show');
        }

        $(function () {
            $('#submit').click(function () {
                var content = tinymce.activeEditor.getContent({format: 'html'});
                var title = $('#title').val();
                $.ajax({
                    url: '{{ route('project.save_text') }}',
                    method: 'post',
                    data: {
                        _token: _token,
                        title: title,
                        text: content,
                        id: '{{ $project->id }}'
                    },
                    success: function (res) {
                        console.log(res);
                        if (res.status) {
                            $.notify({
                                // options
                                title: '',
                                message: res.message
                            }, {
                                placement: {
                                    align: "right",
                                    from: "bottom"
                                },
                                timer: 500,
                                // settings
                                type: 'success',
                            });
                        } else {
                            if (res.errors) {
                                var msg = '';
                                Object.keys(res.errors).map(function (key) {
                                    msg += (key + ": " + res.errors[key][0] + "\n");
                                });
                                $.notify({
                                    // options
                                    title: 'Warning',
                                    message: msg
                                }, {
                                    placement: {
                                        align: "right",
                                        from: "bottom"
                                    },
                                    timer: 500,
                                    // settings
                                    type: 'danger',
                                });
                            }
                        }
                        $('#project_writing_modal').modal('toggle');
                    },
                    error: function (err) {

                    }
                })
            });
        });
    </script>
@endsection