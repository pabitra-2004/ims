<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-1 rounded-xl select-none  text-xs">
        <div class="">
            <div class="grid grid-cols-2 gap-4 items-center">
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
