<x-layouts::app>
    <div class="select-none">
        <div class="mb-2 ">
            <div class="grid items-center grid-cols-2 gap-4">
                <div>
                    <flux:heading size="lg" level="2">Products</flux:heading>
                    <flux:text class="mt-1 text-sm">Here you can manage your products</flux:text>
                </div>

                {{-- actions --}}
                <div class="justify-self-end">
                    <flux:modal.trigger name="create-edit-product">
                        <flux:button variant="primary" size="sm" color="indigo" icon="plus">Add Products</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:separator variant="subtle" class="my-2" />
        </div>

        <livewire:products.create-edit-product />
        <livewire:products.product-list />
    </div>
</x-layouts::app>
