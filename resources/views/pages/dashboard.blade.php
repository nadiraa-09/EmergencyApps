@extends('layouts.header')

@section('container')
<section class="content">
    <div class="container-fluid">

        <div class="text-center">
            <h1 class="display-5 fw-bold text-uppercase text-primary-emphasis">
                <i class="bi bi-clipboard-data me-2"></i>
                Evacuation Attendance Report
            </h1>

            <p class="text-muted fs-6 fst-italic">
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                —
                <span id="live-time" class="text-dark fw-semibold"></span>
            </p>
        </div>

        @php
        $shifts = [
        'N' => ['label' => 'Normal', 'color' => 'bg-gradient-success', 'icon' => 'bi-person-lines-fill'],
        '1' => ['label' => 'Morning', 'color' => 'bg-gradient-info', 'icon' => 'bi-brightness-high-fill'],
        '2' => ['label' => 'Afternoon', 'color' => 'bg-gradient-warning', 'icon' => 'bi-sun'],
        '3' => ['label' => 'Evening', 'color' => 'bg-gradient-primary', 'icon' => 'bi-moon-stars-fill'],
        ];
        @endphp

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-1 mb-4">
            @foreach($shifts as $code => $shift)
            <div class="col d-flex">
                <div class="card w-100 text-white shadow border-0 {{ $shift['color'] }} rounded-4 hover-shadow transition">
                    <div class="card-body d-flex align-items-center gap-3 py-3 px-4">
                        <i class="bi {{ $shift['icon'] }} fs-2"></i>
                        <div class="text-start">
                            <h6 class="mb-1 fw-bold" style="color: #fff;">
                                Shift <span style="color: #531a22ff;">{{ $shift['label'] }}</span>
                            </h6>
                            <div class="small fw-bold" style="color: #250202ff;">
                                <div>Total Employee: <span class="fw-bold">{{ $shiftData[$code]['total'] ?? 0 }}</span></div>
                                <div>Attendance: <span class="fw-bold">{{ $shiftData[$code]['hadir'] ?? 0 }}</span></div>
                                <div>Absent: <span class="fw-bold text-danger">{{ $shiftData[$code]['absen'] ?? 0 }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Data Tabel Departemen & Area -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-secondary text-white text-center fw-semibold rounded-top">
                        <i class="bi bi-building me-2"></i>Data by Department
                    </div>
                    <div class="card-body dashDataDepartment px-3 py-2">
                        @include('pages.dashboard.tbldepartment')
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-secondary text-white text-center fw-semibold rounded-top">
                        <i class="bi bi-geo-alt-fill me-2"></i>Data by Area
                    </div>
                    <div class="card-body dashDataArea px-3 py-2">
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
        setInterval(() => {
            window.location.reload();
        }, 30000); // Reload full page every 30 seconds
    });

    function initTables() {
        ['#tblDepartment', '#tblArea'].forEach(id => {
            if ($.fn.DataTable.isDataTable(id)) {
                $(id).DataTable().destroy();
            }
            $(id).DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                lengthChange: false
            });
        });
    }

    function updateClock() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('live-time').textContent = timeStr;
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        transform: scale(1.02);
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    .text-danger-row {
        background-color: #250202ff !important;
        color: #250202ff !important;
    }

    table.dataTable tbody tr.text-danger td {
        background-color: #eba8afff;
    }

    .card .bi {
        opacity: 0.9;
    }
</style>
@endsection