<x-layouts::app>
    <div class="select-none">
        <div class="mb-2 ">
            <div class="grid grid-cols-2 gap-4 items-center">
                <div>
                    <flux:heading size="lg" level="2">Categories</flux:heading>
                    <flux:text class="mt-1 text-sm">Here you can manage your product categories</flux:text>
                </div>

                {{-- actions --}}
                <div class="justify-self-end">
                    <flux:modal.trigger name="create-edit-category">
                        <flux:button variant="primary" color="indigo" icon="plus" size="sm">Add Category</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:separator variant="subtle" class="my-2" />
        </div>

        <livewire:categories.create-edit-category />
        <livewire:categories.category-list />
    </div>
</x-layouts::app>
