<x-layouts::app>
    <div class="mb-6">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">Orders</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can manage your orders</flux:text>
            </div>

            {{-- actions --}}
            <div class="justify-self-end">
                <flux:button :href="route('orders.create')" icon="plus" variant="primary" color="green" wire:navigate>
                    Create Orders
                </flux:button>
            </div>
        </div>
        <flux:separator variant="subtle" class="mt-4" />
    </div>

    <livewire:orders.order-list />
</x-layouts::app>
