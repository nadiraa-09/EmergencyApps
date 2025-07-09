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
                            <div class="col-md-12">
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

                                <!-- Filter Line -->
                                <div class="form-group">
                                    <label for="filterLine">Pilih Line</label>
                                    <select name="filterLine" id="filterLine" onchange="filterReport()" class="form-control">
                                        <option value="All">All</option>
                                        @foreach ($lines as $line)
                                        <option value="{{ $line->id }}">{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex flex-column align-items-center justify-content-center mb-3">
                                    <div class="bg-light rounded shadow-sm px-4 py-2 text-center" style="font-size: 0.92rem; line-height: 1.3; max-width: 320px;">

                                        <span class="text-muted" style="font-size: 0.89rem;">
                                            <i class="far fa-calendar-alt me-1"></i> {{ date('d-m-Y H:i:s') }}
                                        </span>
                                        <br>

                                        <span class="fw-semibold text-primary" id="totalEmployeeText">
                                            <i class="fas fa-users me-1"></i> Total Karyawan: {{ $totalEmployee }} orang
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Contents -->
                        <div class="tab-content" id="custom-tabs-content">
                            <div class="tab-pane fade show active" id="emergency" role="tabpanel">
                                <div class="dashDataLeave">
                                    @include('pages.emergency.tbldailyattendace')
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
    // Global Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(() => {
        // $('#tbldailyattendace').DataTable();
        // $('#tblEvacuation').DataTable();

        $('#filterShift').val('All');
        $('#filterLine').val('All');

        filterReport();
    });

    window.addEventListener('load', function() {
        sessionStorage.removeItem("emergencyStatus");
        sessionStorage.removeItem("emergencyRemarksDaily");
        sessionStorage.removeItem("emergencyRemarksEvacuation");
    });

    window.emergencyRemarksDaily = {};
    window.emergencyRemarksEvacuation = {};
    let currentRemarkContext = null;

    function toggleActionEmergency(badgeId) {
        const checkbox = document.getElementById(`subscribe_${badgeId}`);
        const editButton = document.getElementById(`editBtn_${badgeId}`);

        if (!checkbox) return;

        editButton?.classList.toggle('d-none', !checkbox.checked);

        const absenStatus = JSON.parse(sessionStorage.getItem("emergencyStatus") || "{}");
        absenStatus[badgeId] = checkbox.checked;
        sessionStorage.setItem("emergencyStatus", JSON.stringify(absenStatus));
    }

    function toggleActionEvacuation(badgeId) {
        const checkbox = document.getElementById(`subscribe2_${badgeId}`);
        const editButton = document.getElementById(`editBtn2_${badgeId}`);

        if (!checkbox || !editButton) return;

        editButton.classList.toggle('d-none', !checkbox.checked);
    }

    function getDetailEmergency(badgeId) {
        const label = document.querySelector(`label[for="subscribe_${badgeId}"]`);
        if (!label) return;

        if (label.textContent === "Absen") {
            label.textContent = "Masuk setengah hari";
            label.classList.add("text-danger");
        } else {
            label.textContent = "Absen";
            label.classList.remove("text-danger");
        }
    }

    function getDetailEvacuation(badgeId) {
        const label = document.querySelector(`label[for="subscribe2_${badgeId}"]`);
        if (!label) return;

        if (label.textContent === "Absen") {
            label.textContent = "Pulang setengah hari";
            label.classList.add("text-warning");
        } else if (label.textContent === "Pulang setengah hari") {
            label.textContent = "Hadir";
            label.classList.remove("text-warning");
        } else {
            label.textContent = "Absen";
            label.classList.remove("text-warning");
        }
    }

    function addremarkdaily(badgeid) {
        currentRemarkContext = 'daily';
        $("#remarkBadgeId").val(badgeid);
        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarksDaily") || "{}");
        $("#remarkText").val(remarks[badgeid] || "");

        const modal = new bootstrap.Modal(document.getElementById("remarkModal"));
        modal.show();
        setTimeout(() => $("#remarkText").focus(), 300);
    }

    function addremarkevacuation(badgeid) {
        currentRemarkContext = 'evacuation';
        $("#remarkBadgeId").val(badgeid);
        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarksEvacuation") || "{}");
        $("#remarkText").val(remarks[badgeid] || "");

        const modal = new bootstrap.Modal(document.getElementById("remarkModal"));
        modal.show();
        setTimeout(() => $("#remarkText").focus(), 300);
    }

    function saveRemark() {
        const badgeid = $("#remarkBadgeId").val();
        const remark = $("#remarkText").val().trim();
        const storageKey = currentRemarkContext === 'evacuation' ?
            "emergencyRemarksEvacuation" :
            "emergencyRemarksDaily";

        const remarks = JSON.parse(sessionStorage.getItem(storageKey) || "{}");
        remarks[badgeid] = remark;
        sessionStorage.setItem(storageKey, JSON.stringify(remarks));

        const display = remark !== "" ? remark : "-";
        const targetId = currentRemarkContext === 'evacuation' ?
            `#remarkTextEvac_${badgeid}` :
            `#remarkTextDaily_${badgeid}`;
        $(targetId).text(display);

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

    function saveChecklistDaily() {
        const checklistMap = {};
        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarksDaily") || "{}");

        $("#tbldailyattendace tbody tr").each(function() {
            const row = $(this);
            const checkbox = row.find(".form-check-input");
            const badgeid = checkbox.data("badgeid");
            if (!badgeid) return;

            const label = row.find(`label[for="subscribe_${badgeid}"]`);
            const status = checkbox.prop("checked") ?
                (label.text().trim() === "Masuk setengah hari" ? "Masuk setengah hari" : "Absen") :
                "Hadir";

            const shift = row.find("td:nth-child(4)").text().trim();

            checklistMap[badgeid] = {
                badgeid,
                status,
                inactive: 1,
                remark: remarks[badgeid] || null,
                curshift: shift,
            };
        });

        const checklist = Object.values(checklistMap);

        $.ajax({
            url: "{{ route('save-emergency') }}",
            method: "POST",
            data: JSON.stringify({
                checklist
            }),
            contentType: "application/json",
            success: function(response) {
                sessionStorage.removeItem("emergencyRemarksDaily");
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

    function saveChecklistEvacuation() {
        const checklistMap = {};
        const remarks = JSON.parse(sessionStorage.getItem("emergencyRemarksEvacuation") || "{}");

        $("#tblEvacuation tbody tr").each(function() {
            const row = $(this);
            const checkbox = row.find(".form-check-input");
            let badgeid = checkbox.attr("id");
            if (!badgeid) return;

            badgeid = badgeid.replace("subscribe2_", "");

            const label = row.find(`label[for="subscribe2_${badgeid}"]`);
            const labelText = label.text().trim();
            const status = checkbox.prop("checked") ?
                (labelText === "Pulang setengah hari" ? "Pulang setengah hari" : "Hadir") :
                "Absen";

            const shift = row.find("td:nth-child(4)").text().trim();

            checklistMap[badgeid] = {
                badgeid,
                status,
                inactive: 1,
                remark: remarks[badgeid] || null,
                curshift: shift,
            };
        });

        const checklist = Object.values(checklistMap);

        $.ajax({
            url: "{{ route('save-evacuation') }}",
            method: "POST",
            data: JSON.stringify({
                checklist
            }),
            contentType: "application/json",
            success: function(response) {
                sessionStorage.removeItem("emergencyRemarksEvacuation");
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

    // function filterReport() {
    //     const shift = $('#filterShift').val();
    //     const line = $('#filterLine').val();

    //     toggleEmergencyColumns(shift);

    //     $.ajax({
    //         url: "{{ route('emergency-filter') }}",
    //         method: "GET",
    //         data: {
    //             shift,
    //             line
    //         },
    //         success: function(response) {
    //             if ($.fn.DataTable.isDataTable('#tbldailyattendace')) {
    //                 $('#tbldailyattendace').DataTable().destroy();
    //             }
    //             if ($.fn.DataTable.isDataTable('#tblEvacuation')) {
    //                 $('#tblEvacuation').DataTable().destroy();
    //             }

    //             $('.dashDataLeave').html(response.daily);
    //             $('.dashDataEvacuation').html(response.evacuation);

    //             setTimeout(() => {
    //                 const dataTableDaily = $('#tbldailyattendace').DataTable({
    //                     pageLength: 20,
    //                 });
    //                 const dataTableEvac = $('#tblEvacuation').DataTable({
    //                     pageLength: 20,
    //                 });
    //                 dataTableDaily.on('draw', function() {
    //                     toggleEmergencyColumns(shift);
    //                 });
    //                 dataTableEvac.on('draw', function() {
    //                     toggleEmergencyColumns(shift);
    //                 });

    //                 document.querySelectorAll("#tbldailyattendace .form-check-input").forEach(cb => {
    //                     cb.onchange = () => {
    //                         const badgeid = cb.dataset.badgeid;
    //                         toggleActionEmergency(badgeid);
    //                     };
    //                 });

    //                 const absenStatus = JSON.parse(sessionStorage.getItem("emergencyStatus") || "{}");
    //                 Object.entries(absenStatus).forEach(([badgeid, checked]) => {
    //                     const checkbox = document.getElementById(`subscribe_${badgeid}`);
    //                     const editBtn = document.getElementById(`editBtn_${badgeid}`);
    //                     if (checkbox) {
    //                         checkbox.checked = checked;
    //                         if (editBtn) {
    //                             editBtn.classList.toggle("d-none", !checked);
    //                         }
    //                     }
    //                 });

    //                 toggleEmergencyColumns(shift); // Initial call
    //             }, 50);

    //         },
    //         error: function(xhr) {
    //             console.error("Filter error", xhr);
    //             Swal.fire("Error", "Failed to load filtered data.", "error");
    //         }
    //     });
    // }

    function filterReport() {
        const shift = $('#filterShift').val();
        const line = $('#filterLine').val();

        toggleEmergencyColumns(shift);

        $.ajax({
            url: "{{ route('emergency-filter') }}",
            method: "GET",
            data: {
                shift,
                line
            },
            success: function(response) {
                if ($.fn.DataTable.isDataTable('#tbldailyattendace')) {
                    $('#tbldailyattendace').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#tblEvacuation')) {
                    $('#tblEvacuation').DataTable().destroy();
                }

                $('.dashDataLeave').html(response.daily);
                $('.dashDataEvacuation').html(response.evacuation);

                // Update total karyawan sesuai filter
                if (response.totalEmployeeFiltered !== undefined) {
                    $('#totalEmployeeText').html(
                        `<i class="fas fa-users me-1"></i> Total Karyawan: ${response.totalEmployeeFiltered} orang`
                    );
                }

                setTimeout(() => {
                    const dataTableDaily = $('#tbldailyattendace').DataTable({
                        pageLength: 20,
                    });
                    const dataTableEvac = $('#tblEvacuation').DataTable({
                        pageLength: 20,
                    });
                    dataTableDaily.on('draw', function() {
                        toggleEmergencyColumns(shift);
                    });
                    dataTableEvac.on('draw', function() {
                        toggleEmergencyColumns(shift);
                    });

                    document.querySelectorAll("#tbldailyattendace .form-check-input").forEach(cb => {
                        cb.onchange = () => {
                            const badgeid = cb.dataset.badgeid;
                            toggleActionEmergency(badgeid);
                        };
                    });

                    const absenStatus = JSON.parse(sessionStorage.getItem("emergencyStatus") || "{}");
                    Object.entries(absenStatus).forEach(([badgeid, checked]) => {
                        const checkbox = document.getElementById(`subscribe_${badgeid}`);
                        const editBtn = document.getElementById(`editBtn_${badgeid}`);
                        if (checkbox) {
                            checkbox.checked = checked;
                            if (editBtn) {
                                editBtn.classList.toggle("d-none", !checked);
                            }
                        }
                    });

                    toggleEmergencyColumns(shift); // Initial call
                }, 50);

            },
            error: function(xhr) {
                console.error("Filter error", xhr);
                Swal.fire("Error", "Failed to load filtered data.", "error");
            }
        });
    }

    function toggleEmergencyColumns(shift) {
        const isAll = shift === "All";

        $('#saveChecklistDaily').toggle(!isAll);
        $('#saveChecklistEvacuation').toggle(!isAll);

        $('.col-action, .col-remark').each(function() {
            $(this).css('display', isAll ? 'none' : '');
        });

        $('.col-shift').each(function() {
            $(this).css('display', isAll ? '' : 'none');
        });
    }
</script>

@endsection