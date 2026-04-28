<x-filament::page>

    <form wire:submit.prevent="generate">
        {{ $this->form }}

        <div class="mt-4 flex gap-2">
            {{ $this->getFormActions() }}
        </div>
    </form>

</x-filament::page>