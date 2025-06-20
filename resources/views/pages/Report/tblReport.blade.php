<div class="table-responsive">
    <table id="tblReportRequest" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Badge Id</th>
                <th>Name</th>
                <th>Shift</th>
                <th>Area</th>
                <th>Department</th>
                <th>Line</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->employee->name ?? '' }}</td>
                <td>{{ $data->employee->shift->curshift ?? '' }}</td>
                <td>{{ $data->employee->area->name ?? '' }}</td>
                <td>{{ $data->employee->department->name ?? '' }}</td>
                <td>{{ $data->employee->line->name ?? '' }}</td>
                <td>{{ $data->status }}</td>
                <td>{{ $data->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>