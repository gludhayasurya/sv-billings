<x-layouts.main :title="'Workers'" :contentHeader="'Manage Workers'">

    <!-- Add Worker Button -->
    <div class="mb-3 text-end">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addWorkerModal">
            <i class="fas fa-plus-circle"></i> Add Worker
        </button>
    </div>

    <!-- Worker Table -->
    <div class="card">
        <div class="card-body">
            <table id="workers-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Name</th>
                        <th>Wages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workers as $index => $worker)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $worker->name }}</td>
                            <td>{{ number_format($worker->wages, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editWorkerModal{{ $worker->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteWorkerModal{{ $worker->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editWorkerModal{{ $worker->id }}" tabindex="-1" aria-labelledby="editWorkerLabel{{ $worker->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('workers.update', $worker->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editWorkerLabel{{ $worker->id }}">Edit Worker</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $worker->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Wages</label>
                                                <input type="number" step="0.01" name="wages" class="form-control" value="{{ $worker->wages }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit">Update</button>
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteWorkerModal{{ $worker->id }}" tabindex="-1" aria-labelledby="deleteWorkerLabel{{ $worker->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('workers.destroy', $worker->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteWorkerLabel{{ $worker->id }}">Delete Worker</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $worker->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Worker Modal -->
    <div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('workers.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWorkerLabel">Add Worker</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Wages</label>
                            <input type="number" step="0.01" name="wages" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Add</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
    @endsection

    @section('js')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(function () {
                $('#workers-table').DataTable();
            });
        </script>
    @endsection

</x-layouts.main>
