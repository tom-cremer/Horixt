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
                'url' => route('organization.dashboard', ['id' => Context::getOrganizationId()]),
                'icon' => 'building-office-2'
            ],

        ];

        if ($routeName === 'organization.dashboard') {
            $breadcrumbs[] = [
                'label' => __('Dashboard'),
                'url' => route('organization.dashboard', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.todos') {
            $breadcrumbs[] = [
                'label' => __('Todos'),
                'url' => route('organization.todos', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.projects.index') {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('organization.projects.index', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.projects.show' && isset($routeParameters['projectid'])) {
            $breadcrumbs[] = [
                'label' => __('Projects'),
                'url' => route('organization.projects.index', ['id' => Context::getOrganizationId()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Project Details'),
                'url' => route('organization.projects.show', ['projectid' => $routeParameters['projectid'], 'id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.settings') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.settings.profile') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['id' => Context::getOrganizationId()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Profile'),
                'url' => route('organization.settings.profile', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.settings.appearance') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['id' => Context::getOrganizationId()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Appearance'),
                'url' => route('organization.settings.appearance', ['id' => Context::getOrganizationId()]),
            ];
        } elseif ($routeName === 'organization.settings.password') {
            $breadcrumbs[] = [
                'label' => __('Settings'),
                'url' => route('organization.settings', ['id' => Context::getOrganizationId()]),
            ];
            $breadcrumbs[] = [
                'label' => __('Password'),
                'url' => route('organization.settings.password', ['id' => Context::getOrganizationId()]),
            ];
        }

        $this->breadcrumbs = $breadcrumbs;
    }
    public function render()
    {
        return view('livewire.partials.breadcrumb');
    }
}
