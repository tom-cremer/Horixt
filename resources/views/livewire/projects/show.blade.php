<div>
    <h2 class="text-xl font-bold">{{ $project->name }}</h2>
    <p>{{ $project->description }}</p>
    <a href="{{ route('projects.index') }}" wire:navigate class="mt-2 bg-gray-500 text-white p-2 rounded">Retour</a>
</div>
