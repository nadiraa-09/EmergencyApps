<form action="{{ route('update-employee', ['id' => $data->badgeid]) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="badgeid" id="badgeid" value="{{ $data->badgeid }}" class="form-control"
                    @readonly(true) required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Area</label>
                <select class="form-control" name="areaId" id="areaId" required>
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ $area->id == $data->areaId ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="departmentId">Department</label>
                <select class="form-control" name="departmentId" id="departmentId" required>
                    @foreach ($departments as $department)
                    <option value="{{ $department->id }}" {{ $department->id == $data->departmentId ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="lineId">Line</label>
                <select class="form-control" name="lineId" id="lineId" required>
                    @foreach ($lines as $line)
                    <option value="{{ $line->id }}" {{ $line->id == $data->lineId ? 'selected' : '' }}>
                        {{ $line->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="roleId">Role</label>
                <select class="form-control" name="roleId" id="roleId" required>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $role->id == optional($user?->role)->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>

                    @endforeach
                </select>


            </div>
        </div>
    </div>

    <center>
        <button type="submit" class="btn btn-primary" name="editUser" id="editUser">Submit</button>
    </center>
</form>