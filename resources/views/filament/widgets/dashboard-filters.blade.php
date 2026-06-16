<x-filament-widgets::widget>
    <x-filament::section>

        {{ $this->form }}

        <div
            style="
                display:flex;
                gap:10px;
                margin-top:15px;
                margin-bottom:15px;
            "
        >
            <x-filament::button
                wire:click="applyFilters"
            >
                Filter
            </x-filament::button>

            <x-filament::button
                color="gray"
                wire:click="resetFilters"
            >
                Reset
            </x-filament::button>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>