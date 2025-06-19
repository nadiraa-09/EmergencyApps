<div class="table-responsive">
    <table id="tblUser" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Department</th>
                <th>Jumlah Cuti</th>

            </tr>
        </thead>
        <tbody>

            @foreach($datas as $user)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->department->name }}</td>
                <td>{{ optional($user->userdetail)->leaveBalance }} Hari</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>