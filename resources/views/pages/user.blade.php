@extends('layouts.header')

@section('titlepage', 'User')
@section('container')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="card-title">Data Users</div>
                        <div class="card-tools">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#modalAddUser">Add User</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dashDataUser">
                            <!-- this content will show here  -->
                            @include('pages.user.tbluser')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal Add-->
<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            @include('pages.user.adduser')
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="dashDataDetailUser">
                    <!-- this content will show here  -->
                </div>
            </div>
        </div>
    </div>
</div>

{{-- @push('scripts') --}}

{{-- @endpush --}}
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

    const getUsers = () => {
        $('#tblUser').DataTable({});
    }

    $("#editUser").click(function() {
        $("#editUser").prop('disabled', true);
        console.log('OKE');
        // $("#formEdit").submit();
    });

    const getDetailUser = (id) => {
        $.ajax({
            dataType: 'html',
            type: "POST",
            url: "{{ route('detail-user') }}",
            data: {
                id: id,
            },
            success: (response) => {
                $(".dashDataDetailUser").html(response);
                $("#modalEditUser").modal("show");
            },
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
                            getUsers()
                        }
                    },
                    error: (requestObject, error, errorThrown) => {
                        errorToast(error)
                    }
                })
            }
        })
    }

    const changePassword = (id) => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'Change Password',
            input: 'password',
            inputLabel: 'New Password',
            inputPlaceholder: 'Enter new password',
            showCancelButton: true,
            confirmButtonText: 'Change',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                return fetch(`update-password/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            password: password,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            Swal.fire('Password Changed!', 'User password updated successfully.', 'success');
                        } else {
                            throw new Error(data.message || 'Unknown error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', error.message, 'error');
                    });
            },
        });
    };
</script>
@endsection