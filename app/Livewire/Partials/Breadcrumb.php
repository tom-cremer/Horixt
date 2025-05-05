<?php

namespace App\Livewire\Partials;

use App\Helper\Context;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Breadcrumb extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        if (Context::isOrganization()) {
            $this->generateOrganizationBreadcrumb();
        } else {
            $this->generatePersonnalBreadcrumb();
        }
    }

    public function generatePersonnalBreadcrumb()
    {
        $currentRoute = Route::current();
        $routeName = $currentRoute->getName();
        $routeParameters = $currentRoute->parameters();

        $breadcrumbs = [
            [
                'label' => __('Personal'),
                'url' => route('personal.dashboard'),
                'icon' => 'home'
            ],

        ];

        if ($routeName === 'personal.dashboard') {
            $breadcrumbs[] = [
                'label' => __('Dashboard'),
                'url' => route('personal.dashboard'),
            ];
        } elseif ($routeName === 'personal.todos') {
            $breadcrumbs[] = [
                'label' => __('Todos'),
                'url' => route('personal.todos'),
            ];
        } elseif ($routeName === 'personal.projects.index') {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('personal.projects.index'),
            ];
        } elseif ($routeName === 'personal.projects.show' && isset($routeParameters['projectid'])) {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('personal.projects.index'),
            ];
            $breadcrumbs[] = [
                'label' => __('Project Details'),
                'url' => route('personal.projects.show', ['projectid' => $routeParameters['projectid']]),
            ];
        } elseif ($routeName === 'personal.settings') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('personal.settings'),
            ];
        } elseif ($routeName === 'personal.settings.profile') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('personal.settings'),
            ];
            $breadcrumbs[] = [
                'label' => __('Profile'),
                'url' => route('personal.settings.profile'),
            ];
        } elseif ($routeName === 'personal.settings.appearance') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('personal.settings'),
            ];
            $breadcrumbs[] = [
                'label' => __('Appearance'),
                'url' => route('personal.settings.appearance'),
            ];
        } elseif ($routeName === 'personal.settings.password') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('personal.settings'),
            ];
            $breadcrumbs[] = [
                'label' => __('Password'),
                'url' => route('personal.settings.password'),
            ];
        } elseif ($routeName === 'personal.files') {
            $breadcrumbs[] = [
                'label' => __('Files'),
                'url' => route('personal.files'),
            ];
        }

        $this->breadcrumbs = $breadcrumbs;
    }

    public function generateOrganizationBreadcrumb()
    {
        $currentRoute = Route::current();
        $routeName = $currentRoute->getName();
        $routeParameters = $currentRoute->parameters();

        $breadcrumbs = [
            [
                'label' => ucfirst(Context::getOrganizationSlug()),
                'url' => route('organization.dashboard', ['slug' => Context::getOrganizationSlug()]),
                'icon' => 'building-office-2'
            ],
            [
                'label' => Context::getOrganizationSlug(),
                'url' => route('organization.dashboard', ['slug' => Context::getOrganizationSlug()]),
            ],

        ];

        if ($routeName === 'organization.dashboard') {
            $breadcrumbs[] = [
                'label' => __('Dashboard'),
                'url' => route('organization.dashboard', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.todos') {
            $breadcrumbs[] = [
                'label' => __('Todos'),
                'url' => route('organization.todos', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.projects.index') {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('organization.projects.index', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.projects.show' && isset($routeParameters['projectid'])) {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('organization.projects.index', ['slug' => Context::getOrganizationSlug()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Project Details'),
                'url' => route('organization.projects.show', ['projectid' => $routeParameters['projectid'], 'slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.settings') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.settings.profile') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['slug' => Context::getOrganizationSlug()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Profile'),
                'url' => route('organization.settings.profile', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.settings.appearance') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['slug' => Context::getOrganizationSlug()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Appearance'),
                'url' => route('organization.settings.appearance', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.settings.password') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['slug' => Context::getOrganizationSlug()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Password'),
                'url' => route('organization.settings.password', ['slug' => Context::getOrganizationSlug()]),
            ];
        } elseif ($routeName === 'organization.files') {
            $breadcrumbs[] = [
                'label' => __('Files'),
                'url' => route('organization.files', ['slug' => Context::getOrganizationSlug()]),
            ];
        }

        $this->breadcrumbs = $breadcrumbs;
    }
    public function render()
    {
        return view('livewire.partials.breadcrumb');
    }
}
