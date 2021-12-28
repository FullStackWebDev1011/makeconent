<table id="example" class="table" style="width:100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Price Full</th>
        <th title="Price per 1000 zzs">Rate</th>
        <th>Start date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->title }}</td>
            <td>{{ $project->category->title }}</td>
            <td>{{ $project->budget }}</td>
            <td>{{ $project->rate }} <small>/100 words</small></td>
            <td>{{ $project->created_at }}</td>
            <td><a class="btn btn-primary btn-sm" href="{{ route('projects.view', ['project' => $project]) }}">View</a></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Category</th>
        <th>Price Full</th>
        <th title="Price per 1000 zzs">Rate</th>
        <th>Start date</th>
        <th>Action</th>
    </tr>
    </tfoot>
</table>

<script>
    $(function () {
        $('#example').DataTable({
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {"emptyTable": "No Projects"}
        });
    });
</script>