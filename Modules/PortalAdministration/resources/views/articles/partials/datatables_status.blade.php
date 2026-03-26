<x-badge variant="{{ $article->isPublished() ? 'default' : 'secondary' }}">
    {{ $statusLabel }}
</x-badge>
