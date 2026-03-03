<x-app-layout>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">State: {{ $state->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('reference.states.edit', $state) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('reference.states.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th width="200" class="bg-light">ID</th>
                        <td>{{ $state->id }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">DDSA Code</th>
                        <td><code>{{ $state->ddsa_code ?? '-' }}</code></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Name</th>
                        <td><strong>{{ $state->name }}</strong></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Full Name</th>
                        <td>{{ $state->fullname ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">ISO Code</th>
                        <td><code>{{ $state->iso_code ?? '-' }}</code></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Sort Order</th>
                        <td>{{ $state->sort }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Status</th>
                        <td>
                            <span class="badge {{ $state->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $state->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Created By</th>
                        <td>{{ $state->created_by ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Created At</th>
                        <td>{{ $state->created_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Updated By</th>
                        <td>{{ $state->updated_by ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Updated At</th>
                        <td>{{ $state->updated_at?->format('d/m/Y H:i:s') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>
