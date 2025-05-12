<x-layouts.main :title="'Billing'" :contentHeader="'Billing Entry'">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="no-print">
        <form method="POST" action="{{ route('billings.store') }}">
            @csrf

            <!-- Radio Buttons for Type Selection -->
            <div class="form-group mb-4">
                <label class="form-label"><strong>Billing Type</strong></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" value="material" checked onclick="toggleType()">
                        <label class="form-check-label">Material</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" value="worker" onclick="toggleType()">
                        <label class="form-check-label">Worker</label>
                    </div>
                </div>
            </div>

            <!-- Material Section -->
            <div id="material-section">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="material_id">Material Name</label>
                        <select name="material_id" class="form-control" id="material_id" onchange="fetchMaterialDetails(this.value)">
                            <option value="">-- Select Material --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 mb-3" id="material-type-group" style="display: none;">
                    <label for="material_type">Type</label>
                    <select class="form-control" name="material_type" id="material_type">
                        <option value="">-- Select Type --</option>
                        <option value="Arch">Arch</option>
                        <option value="Frame">Frame</option>
                    </select>
                </div>

                    <div class="form-group col-md-6 mb-3">
                        <label for="sqft">Square Feet</label>
                        <input type="number" step="0.01" name="sqft" id="sqft" class="form-control" placeholder="Enter sq. ft">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="rate">Rate</label>
                        <input type="number" step="0.01" name="rate" id="rate" class="form-control" placeholder="Enter rate">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="qty">Quantity</label>
                        <input type="number" name="qty" id="qty" class="form-control" placeholder="Enter quantity">
                    </div>
                </div>
            </div>

            <!-- Worker Section -->
            <div id="worker-section" style="display: none;">
                <div class="form-group mb-3">
                    <label for="worker_id">Worker Name</label>
                    <select name="worker_id" class="form-control" id="worker_id" onchange="fetchWorkerDetails(this.value)">
                        <option value="">-- Select Worker --</option>
                        @foreach($workers as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
    <div class="form-group col-md-4 mb-3">
        <label for="wage">Wage</label>
        <input type="number" step="0.01" name="wage" id="wage" class="form-control" readonly>
    </div>
    <div class="form-group col-md-4 mb-3">
        <label for="food">Food Expense</label>
        <input type="number" step="0.01" name="food" id="food" class="form-control">
    </div>
    <div class="form-group col-md-4 mb-3">
        <label for="transport">Transport</label>
        <input type="number" step="0.01" name="transport" id="transport" class="form-control">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6 mb-3">
          <!-- Multi-date selector -->
        <label for="work_dates">Select Work Dates</label>
        <input type="text" name="work_dates[]" id="work_dates" class="form-control" placeholder="Select multiple dates" multiple>
    </div>
    <div class="form-group col-md-6 mb-3">
        <label for="no_of_days">No. of Days</label>
        <input type="number" name="no_of_days" id="no_of_days" class="form-control" readonly>
    </div>
</div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-check-circle"></i> Submit Billing
                </button>
            </div>
        </form>
    </div>

    <!-- Material Billing Table -->
    <div id="material-table" class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Material Billing List</h5>
        </div>
        <div class="card-body">
            <table id="material-billing-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Material Type</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Sqft</th>
                        <th>Total</th>
                        <th class="no-export">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billings->where('type', 'material') as $billing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $billing->material_type ?? 'N/A' }}</td>
                            <td>{{ $billing->material->name ?? 'N/A' }}</td>
                            <td>{{ $billing->rate }}</td>
                            <td>{{ $billing->qty }}</td>
                            <td>{{ $billing->sqft }}</td>
                            <td><strong>{{ $billing->total }}</strong></td>
 <td class="no-export">
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBillingModal{{ $billing->id }}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                        </tr>

 <!-- Delete Modal for Material -->
                <div class="modal fade" id="deleteBillingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="deleteBillingLabel{{ $billing->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('billings.destroy', $billing->id) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBillingLabel{{ $billing->id }}">Delete Material Billing</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this material billing entry?
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

    <!-- Worker Billing Table -->
    <div id="worker-table" class="card mt-4" style="display: none;">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Worker Billing List</h5>
        </div>
        <div class="card-body">
            <table id="worker-billing-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Worker Name</th>
                        <th>Wage</th>
                        <th>Food</th>
                        <th>Transport</th>
                        <th>No. of Days</th>
                        <th>Worked Dates</th>
                        <th>Total</th>
                        <th class="no-export">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billings->where('type', 'worker') as $billing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $billing->worker->name ?? 'N/A' }}</td>
                            <td>{{ $billing->wages }}</td>
                            <td>{{ $billing->food }}</td>
                            <td>{{ $billing->transport }}</td>
                            <td>{{ $billing->no_of_days }}</td>
                            <td>{{ $billing->work_dates }}</td>
                            <td><strong>{{ $billing->total }}</strong></td>
                             <td class="no-export">
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteBillingModal{{ $billing->id }}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                        </tr>

                          <!-- Delete Modal for Worker -->
                <div class="modal fade" id="deleteBillingModal{{ $billing->id }}" tabindex="-1" aria-labelledby="deleteBillingLabel{{ $billing->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('billings.destroy', $billing->id) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBillingLabel{{ $billing->id }}">Delete Worker Billing</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this worker billing entry?
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this billing entry?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @section('css')
    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- DataTables Buttons -->
    <link href="https://-cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <style>
        @media print {
            /* Hide elements marked as no-print */
            .no-print,
            .no-print * {
                display: none !important;
            }

            /* Remove browser default headers, footers, and margins */
            @page {
                margin:0;
                size: auto;
            }

            /* Ensure the body has no extra margins or padding */
            /* body {
                margin: 0 !important;
                padding: 0 !important;
            } */

            /* Hide any unwanted elements like DataTable buttons or pagination */
            .dataTables_wrapper .dt-buttons,
            .dataTables_wrapper .dataTables_paginate,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: none !important;
            }

            /* Ensure only the table content is printed */
            /* #material-table, #worker-table {
                width: 100% !important;
                margin: 0 !important;
            } */

            /* Optional: Adjust table styling for print */
            .table {
                border-collapse: collapse !important;
            }

            /* .table th, .table td {
                border: 1px solid #000 !important;
                padding: 5px !important;
            } */

            /* Hide action buttons in the table during print */
            .table .btn {
                display: none !important;
            }
        }
    </style>
