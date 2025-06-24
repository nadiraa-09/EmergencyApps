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
            scrollX: true,
            responsive: false,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "excel", "pdf", "print"]
        });

        table.buttons().container()
            .appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');

    }

    const filterReport = () => {
        let area_id = $('#filterArea').val();
        let department_id = $('#filterDepartment').val();
        let month = $('#Month').val();
        let year = $('#Year').val();

        $.ajax({
            dataType: "html",
            type: "POST",
            url: `{{ route('reportfilter') }}`,
            data: {
                area_id: area_id,
                department_id: department_id,
                month: month,
                year: year
            },
            success: (response) => {
                $(".dashDataReportRequest").html(response);
                var table = $('#tblReportRequest').DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');
            },
            error: (requestObject, error, errorThrown) => {
                errorToast(error);
            }
        });
    }
</script>
@endsection