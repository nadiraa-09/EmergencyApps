<form action="{{ route('update-employee', ['id' => $data->badgeid]) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="badgeid" id="badgeid" value="{{ $data->badgeid }}" class="form-control"
                    @readonly(true) required>
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