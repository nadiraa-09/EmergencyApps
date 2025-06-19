<div class="table-responsive">
    <table id="tblReportRequest" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No. Cuti</th>
                <th>Pemohon</th>
                <th>Jenis Cuti</th>
                <th>Dari Tanggal</th>
                <th>Sampai Tanggal</th>
                <th>Total Cuti</th>
                <th>Durasi Absen</th>
                <th>Alasan</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Modify At</th>
            </tr>
        </thead>
        <tbody class="text-sm text-center">
            @foreach ($datas as $data)
            @php
            $bg = '';
            if ($data->status === 'PENDING') {
            $bg = 'bg-warning';
            } elseif ($data->status === 'REJECTED') {
            $bg = 'bg-danger';
            } elseif ($data->status === 'APPROVED') {
            $bg = 'bg-success';
            } else {
            $bg = '';
            }
            @endphp
            <tr>
                <td>
                    <!-- <a class="btn btn-secondary" onclick="handleClickDetail('<?= $data['orderid'] ?>')"> -->
                    <a class="btn btn-secondary">{{ $data->id }}</a>
                </td>
                <td>{{ $data->user->name }}</td>
                <td>{{ $data->leavetype->nameType }}</td>
                <td>{{ $data->from }}</td>
                <td>{{ $data->until }}</td>
                <td>{{ $data->totalDay }}</td>
                <td>{{ $data->durationAbsen }}</td>
                <td>{{ $data->reason }}</td>
                <td>{{ $data->remark }}</td>
                <td class="{{ $bg }}"><b>{{ $data->status }}</b></td>
                <td>{{ $data->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>