<x-layouts::app>

    <div class="mb-6">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">Products</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can manage your products</flux:text>
            </div>

            {{-- actions --}}
            <div class="justify-self-end">
                <flux:modal.trigger name="create-edit-product">
                    <flux:button variant="primary" color="indigo" icon="plus">Add Products</flux:button>
                </flux:modal.trigger>
            </div>
        </div>
        <flux:separator variant="subtle" class="mt-4" />
    </div>
    

    <livewire:products.create-edit-product />

    <livewire:products.product-list />
    

</x-layouts::app>
