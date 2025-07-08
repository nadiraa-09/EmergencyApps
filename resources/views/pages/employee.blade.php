@extends('layouts.header')

@section('titlepage', 'Employee')
@section('container')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="card-title">Data Employee</div>
                        <!-- <div class="card-tools">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modalAddEmployee">Add Employee</a>
                        </div> -->
                    </div>

                    <div class="card-body">
                        <div class="row p-2">
                            <!-- Full width filter -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="filterArea">Pilih Area</label>
                                    <select name="filterArea" id="filterArea" onchange="filterReport()" class="form-control">
                                        <option value="All">All</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="dashDataUser">
                            @include('pages.employee.tblemployee', ['datas' => $datas])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal Add-->
<div class="modal fade" id="modalAddEmployee" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            @include('pages.employee.addemployee')
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditEmployee" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="dashDataDetailEmployee">
                    <!-- this content will show here  -->
                </div>
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
        $('#tblUser').DataTable();

        @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: "{{ session('success') }}",
            background: '#28a745', // Hijau
            color: '#fff',
            iconColor: '#fff',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        @endif

        @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: "{{ session('error') }}",
            background: '#dc3545', // Merah
            color: '#fff',
            iconColor: '#fff',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        @endif

    });

    $("#editUser").click(function() {
        $("#editUser").prop('disabled', true);
        console.log('OKE');
        // $("#formEdit").submit();
    });

    const getDetailEmployee = (id) => {
        console.log("Sending badgeid:", id);
        const url = "{{ route('detail-employee') }}";

        $.ajax({
            dataType: 'html',
            type: "POST",
            url: url,
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: (response) => {
                $(".dashDataDetailEmployee").html(response);
                $("#modalEditEmployee").modal("show");
            },
            error: (xhr) => {
                console.error("Error response: ", xhr.responseText);
                Swal.fire("Error", "Gagal memuat data employee.", "error");
            }
        })
    }


    const inActiveUser = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! ID: " + id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/pages/employeeinactive/${id}`,
                    type: "PATCH",
                    success: (response) => {
                        $(".dashDataUser").html(response);
                        getEmployees(); // Reload user table
                    },
                    error: (xhr, status, error) => {
                        // Let Laravel redirect with session('error')
                        window.location.reload();
                    }
                });
            }
        });
    }

    function filterReport() {
        const area = $('#filterArea').val();

        $.ajax({
            url: "{{ route('employee-filter') }}",
            method: "GET",
            data: {
                area
            },
            success: function(response) {
                $('.dashDataUser').html(response);

                $('#tblUser').DataTable();
            },
            error: function(xhr) {
                console.error("Filter error", xhr);
                Swal.fire("Error", "Failed to load filtered data.", "error");
            }
        });
    }
</script>
@endsection