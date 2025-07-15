<div class="table-responsive">
    <table id="tblUser" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->role->name }}</td>
                <td>{{ $data->department->name }}</td>
                <td>

                    <a class="btn btn-warning btn-sm" onclick="getDetailUser('{{ $data->id }}')">Edit</a>
                    <a class="btn btn-warning btn-sm" onclick="changePassword('{{ $data->id }}')">Change Password</a>
                    <a class="btn btn-danger btn-sm" onclick="inActiveUser('{{ $data->id }}')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>