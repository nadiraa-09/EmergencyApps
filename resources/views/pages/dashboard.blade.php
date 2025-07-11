@extends('layouts.header')

@section('container')
<section class="content">
    <div class="container-fluid">

        <!-- Card Jumlah Karyawan per Shift -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 my-3">
            <div class="col">
                <div class="card shadow-sm border-0 bg-gradient-success text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Shift Normal</h5>
                        <p class="card-text display-4 fw-bold">{{ $shiftN }} <small class="fs-6">Karyawan</small></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 bg-gradient-info text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Shift Pagi</h5>
                        <p class="card-text display-4 fw-bold">{{ $shift1 }} <small class="fs-6">Karyawan</small></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 bg-gradient-warning text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Shift Siang</h5>
                        <p class="card-text display-4 fw-bold">{{ $shift2 }} <small class="fs-6">Karyawan</small></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 bg-gradient-primary text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Shift Malam</h5>
                        <p class="card-text display-4 fw-bold">{{ $shift3 }} <small class="fs-6">Karyawan</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Shift -->
        <div class="d-flex justify-content-center">
            <div class="form-group mt-4 mb-2 w-50">
                <label for="filterShift" class="w-100 text-center">Pilih Shift</label>
                <select name="filterShift" id="filterShift" onchange="filterDashboard()" class="form-control text-center">
                    <option value="All">All</option>
                    <option value="N">Normal</option>
                    <option value="1">Pagi</option>
                    <option value="2">Second</option>
                    <option value="3">Malam</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body dashDataDepartment">
                        @include('pages.dashboard.tbldepartment')
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body dashDataArea">
                        @include('pages.dashboard.tblarea')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')
<script>
    $(document).ready(() => {
        initTables();
        filterDashboard();
    });

    function initTables() {
        if ($.fn.DataTable.isDataTable('#tblDepartment')) {
            $('#tblDepartment').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#tblArea')) {
            $('#tblArea').DataTable().destroy();
        }

        $('#tblDepartment').DataTable({
            responsive: true,
            autoWidth: false
        });

        $('#tblArea').DataTable({
            responsive: true,
            autoWidth: false
        });
    }

    function filterDashboard() {
        const shift = $('#filterShift').val();

        $.ajax({
            url: "{{ route('dashboard.filter') }}",
            method: "GET",
            data: {
                shift
            },
            success: function(response) {
                $('.dashDataDepartment').html(response.department);
                $('.dashDataArea').html(response.area);

                // Delay slightly to ensure DOM has rendered new tables
                setTimeout(() => {
                    initTables();
                }, 50);
            },
            error: function(xhr) {
                console.error("Dashboard filter error", xhr);
                Swal.fire("Error", "Failed to load filtered dashboard data.", "error");
            }
        });
    }
</script>
@endsection