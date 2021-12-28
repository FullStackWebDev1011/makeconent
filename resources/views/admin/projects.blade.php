@extends('layouts.admin')

@section('title', 'Projects')

@section('subtitle', 'Projects')

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Projects</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body table-responsive p-1">
              <table id="projectTable" class="table table-hover text-nowrap projects">
                <thead>
                <tr>
                  <th style="width: 1%">
                    #
                  </th>
                  <th style="width: 15%">
                    User
                  </th>
                  <th style="width: 15%">
                    Copywriter
                  </th>
                  {{--<th style="width: 20%">--}}
                    {{--Project Title--}}
                  {{--</th>--}}
                  <th style="width: 10%">
                    Category
                  </th>
                  <th style="width: 10%">
                    Price Full (PLN)
                  </th>
                  <th style="width: 5%" title="Price per 1000 zzs">
                    Rate (PLN)
                  </th>
                  <th style="width: 5%">
                    Start Date
                  </th>

                  <th style="width: 3%" class="text-center">
                    Status
                  </th>
                  <th style="width: 6%">
                  </th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $key=>$project)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                      <ul class="list-inline v-center">
                        <li class="list-inline-item">
                          <img alt="Avatar" class="table-avatar"
                               src="{{asset($project->user->avatar?$project->user->avatar:'assets/img/users/avatar.png')}}">
                        </li>
                        <li class="list-inline-item">
                          {{ $project->user->fullname }}<br/>
                          <small>{{ $project->user->email }}</small>
                        </li>
                      </ul>
                    </td>

                    <td>
                      @if($project->seller)
                        <ul class="list-inline v-center">
                          <li class="list-inline-item">
                            <img alt="Avatar" class="table-avatar"
                                 src="{{asset($project->seller?$project->seller->avatar?$project->seller->avatar:'assets/img/users/avatar.png':'assets/img/users/avatar.png')}}">
                          </li>
                          <li class="list-inline-item">
                            {{ $project->seller ? $project->seller->fullname : '' }}<br/>
                            <small>{{ $project->seller ? $project->seller->email : '' }}</small>
                          </li>
                        </ul>
                      @else
                        None
                      @endif
                    </td>

                    {{--<td>{{ $project->title }}</td>--}}
                    <td>{{ $project->category->title }}</td>
                    <td>{{ $project->budget }}</td>
                    {{--                                        <td>{{ $project->quality ? $project->category[$project->quality . '_min'] : $project->rate }}</td>--}}
                    <td>{{ $project->rate }}</td>
                    <td>{{ $project->created_at }}</td>
{{--                    <td>{{ substr($project->description, 0, 20) }}</td>--}}
                    <td class="tag-status">{{ $project->status }}</td>
                    <td>
                      <a class="btn btn-primary btn-sm" style="color: white" onclick="projectInfoPreviewPopup('{{ $project->id }}')">View</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>

    <div class="modal fade bd-example-modal-xl" id="detail_modal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myLargeModalLabel">Request Detail</h5>
            <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body" id="market_create_modalbody">
            <div class="container">
              <div class="form-group">
                <label class="">Text</label>
                <textarea type="text" class="form-control" id="message" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary"><span class="fa fa-send-o mr-1"></span>Send</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
@include('modals.project_info_preview')

@section('script')
  <!-- page script -->
  <script>
    var projects = @json($projects);
    console.log(projects);
    $(function () {
      $("#projectTable").DataTable();
    });

    function openDetail(project) {
      $('#detail_modal').modal('show');
    }
  </script>
@endsection
