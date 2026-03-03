<x-app-layout>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add State</h1>
        <a href="{{ route('reference.states.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('reference.states.store') }}">
                @csrf

                @include('reference::states._form')

                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Save
                    </button>
                    <a href="{{ route('reference.states.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>
</x-app-layout>
