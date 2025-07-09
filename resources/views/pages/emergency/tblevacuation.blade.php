<div class="row">
    <div class="col-md-12 d-flex justify-content-center mb-3">
        <div id="saveChecklistEvacuation" class="text-center">
            <button class="btn btn-success" onclick="saveChecklistEvacuation()">
                <i class="fas fa-save"></i> Simpan Data Evakuasi
            </button>
        </div>
    </div>
</div>

<div class="table-responsive">
    @php
    $isAllShift = request('shift', 'All') === 'All';
    $showStatusKehadiran = $isAllShift || $datas->filter(fn($data) => ($data->evacuation?->status ?? '-') !== '-')->count() > 0;
    @endphp
    <table id="tblEvacuation" class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th class="d-none">No</th>
                <th>Badge ID</th>
                <th>Nama</th>
                <th class="col-shift">Shift</th>
                <th>Status Kehadiran</th>
                @if($showStatusKehadiran)
                <th>Absensi Evakuasi</th>
                @endif
                <th class="col-action">Aksi</th>
                <th class="col-remark">Keterangan</th>
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

            $exstatus = $data->evacuation?->status;
            $badgeClassEv = match($exstatus) {
            'Hadir' => 'badge-success',
            'Absen' => 'badge-danger',
            'Pulang setengah hari' => 'badge-warning',
            null, '', '-' => 'badge-warning',
            default => 'badge-secondary'
            };
            @endphp
            <tr>
                <td class="d-none">{{ $loop->iteration }}</td>
                <td>{{ $data->badgeid }}</td>
                <td>{{ $data->name }}</td>
                <td class="col-shift">{{ $data->shift->curshift }}</td>
                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ $status ?? '-' }}
                    </span>
                    <div class="small text-muted">{{ $data->record->remark ?? '' }}</div>
                </td>
                @if($showStatusKehadiran)
                <td>
                    <span class="badge {{ $badgeClassEv }}">
                        {{ $exstatus ?? '-' }}
                    </span>
                    <div class="small text-muted">{{ $data->evacuation->remark ?? '' }}</div>
                </td>
                @endif
                <td class="col-action">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"
                            id="subscribe2_{{ $data->badgeid }}"
                            onchange="toggleActionEvacuation('{{ $data->badgeid }}')">
                        <label class="form-check-label" for="subscribe2_{{ $data->badgeid }}">Hadir</label>
                    </div>
                    <div>
                        <a id="editBtn2_{{ $data->badgeid }}"
                            class="btn btn-warning btn-sm mt-1 d-none"
                            onclick="getDetailEvacuation('{{ $data->badgeid }}')">
                            Ganti Opsi
                        </a>
                    </div>
                </td>
                <td class="col-remark" id="remarkCell_{{ $data->badgeid }}">
                    <div id="remarkTextEvac_{{ $data->badgeid }}" class="small text-muted">
                        {{ $data->record->remark ?? '-' }}
                    </div>
                    <a class="btn btn-warning btn-sm mt-1"
                        onclick="addremarkevacuation('{{ $data->badgeid }}')">
                        Tambah Keterangan
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>