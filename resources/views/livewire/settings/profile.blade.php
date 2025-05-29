<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {

    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $avatar;

    /**
     * Mount the component.
     */
    #[\Livewire\Attributes\On('profile-updated')]
    #[\Livewire\Attributes\On('avatar-deleted')]
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;

    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $baseValidation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ];

        if ($this->avatar) {
            $baseValidation['avatar'] = ['image', 'max:2048'];
        }

        $validated = $this->validate($baseValidation);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($this->avatar) {

            $path = $this->avatar->storePubliclyAs('avatars', $user->uuid . '.' . $this->avatar->getClientOriginalExtension(), ['disk' => 'public']);

            \App\Models\Avatar::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'path' => $path,
                ],
                [
                    'path' => $path,
                    'mime_type' => $this->avatar->getMimeType(),
                    'size' => $this->avatar->getSize(),
                    'name' => $this->avatar->getClientOriginalName(),
                    'extension' => $this->avatar->getClientOriginalExtension(),
                    'disk' => 'public',
                    'user_id' => $user->id,
                    'organization_id' => null,
                ]
            );
        }

        $user->save();
        $this->reset(['avatar']);
        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('personal.dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('local')->delete($user->avatar->path);
            $user->avatar->delete();
            $this->dispatch('avatar-deleted');
        }
    }

}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <flux:input type="file" wire:model="avatar" label="Avatar"/>


            @if (auth()->user()->avatar)
                <div class="mb-4 flex items-center gap-4">
                    <flux:avatar size="xl" src="{{\Illuminate\Support\Facades\Storage::url(\auth()->user()->avatar->path)}}" />
                    <flux:button variant="danger" type="button" size="sm" wire:click="deleteAvatar">Delete Avatar</flux:button>
                </div>

            @endif


            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email"/>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                       wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form/>
    </x-settings.layout>
</section>
