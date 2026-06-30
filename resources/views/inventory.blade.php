<x-layouts::app>
    <div class="select-none">
        <div class="mb-2 ">
            <div class="grid items-center grid-cols-2 gap-4">
                <div>
                    <flux:heading size="lg" level="2">Inventory</flux:heading>
                    <flux:text class="mt-1 text-sm">Here you can manage your Inventory</flux:text>
                </div>

                {{-- actions --}}
                <div class="justify-self-end">
                    <flux:modal.trigger name="update-stock">
                        <flux:button variant="primary" size="sm" color="indigo" icon="pencil-square">Update Stock
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:separator variant="subtle" class="my-2" />
        </div>

        <livewire:manage-inventory />
        <livewire:update-stock />
    </div>
</x-layouts::app>
