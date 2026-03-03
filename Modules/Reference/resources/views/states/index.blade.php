<x-app-layout>
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">States</h1>
        <a href="{{ route('reference.states.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add State
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('reference.states.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Name, code, ISO...">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('reference.states.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x-lg"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="60">#</th>
                            <th>DDSA Code</th>
                            <th>Name</th>
                            <th>Full Name</th>
                            <th>ISO Code</th>
                            <th width="80">Sort</th>
                            <th width="100">Status</th>
                            <th width="200" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($states as $state)
                            <tr>
                                <td>{{ $states->firstItem() + $loop->index }}</td>
                                <td><code>{{ $state->ddsa_code ?? '-' }}</code></td>
                                <td><strong>{{ $state->name }}</strong></td>
                                <td>{{ $state->fullname ?? '-' }}</td>
                                <td><code>{{ $state->iso_code ?? '-' }}</code></td>
                                <td>{{ $state->sort }}</td>
                                <td>
                                    <form action="{{ route('reference.states.toggle-status', $state) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $state->status ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $state->status ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('reference.states.show', $state) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('reference.states.edit', $state) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('reference.states.destroy', $state) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this state?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No states found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($states->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $states->firstItem() }}–{{ $states->lastItem() }} of {{ $states->total() }} results
                    </small>
                    {{ $states->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
</x-app-layout>
