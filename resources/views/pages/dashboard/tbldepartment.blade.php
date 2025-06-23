<div class="table-responsive">
    <table class="table table-bordered" id="tblDepartment">
        <thead>
            <tr>
                <th>Department</th>
                <th>Shift</th>
                <th>Jumlah Hadir</th>
            </tr>
        </thead>
        <tbody>
            @php
            $filter = $shiftFilter ?? 'All';
            @endphp

            @foreach ($kehadiranPerDept as $data)
            @php
            $show = $filter === 'All' || $filter === $data->curshift;
            @endphp
            @if ($show)
            <tr>
                <td>{{ $data->department_name }}</td>
                <td>{{ $data->curshift }}</td>
                <td>{{ $data->jumlah_hadir }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>