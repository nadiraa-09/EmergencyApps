@extends('layouts.header')

@section('titlepage', 'Upload Data Shift')
@section('container')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Data Shift <span class="badge badge-info">{{ $totalEmployee }} Employees</span>
                        </h5>
                        <div class="card-tools">
                            <a class="btn btn-warning" href="{{ asset('format/shift-format.xlsx') }}" download>Download Format</a>
                            <a class="btn btn-primary me-2" data-toggle="modal" data-target="#modalAddEmployee">Upload Shift</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dashDataUser">
                            @include('pages.shift.tblshift')
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
            @include('pages.shift.addshift')
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
            title: 'Success',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
        @endif

        @if(session('error'))
        Swal.fire({
            title: 'Error',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
        @endif
    });

    const getEmployees = () => {
        $('#tblEmployee').DataTable({});
    }

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
                Swal.fire("Error", "Failed to load employee data.", "error");
            }
        })
    }

    const inActiveUser = (id) => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! " + id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    dataType: "html",
                    type: "PATCH",
                    // url: "{{ route('inactive-user', 'id:') }}",
                    url: '/pages/userinactive/' + id,
                    data: {
                        id: id,
                    },
                    success: (response) => {
                        try {
                            const responseJson = JSON.parse(response)
                            if (responseJson.type === "error") {
                                errorToast(responseJson.message)
                            }
                        } catch (err) {
                            successToast("Success Delete Data User")
                            $(".dashDataUser").html(response)
                            getEmployees()
                        }
                    },
                    error: (requestObject, error, errorThrown) => {
                        errorToast(error)
                    }
                })
            }
        })
    }
</script>
@endsection