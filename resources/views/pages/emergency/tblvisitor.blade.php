<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Area</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitors ?? [] as $visitor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $visitor->name }}</td>
                <td>{{ $visitor->area->name ?? '-' }}</td>
                <td>
                    <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus visitor ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-muted">Belum ada visitor.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>