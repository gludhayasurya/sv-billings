<x-layouts.main :title="'Materials'" :contentHeader="'Manage Materials'">

    <div class="mb-3 text-end">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addMaterialModal">
            <i class="fas fa-plus-circle"></i> Add Material
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="materials-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S. NO</th>
                        <th>Material Name</th>
                        <th>Sq. Ft</th>
                        <th>Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->sq_ft }}</td>
                            <td>{{ $material->count }}</td>
                            <td>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#editMaterialModal{{ $material->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteMaterialModal{{ $material->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Material Modal -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMaterialLabel">Add Material</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Material Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sq_ft" class="form-label">Sq. Ft</label>
                            <input type="number" step="0.01" class="form-control" id="sq_ft" name="sq_ft" required>
                        </div>
                        <div class="mb-3">
                            <label for="count" class="form-label">Count</label>
                            <input type="number" class="form-control" id="count" name="count" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Material</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Material Modal -->
    @foreach($materials as $material)
    <div class="modal fade" id="editMaterialModal{{ $material->id }}" tabindex="-1" aria-labelledby="editMaterialLabel{{ $material->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('materials.update', $material->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMaterialLabel{{ $material->id }}">Edit Material</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Material Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $material->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="sq_ft" class="form-label">Sq. Ft</label>
                            <input type="number" step="0.01" class="form-control" id="sq_ft" name="sq_ft" value="{{ $material->sq_ft }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="count" class="form-label">Count</label>
                            <input type="number" class="form-control" id="count" name="count" value="{{ $material->count }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Material</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Delete Material Modal -->
    @foreach($materials as $material)
    <div class="modal fade" id="deleteMaterialModal{{ $material->id }}" tabindex="-1" aria-labelledby="deleteMaterialLabel{{ $material->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('materials.destroy', $material->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMaterialLabel{{ $material->id }}">Delete Material</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <strong>{{ $material->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
    @endsection

    @section('js')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(function () {
                $('#materials-table').DataTable();
            });
        </script>
    @endsection

</x-layouts.main>
