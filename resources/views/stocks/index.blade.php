<x-layouts::app>

    <div class="mb-6">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">Inventory</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can manage your Inventory</flux:text>
            </div>

            {{-- actions --}}
            <div class="justify-self-end">
                <flux:modal.trigger name="">
                    <flux:button variant="primary" color="indigo" icon="plus">Add Inventory</flux:button>
                </flux:modal.trigger>
            </div>
        </div>
        <flux:separator variant="subtle" class="mt-4" />
    </div>

    <livewire:stocks.product-list />
</x-layouts::app>
