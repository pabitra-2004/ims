<x-layouts::app>
    <div class="mb-6">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">Inventory</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can manage your Inventory</flux:text>
            </div>

            {{-- actions --}}
            <div class="justify-self-end">
                <flux:modal.trigger name="update-stock">
                    <flux:button variant="primary" color="indigo" icon="pencil-square">Update Stock</flux:button>
                </flux:modal.trigger>
            </div>
        </div>
        <flux:separator variant="subtle" class="mt-4" />
    </div>

    <livewire:manage-inventory />
    
    <livewire:update-stock />
</x-layouts::app>
