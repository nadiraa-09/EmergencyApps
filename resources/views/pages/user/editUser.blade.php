<form action="{{ route('update-user', ['id' => $data->id]) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ $data->username }}" class="form-control"
            @readonly(true) required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $data->email }}" class="form-control"
            class="form-control">
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $data->name }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" name="roleId" id="roleId" required>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $role->name == $data->role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="departmentId">Department</label>
        <select class="form-control" name="departmentId" id="departmentId" required>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}"
                    {{ $department->name == $data->department->name ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="inactive">Status</label>
        <select class="form-control" name="inactive" id="inactive" required>
            {{-- @foreach ($departments as $department) --}}
            <option value="1" {{ $data->inactive == '1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $data->inactive == '0' ? 'selected' : '' }}>Non Aktif</option>
            {{-- @endforeach --}}
        </select>
    </div>
    <div class="form-group">
        <label for="leaveBalance">Leave Balance</label>
        <input type="number" name="leaveBalance" id="leaveBalance" value="{{ $userdetail->leaveBalance }}"
            class="form-control" required>
    </div>
    <center>
        <button type="submit" class="btn btn-primary" name="editUser" id="editUser">Submit</button>
    </center>
</form>
