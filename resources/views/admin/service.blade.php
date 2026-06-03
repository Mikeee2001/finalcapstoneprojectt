@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">Services Management</h2>
                <small class="text-muted">Manage veterinary services and pricing</small>
            </div>

            <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                + Add Service
            </button>

        </div>

        {{-- FILTER --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">

                <div class="row g-2">

                    <div class="col-md-8">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search service name or category...">
                    </div>

                    <div class="col-md-4">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm overflow-hidden">

            <div class="bg-primary text-white px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="fw-bold">Service List</div>
                <div class="small text-white-50">
                    Total: {{ $services->total() }} services
                </div>
            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th class="text-end">Status</th>
                        </tr>
                    </thead>

                    <tbody id="servicesTable">

                        @forelse($services as $service)
                            <tr class="service-row"
                                data-name="{{ strtolower($service->service_name . ' ' . ($service->category->category_name ?? '')) }}"
                                data-status="{{ $service->status ?? 'active' }}">

                                <td>
                                    {{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $service->category->category_name ?? 'No Category' }}
                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    {{ $service->service_name }}
                                </td>

                                <td class="text-muted small">
                                    {{ Str::limit($service->service_description, 60) }}
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        ₱{{ number_format($service->price, 2) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <button
                                        class="btn btn-sm toggle-status-btn {{ $service->status === 'active' ? 'btn-success' : 'btn-secondary' }}"
                                        data-id="{{ $service->id }}" data-status="{{ $service->status ?? 'inactive' }}">
                                        {{ ucfirst($service->status ?? 'inactive') }}
                                    </button>
                                </td>

                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No services found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-between p-3 border-top">

                <small class="text-muted">
                    Showing {{ $services->firstItem() }} to {{ $services->lastItem() }}
                    of {{ $services->total() }} results
                </small>

                <div>
                    {{ $services->links() }}
                </div>

            </div>

        </div>

    </div>


    {{-- ================= MODAL ================= --}}
    <div class="modal fade" id="createServiceModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="createServiceForm">
                    @csrf

                    <div class="modal-body">

                        {{-- SERVICE NAME --}}
                        <div class="mb-3">
                            <label>Service Name</label>
                            <input type="text" name="service_name" placeholder="Enter service name" class="form-control" required>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="service_description" placeholder="Enter service description" class="form-control"></textarea>
                        </div>

                        {{-- PRICE --}}
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" name="price" placeholder="Enter price" class="form-control" required>
                        </div>

                        {{-- CATEGORY (EXISTING + NEW) --}}
                        <div class="mb-3">
                            <label>Category</label>

                            <select name="category_id" id="category_id" class="form-select" required>

                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach

                                <option value="new">+ Create New Category</option>

                            </select>
                        </div>

                        {{-- NEW CATEGORY INPUT --}}
                        <div class="mb-3 d-none" id="newCategoryDiv">
                            <label>New Category Name</label>
                            <input type="text" name="new_category" placeholder="Enter new category name" class="form-control">
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            Save Service
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- ================= SCRIPT ================= --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // FILTER
            function filterTable() {

                let search = $('#searchInput').val().toLowerCase().trim();
                let status = $('#statusFilter').val();

                let visible = 0;

                $('.service-row').each(function() {

                    let name = ($(this).data('name') || '').toLowerCase();
                    let rowStatus = $(this).data('status');

                    let match =
                        name.includes(search) &&
                        (status === "" || rowStatus === status);

                    $(this).toggle(match);

                    if (match) visible++;
                });

                // HANDLE NO RESULTS
                if (visible === 0) {

                    if ($('#noDataRow').length === 0) {
                        $('#servicesTable').append(`
                <tr id="noDataRow">
                    <td colspan="6" class="text-center py-5 text-muted">
                        No services found
                    </td>
                </tr>
            `);
                    }

                } else {
                    $('#noDataRow').remove();
                }

                // HANDLE PAGINATION VISIBILITY
                if (visible === 0) {
                    $('.d-flex.justify-content-between.p-3.border-top').hide();
                } else {
                    $('.d-flex.justify-content-between.p-3.border-top').show();
                }
            }

            $('#searchInput').on('keyup', filterTable);
            $('#statusFilter').on('change', filterTable);

            // TOGGLE NEW CATEGORY INPUT
            $('#category_id').on('change', function() {

                if ($(this).val() === 'new') {
                    $('#newCategoryDiv').removeClass('d-none');
                } else {
                    $('#newCategoryDiv').addClass('d-none');
                }

            });

            $(document).on('click', '.toggle-status-btn', function() {

                let button = $(this);
                let id = button.data('id');

                $.post("/admin/service/toggle-status/" + id, {
                    _token: "{{ csrf_token() }}"
                }, function(response) {

                    if (response.success) {

                        let status = response.status; // FROM BACKEND

                        button.text(status.charAt(0).toUpperCase() + status.slice(1));

                        button.removeClass('btn-success btn-secondary');

                        if (status === 'active') {
                            button.addClass('btn-success');
                        } else {
                            button.addClass('btn-secondary');
                        }

                        button.data('status', status);
                        button.closest('tr').attr('data-status', status);
                    }
                });

            });

            $('#createServiceForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.add.services') }}",
                    type: "POST",
                    data: $(this).serialize(),

                    success: function(response) {

                        if (response.status === 1) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1200,
                                showConfirmButton: false
                            });

                            // close modal
                            $('#createServiceModal').modal('hide');

                            // reload table
                            location.reload();
                        }
                    },

                    error: function() {
                        Swal.fire('Error', 'Failed to create service', 'error');
                    }
                });
            });

        });
    </script>
@endsection
