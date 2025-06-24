<div class="table-responsive">
    <table id="tblReportRequest" class="table table-bordered table-striped text-center">
        <thead class="text-sm">
            <tr>
                <th>Badge Id</th>
                <th>Name</th>
                <th>Shift</th>
                <th>Area</th>
                <th>Department</th>
                <th>Line</th>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <th>{{ $i }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $badgeid => $userRecords)
            @php
            $employee = $userRecords->first()->employee;
            // mapping tanggal -> status
            $statusPerDay = $userRecords->mapWithKeys(function ($record) {
            return [$record->created_at->day => $record->status];
            });
            @endphp
            <tr>
                <td>{{ $badgeid }}</td>
                <td>{{ $employee->name ?? '-' }}</td>
                <td>{{ $employee->shift->curshift ?? '-' }}</td>
                <td>{{ $employee->area->name ?? '-' }}</td>
                <td>{{ $employee->department->name ?? '-' }}</td>
                <td>{{ $employee->line->name ?? '-' }}</td>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    @php
                    $status=$statusPerDay->get($i);
                    $symbol = match($status) {
                    'Hadir' => 'H',
                    'Absen' => 'A',
                    'Masuk setengah hari' => '½',
                    default => '-',
                    };
                    @endphp
                    <td>{{ $symbol }}</td>
                    @endfor

            </tr>
            @endforeach
        </tbody>
    </table>

</div>