<div class="row">
    <div class="col-md-12 d-flex justify-content-center mb-3">
        <div id="saveChecklistWrapper">
            <button class="btn btn-success" onclick="saveEmergencyChecklist()">
                <i class="fas fa-save"></i> Save
            </button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="tblEmergency" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Badge ID</th>
                <th>Name</th>
                <th class="d-none">Shift</th>
                <th>Status Kehadiran</th>
                <th>Action</th>
                <th>Remark</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->name }}</td>
                <td class="d-none">{{ $data->shift->curshift }}</td>

                @php
                $status = $data->record?->status;
                $badgeClass = match($status) {
                'Hadir' => 'badge-success',
                'Absen' => 'badge-danger',
                null, '', '-' => 'badge-warning',
                default => 'badge-secondary'
                };
                @endphp
                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ $status ?? '-' }}
                    </span>
                    <br>
                    {{ $data->record->remark ?? '' }}
                </td>

                <td>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="subscribe_{{ $data->badgeid }}"
                            data-badgeid="{{ $data->badgeid }}"
                            onchange="toggleActionEmergency('{{ $data->badgeid }}')">
                        <label class="form-check-label" for="subscribe_{{ $data->badgeid }}">
                            Absen
                        </label>
                    </div>
                    <a
                        id="editBtn_{{ $data->badgeid }}"
                        class="btn btn-warning btn-sm mt-1 d-none"
                        onclick="getDetailEmergency('{{ $data->badgeid }}')">
                        Ganti Opsi
                    </a>
                </td>
                <td id="remarkCell_{{ $data->badgeid }}">
                    <span class="text-muted" id="remarkText_{{ $data->badgeid }}">-</span>
                    <br>
                    <a class="btn btn-warning btn-sm mt-1" onclick="addremark('{{ $data->badgeid }}')">Add Remark</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>