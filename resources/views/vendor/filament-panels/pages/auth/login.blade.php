<x-filament-panels::page.simple>

      {{-- BRAND --}}
    <x-slot name="heading">
        <div class="text-2xl font-bold text-center text-primary-600">
            CMS Radja
        </div>
    </x-slot>



    {{-- JAM & TANGGAL --}}
    <div class="text-center mb-6">
        <div id="datetime" class="text-lg font-semibold text-primary-600"></div>
    </div>

    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form id="form" wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

    {{-- SCRIPT JAM LIVE --}}
    <script>
        function updateDateTime() {
            const now = new Date();

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            const date = now.toLocaleDateString('id-ID', options);
            const time = now.toLocaleTimeString('id-ID');

            document.getElementById('datetime').innerHTML = date + ' | ' + time;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</x-filament-panels::page.simple>