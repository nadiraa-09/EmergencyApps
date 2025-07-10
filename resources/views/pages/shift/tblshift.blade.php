<div class="table-responsive">
    <table id="tblUser" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Badge ID</th>
                <th>Name</th>
                <th>Shift Type</th>
                <th>Shift</th>
                <th>Department</th>
                <th>Line</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->employee->name ?? '-' }}</td>
                <td>{{ $data->shift ?? '-' }}</td>
                <td>{{ $data->curshift ?? '-' }}</td>
                <td>{{ $data->employee->department?->name ?? '-' }}</td>
                <td>{{ $data->employee->line?->name ?? '-' }}</td>
                <!-- <td>
                    <a class="btn btn-warning btn-sm" onclick="getDetailEmployee('{{ $data->badgeid }}')">Edit</a>
                </td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>