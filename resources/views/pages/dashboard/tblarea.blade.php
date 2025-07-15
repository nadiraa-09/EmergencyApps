@php $filter = $shiftFilter ?? 'All'; @endphp

<div class="table-responsive mt-4">
    <table class="table table-bordered" id="tblArea">
        <thead>
            <tr>
                <th>Area</th>
                <th>Shift</th>
                <th>Total Employee</th>
                <th>Attendance</th>
                <th>Absent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kehadiranPerArea as $data)
            @if ($filter === 'All' || $filter === $data->curshift)

            <tr class="{{ $data->is_empty ? 'text-danger' : '' }}">
                <td>{{ $data->area_name }}</td>
                <td>{{ $data->curshift }}</td>
                <td>{{ $data->total_employee }}</td>
                <td>{{ $data->jumlah_hadir }}</td>
                <td>{{ $data->jumlah_absen }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>