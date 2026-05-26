<x-layouts::app>

    <div class="flex flex-col gap-4 size-full">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading>Create New Order</flux:heading>
                <flux:text class="mt-1">Search products, add items to cart, and complete the order.</flux:text>
            </div>
            <div class="justify-self-end">
                <flux:button :href="route('orders.index')" icon="arrow-long-left" variant="primary" color="green" wire:navigate>
                    Back
                </flux:button>
            </div>
        </div>

        <flux:separator />

        <livewire:orders.create-order />
        <livewire:products.product-quick-view />
    </div>

</x-layouts::app>
