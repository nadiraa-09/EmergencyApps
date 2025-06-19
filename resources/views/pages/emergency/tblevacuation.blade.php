<div class="row">
    <div class="col-md-12 d-flex justify-content-center mb-3">
        <div id="saveChecklistWrapper">
            <button class="btn btn-success" onclick="saveAllChecklist()">
                <i class="fas fa-save"></i> Save
            </button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="tblEvacuation" class="table table-striped table-bordered" style="width:100%">
        <thead class="text-center text-sm">
            <tr>
                <th>No</th>
                <th>Badge ID</th>
                <th>Name</th>
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
                <td>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="subscribe2_{{ $data->badgeid }}"
                            onchange="toggleActionEvacuation('{{ $data->badgeid }}')">
                        <label class="form-check-label" for="subscribe2_{{ $data->badgeid }}">
                            Hadir
                        </label>
                    </div>
                    <a
                        id="editBtn2_{{ $data->badgeid }}"
                        class="btn btn-warning btn-sm mt-1 d-none"
                        onclick="getDetailEvacuation('{{ $data->badgeid }}')">
                        Ganti Opsi
                    </a>
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" onclick="addremark('{{ $data->id }}')">Add Remark</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>