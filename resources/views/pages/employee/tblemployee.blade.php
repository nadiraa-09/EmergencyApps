<div class="table-responsive">
    <table id="tblUser" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Badge ID</th>
                <th>Name</th>
                <th>Area</th>
                <th>Department</th>
                <th>Line</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->area?->name ?? '-' }}</td>
                <td>{{ $data->department?->name ?? '-' }}</td>
                <td>{{ $data->line?->name ?? '-' }}</td>
                <td>{{ $data->user->role?->name ?? '-' }}</td>
                <td>
                    <a class="btn btn-warning btn-sm" onclick="getDetailEmployee('{{ $data->badgeid }}')">Edit Role</a>
                    <a class="btn btn-danger btn-sm" onclick="inActiveUser('{{ $data->badgeid }}')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>