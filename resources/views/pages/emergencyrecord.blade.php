@extends('layouts.header')

@section('titlepage', 'Emergency Attendance')
@section('container')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <!-- Nav Tabs -->
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" id="custom-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="emergency-tab" data-toggle="pill" href="#emergency" role="tab">
                                        Daily Attendance
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="another-tab" data-toggle="pill" href="#another" role="tab">
                                        Evacuation
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="row p-2">
                            <!-- Filter Shift -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filterShift">Pilih Shift</label>
                                    <select name="filterShift" id="filterShift" onchange="filterReport()" class="form-control">
                                        <option value="All">All</option>
                                        <option value="N">Normal</option>
                                        <option value="1">Pagi</option>
                                        <option value="2">Second</option>
                                        <option value="3">Malam</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Line -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filterLine">Pilih Line</label>
                                    <select name="filterLine" id="filterLine" onchange="filterReport()" class="form-control">
                                        <option value="All">All</option>
                                        @foreach ($lines as $line)
                                        <option value="{{ $line->id }}">{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Contents -->
                        <div class="tab-content" id="custom-tabs-content">
                            <div class="tab-pane fade show active" id="emergency" role="tabpanel">
                                <div class="dashDataLeave">
                                    @include('pages.emergency.tblemergency')
                                </div>
                            </div>
                            <div class="tab-pane fade" id="another" role="tabpanel">
                                <div class="dashDataEvacuation">
                                    @include('pages.emergency.tblevacuation')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalEditLeave" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="dashDataDetailLeave">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modelDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dashDetail">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Remark Modal -->
<div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="remarkModalLabel">Tambah Remark</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="remarkBadgeId">
        <textarea id="remarkText" class="form-control" rows="4" placeholder="Masukkan remark di sini..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="saveRemark()">Simpan</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(() => {
        $('#tblEmergency').DataTable();
        $('#tblEvacuation').DataTable();

    });

    function toggleActionEmergency(badgeId) {
        const checkbox = document.getElementById(`subscribe_${badgeId}`);
        const editButton = document.getElementById(`editBtn_${badgeId}`);

        if (checkbox.checked) {
            editButton.classList.remove('d-none');
        } else {
            editButton.classList.add('d-none');
        }
    }

    function getDetailEmergency(badgeId) {
        const label = document.querySelector(`label[for="subscribe_${badgeId}"]`);
        if (label) {
            if (label.textContent === "Absen") {
                label.textContent = "Masuk setengah hari";
                label.classList.add("text-danger");
            } else {
                label.textContent = "Absen";
                label.classList.remove("text-danger");
            }
        }
    }

    function toggleActionEvacuation(badgeId) {
        const checkbox = document.getElementById(`subscribe2_${badgeId}`);
        const editButton = document.getElementById(`editBtn2_${badgeId}`);

        if (checkbox.checked) {
            editButton.classList.remove('d-none');
        } else {
            editButton.classList.add('d-none');
        }
    }

    function getDetailEvacuation(badgeId) {
        const label = document.querySelector(`label[for="subscribe2_${badgeId}"]`);
        if (label) {
            if (label.textContent === "Absen") {
                label.textContent = "Masuk setengah hari";
                label.classList.add("text-danger");
            } else {
                label.textContent = "Absen";
                label.classList.remove("text-danger");
            }
        }
    }

    function saveEmergencyChecklist() {
        const rows = $("#tblEmergency tbody tr");
        const checklist = [];

        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarks") || "{}");

        rows.each(function() {
            const checkbox = $(this).find(".form-check-input");
            const badgeid = checkbox.data("badgeid");

            if (!badgeid) return;

            let status = "Hadir";
            if (checkbox.is(":checked")) {
                const label = $(`label[for="subscribe_${badgeid}"]`);
                const labelText = $.trim(label.text());
                if (labelText) status = labelText;
            }

            checklist.push({
                badgeid: badgeid,
                status: status,
                inactive: 1,
                remark: remarks[badgeid] || null
            });
        });

        // 🐞 Debug: Check data before sending
        console.log("Checklist to submit:", checklist);

        $.ajax({
            url: "{{ route('save-emergency') }}",
            method: "POST",
            data: JSON.stringify({ checklist }),
            contentType: "application/json",
            success: function(response) {
                sessionStorage.removeItem("emergencyRemarks");
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: response.message || "Success save data",
                    background: '#28a745',
                    color: '#fff',
                    iconColor: '#fff',
                    showConfirmButton: false,
                    timer: 2000,
                    willClose: () => location.reload()
                });
            },
            error: function(xhr) {
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'error',
                    title: xhr.responseJSON?.message || "Error save data",
                    background: '#dc3545',
                    color: '#fff',
                    iconColor: '#fff',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    }

    function filterReport() {
        const shift = $('#filterShift').val();
        const line = $('#filterLine').val();

        $.ajax({
            url: "{{ route('emergency-filter') }}",
            method: "GET",
            data: { shift, line },
            success: function(response) {
                // Destroy existing DataTables to prevent reinit errors
                if ($.fn.DataTable.isDataTable('#tblEmergency')) {
                    $('#tblEmergency').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#tblEvacuation')) {
                    $('#tblEvacuation').DataTable().destroy();
                }

                // Replace both content blocks
                $('.dashDataLeave').html(response);
                $('.dashDataEvacuation').html(response);

                // Delay slightly to allow DOM update
                setTimeout(() => {
                    $('#tblEmergency').DataTable();
                    $('#tblEvacuation').DataTable();
                }, 10);
            },
            error: function(xhr) {
                console.error("Filter error", xhr);
                Swal.fire("Error", "Failed to load filtered data.", "error");
            }
        });
    }



    window.emergencyRemarks = {};

    function addremark(badgeid) {
        $("#remarkBadgeId").val(badgeid);

        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarks") || "{}");
        $("#remarkText").val(remarks[badgeid] || "");

        const modal = new bootstrap.Modal(document.getElementById("remarkModal"));
        modal.show();

        setTimeout(() => $("#remarkText").focus(), 300);
    }

    function saveRemark() {
        const badgeid = $("#remarkBadgeId").val();
        const remark = $("#remarkText").val().trim();

        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarks") || "{}");

        remarks[badgeid] = remark;

        sessionStorage.setItem("emergencyRemarks", JSON.stringify(remarks));

        const display = remark !== "" ? remark : "-";
        $(`#remarkText_${badgeid}`).text(display);

        setTimeout(() => {
            const modalEl = document.getElementById("remarkModal");
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
            }
        }, 100);

        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: 'Remark disimpan',
            background: '#28a745',
            color: '#fff',
            iconColor: '#fff',
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>

@endsection