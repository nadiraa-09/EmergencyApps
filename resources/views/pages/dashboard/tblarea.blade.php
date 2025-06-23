<div class="table-responsive">
    <table class="table table-bordered" id="tblArea">
        <thead>
            <tr>
                <th>Area</th>
                <th>Shift</th>
                <th>Jumlah Hadir</th>
            </tr>
        </thead>
        <tbody>
            @php
            $filter = $shiftFilter ?? 'All';
            @endphp

            @foreach ($kehadiranPerArea as $data)
            @php
            $show = $filter === 'All' || $filter === $data->curshift;
            @endphp

            @if ($show)
            <tr>
                <td>{{ $data->area_name }}</td>
                <td>{{ $data->curshift }}</td>
                <td>{{ $data->jumlah_hadir }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>