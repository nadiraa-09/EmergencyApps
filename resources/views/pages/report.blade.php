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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Filter">Filter</label>
                                        <select name="Filter" id="Filter" onchange="filterReport()"
                                            class="form-control">
                                            <option value="All">All</option>
                                            <option value="PENDING">Pending</option>
                                            <option value="APPROVED">Approved</option>
                                            <option value="REJECTED">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="dashDataReportRequest">
                                        <!-- this content will show here  -->
                                        @include('pages.Report.tblReport')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="modalDataDetailReport" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content dashDataDetailReport">

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
            getReportList()
        })

        const getReportList = () => {
            // $(".dashDataReportRequest").html(response)
            // $('#tblReportRequest').DataTable();
            var table = $('#tblReportRequest').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');
        }

        const filterReport = () => {
            var Filter = $("#Filter").val()
            $.ajax({
                dataType: "html",
                type: "POST",
                url: `{{ route('reportfilter', ['Filter' => '{Filter}']) }}`,
                data: {
                    Filter: Filter,
                },
                success: (response) => {
                    // kode lainnya
                    $(".dashDataReportRequest").html(response);
                    var groupColumn = 1;
                    var table = $('#tblReportRequest').DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": ["copy", "excel", "pdf", "print"]
                    }).buttons().container().appendTo('#tblReportRequest_wrapper .col-md-6:eq(0)');
                },
                error: (requestObject, error, errorThrown) => {
                    errorToast(error)
                }
            })
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
