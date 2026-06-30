<x-layouts::app :title="__('Dashboard')">
    <div class="select-none">
        <div class="mb-2">
            <div class="grid items-center grid-cols-2 gap-4">
                <div>
                    <flux:heading size="lg" level="2">Customers</flux:heading>
                    <flux:text class="mt-1 text-sm">Here you can manage your customers</flux:text>
                </div>

                {{-- actions --}}
                <div class="justify-self-end">
                    <flux:modal.trigger name="create-edit-customer">
                        <flux:button variant="primary" color="indigo" icon="plus" size="sm">Add Customer
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
            <flux:separator variant="subtle" class="my-2" />
        </div>

        <livewire:customers.customer-list />
        <livewire:customers.create-edit-customer />
    </div>
</x-layouts::app>