@endsection



    @section('js')
        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- Number to Words -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/number-to-words/1.2.4/number-to-words.min.js"></script>

        <script>
            function toggleType() {
                const type = document.querySelector('input[name="type"]:checked').value;
                document.getElementById('material-section').style.display = (type === 'material') ? 'block' : 'none';
                document.getElementById('worker-section').style.display = (type === 'worker') ? 'block' : 'none';
                document.getElementById('material-table').style.display = (type === 'material') ? 'block' : 'none';
                document.getElementById('worker-table').style.display = (type === 'worker') ? 'block' : 'none';
                    document.getElementById('material-type-group').style.display = (type === 'material') ? 'block' : 'none';
            }

            function fetchMaterialDetails(materialId) {
                if (!materialId) {
                    document.getElementById('sqft').value = '';
                    return;
                }

                fetch(`/materials/${materialId}/details`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.sqft !== undefined) {
                                document.getElementById('sqft').value = data.sqft;
                            } else {
                                alert('No sqft data found for the selected material.');
                                document.getElementById('sqft').value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching material details:', error);
                            document.getElementById('sqft').value = '';
                        });
            }

            function fetchWorkerDetails(workerId) {
                if (!workerId) return;

                fetch(`/workers/${workerId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('wage').value = data.wage ?? 0;
                    })
                    .catch(error => console.error('Error fetching worker details:', error));
            }

            flatpickr("#work_dates", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates) {
                    document.getElementById('no_of_days').value = selectedDates.length;
                }
            });

            document.addEventListener('DOMContentLoaded', toggleType);

            $(document).ready(function() {
                $('#material-billing-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'csv',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'excel',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'pdf',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'print',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 'no-export',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#worker-billing-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'csv',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'excel',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'pdf',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        },
                        {
                            extend: 'print',
                            exportOptions: { columns: ':not(.no-export)' },
                            title: ''
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 'no-export',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });



            });
        </script>
    @endsection

</x-layouts.main>
