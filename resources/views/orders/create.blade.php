<x-layouts::app>

    <div class="flex flex-col gap-4 size-full">
        <div>
            <flux:heading>Create New Order</flux:heading>
            <flux:text class="mt-1">Search products, add items to cart, and complete the order.</flux:text>
        </div>

        <flux:separator />

        <livewire:orders.order-create />
        <livewire:products.product-quick-view />
    </div>

</x-layouts::app>
