@extends('layouts.header')

@section('titlepage', 'Report')
@section('container')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="card-title">Data Report</div>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Filter">Filter Area</label>
                                    <select name="Filter" id="filterArea" onchange="filterReport()"
                                        class="form-control">
                                        <option value="All">All</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Filter">Filter Department</label>
                                    <select name="Filter" id="filterDepartment" onchange="filterReport()"
                                        class="form-control">
                                        <option value="All">All</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @php
                            $today = now();
                            @endphp
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="Month">Bulan</label>
                                            <select name="Month" id="Month" onchange="filterReport()" class="form-control">
                                                @php
                                                $months = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                                ];
                                                @endphp
                                                @foreach ($months as $num => $name)
                                                <option value="{{ $num }}" {{ $num == $today->month ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="Year">Tahun</label>
                                            <select name="Year" id="Year" onchange="filterReport()" class="form-control">
                                                @for ($year = $today->year; $year >= 2020; $year--)
                                                <option value="{{ $year }}" {{ $year == $today->year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="dashDataReportRequest">
                                    <!-- this content will show here  -->
                                    @include('pages.report.tblreport')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(() => {
        getReportList()
    })

    const getReportList = () => {
        var table = $('#tblReportRequest').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');
    }

    const filterReport = () => {
        const areaId = $('#filterArea').val();
        const departmentId = $('#filterDepartment').val();
        const month = $('#Month').val();
        const year = $('#Year').val();

        $.ajax({
            url: `{{ route('reportfilter') }}`,
            method: "POST",
            data: {
                area_id: areaId,
                department_id: departmentId,
                month: month,
                year: year,
            },
            success: (response) => {
                $(".dashDataReportRequest").html(response);
                $('#tblReportRequest').DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    destroy: true, // important to reinit
                    buttons: ["copy", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');
            },
            error: (xhr, status, error) => {
                console.error(error);
            }
        });
    }
</script>
@endsection

{{-- <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script> --}}