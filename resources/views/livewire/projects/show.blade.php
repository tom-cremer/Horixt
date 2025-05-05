<div>
    <div class="flex items-center mb-4">
        <flux:button href="{{ \App\Helper\Context::isOrganization() ? route('organization.projects.index', \App\Helper\Context::getOrganizationSlug()): route('personal.projects.index') }}">
            Retour
        </flux:button>
    </div>
    <h2 class="text-xl font-bold">{{ $project->name }}</h2>
    <p>{{ $project->description }}</p>
</div>
