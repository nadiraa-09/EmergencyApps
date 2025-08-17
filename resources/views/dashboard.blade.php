@extends('layouts.headerdashboard')

@section('container')
<section class="content">
    <div class="container-fluid">

        <div class="text-center">
            <h1 class="display-5 fw-bold text-uppercase text-primary-emphasis">
                <i class="bi bi-clipboard-data me-2"></i>
                Attendance Report
            </h1>

            <p class="text-muted fs-6 fst-italic">
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                —
                <span id="live-time" class="text-dark fw-semibold"></span>
            </p>
        </div>

        @php
        $shifts = [
        'N' => ['label' => 'Normal', 'color' => 'bg-gradient-success', 'icon' => 'bi-journal-text'],
        '1' => ['label' => 'Morning', 'color' => 'bg-gradient-info', 'icon' => 'bi-brightness-high-fill'],
        '2' => ['label' => 'Afternoon', 'color' => 'bg-gradient-warning', 'icon' => 'bi-sun'],
        '3' => ['label' => 'Evening', 'color' => 'bg-gradient-primary', 'icon' => 'bi-moon-stars-fill'],
        ];
        @endphp

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
            @foreach($shifts as $code => $shift)
            <div class="col">
                <table class="table table-bordered table-hover shadow-sm rounded-4 overflow-hidden">
                    <thead class="{{ $shift['color'] }} text-white text-center">
                        <tr>
                            <th colspan="2" class="py-3">
                                <i class="bi {{ $shift['icon'] }} fs-3 me-2"></i>
                                <span class="fw-bold">{{ $shift['label'] }} Shift</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">Total</td>
                            <td class="text-end fw-bold">{{ $shiftData[$code]['total'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Attendance</td>
                            <td class="text-end text-success fw-bold">{{ $shiftData[$code]['hadir'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Absent</td>
                            <td class="text-end text-danger fw-bold">{{ $shiftData[$code]['absen'] ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>

        <style>
            table {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            table:hover {
                transform: translateY(-4px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            }
        </style>

        <!-- Data Tabel Departemen & Area -->
        <!-- <div class="row g-4">
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
        </div> -->
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
    /* Tambahkan jarak atas & bawah agar tidak nempel */
    .content {
        min-height: calc(100vh - 120px);
        /* sesuaikan 120px dengan tinggi footer/header */
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Vertikal center */
        padding-top: 20px;
        /* Jarak kecil atas */
        padding-bottom: 20px;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Judul supaya lebih estetik */
    .content .text-center h1 {
        margin-bottom: 0.5rem;
    }

    /* Spasi antar tabel */
    .row.g-4 {
        margin-top: 1.5rem;
    }
</style>
@endsection