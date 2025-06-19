<form action="/pages/employeeadd" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            {{-- <div class="col-md-12">
            </div> --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="badgeid">Badge Id</label>
                    <input type="text" name="badgeid" id="badgeid" class="form-control" required>
                </div>
                <input type="hidden" name="by" id="by" class="form-control" value="{{ Auth::user()->username }}" readonly required>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="areaId">Area</label>
                    <select name="areaId" id="areaId" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="departmentId">Department</label>
                    <select name="departmentId" id="departmentId" class="form-control" required>
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lineId">Line</label>
                    <select name="lineId" id="lineId" class="form-control" required>
                        <option value="">Select Line</option>
                        @foreach ($lines as $line)
                        <option value="{{ $line->id }}">{{ $line->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="roleId">Role</label>
                    <select name="roleId" id="roleId" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</form>