<form action="{{ route('upload-shift') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="by" id="by" class="form-control" value="{{ Auth::user()->username }}" readonly required>
                <div class="form-group">
                    <label for="shiftfile">Upload Shift Excel</label>
                    <input type="file" name="shiftfile" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>