<div class="row">
    <div class="col-md-12 d-flex justify-content-center mb-3">
        <div id="saveChecklistDaily" class="text-center">
            <button class="btn btn-success" onclick="saveChecklistDaily()">
                <i class="fas fa-save"></i> Save Daily Attendance
            </button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="tbldailyattendace" class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Badge ID</th>
                <th>Name</th>
                <th class="col-shift">Shift</th>
                <th>Status Kehadiran</th>
                <th class="col-action">Action</th>
                <th class="col-remark">Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            @php
            $status = $data->record?->status;
            $badgeClass = match($status) {
            'Hadir' => 'badge-success',
            'Absen' => 'badge-danger',
            null, '', '-' => 'badge-warning',
            default => 'badge-secondary'
            };
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->name }}</td>
                <td class="col-shift">{{ $data->shift->curshift }}</td>
                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ $status ?? '-' }}
                    </span>
                    <div class="small text-muted">{{ $data->record->remark ?? '' }}</div>
                </td>
                <td class="col-action">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                            type="checkbox"
                            id="subscribe_{{ $data->badgeid }}"
                            data-badgeid="{{ $data->badgeid }}"
                            onchange="toggleActionEmergency('{{ $data->badgeid }}')">
                        <label class="form-check-label" for="subscribe_{{ $data->badgeid }}">
                            Absen
                        </label>
                    </div>
                    <div>
                        <a id="editBtn_{{ $data->badgeid }}"
                            class="btn btn-warning btn-sm mt-1 d-none"
                            onclick="getDetailEmergency('{{ $data->badgeid }}')">
                            Ganti Opsi
                        </a>
                    </div>
                </td>
                <td class="col-remark" id="remarkCell_{{ $data->badgeid }}">
                    <div id="remarkTextDaily_{{ $data->badgeid }}" class="small text-muted">
                        {{ $data->record->remark ?? '-' }}
                    </div>
                    <a class="btn btn-warning btn-sm mt-1" onclick="addremarkdaily('{{ $data->badgeid }}')">
                        Add Remark
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>