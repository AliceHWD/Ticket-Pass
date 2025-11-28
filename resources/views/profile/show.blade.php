@extends('layouts.main')

@section('titulo', 'Perfil')
@section('css', '/css/profile.css')

@section('conteudo')
<div class="profile-wrapper">
    <div class="profile-container">
        <div class="profile-header">
            <h1>Meu Perfil</h1>
            <p>Gerencie suas informações pessoais e configurações de segurança</p>
        </div>

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="profile-card">
                @livewire('profile.update-profile-information-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="profile-card">
                @livewire('profile.update-password-form')
            </div>
        @endif

        {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="profile-card">
                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif

        <div class="profile-card">
            @livewire('profile.logout-other-browser-sessions-form')
        </div> --}}

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="profile-card danger-card">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>
</div>

{{-- Modal global de confirmação --}}
<div class="modal-overlay" wire:ignore.self wire:model="confirmingUserDeletion" style="display: none;">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <h3 id="modal-title" class="modal-title">Confirme sua senha</h3>
        
        <p class="modal-text">Digite sua senha para confirmar a exclusão permanente da conta.</p>
        
        <div class="modal-body">
            <input type="password" class="input" name="password" id="confirm-password" wire:model.defer="password" placeholder="Senha atual">
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>
        
        <div class="modal-actions">
            <button type="button" class="login-button" wire:click="$set('confirmingUserDeletion', false)">Cancelar</button>
            <button type="button" class="login-button danger" wire:click="deleteUser" wire:loading.attr="disabled">
                Confirmar exclusão
            </button>
        </div>
    </div>
</div>

@endsection
