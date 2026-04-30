<flux:modal name="create-edit-customer" @close="close" class="md:w-xl">
    <form wire:submit="saveCustomer" class="space-y-6 p-2">

        <div class="space-y-1">
            <flux:heading size="lg" class="font-semibold tracking-wide">
                {{ $customer_id ? 'Update' : 'Create' }} Customer
            </flux:heading>

            <flux:text class="text-gray-400 text-sm">
                Enter details to {{ $customer_id ? 'update the' : 'add a new' }} customer.
            </flux:text>
        </div>

        <flux:input wire:model="name" label="Full Name" placeholder="e.g. Pabitra Das" badge="Required" class="w-full"
            autocomplete="off" />

        <flux:radio.group wire:model="gender" label="Gender" badge="Required">
            <div class="flex gap-6">
                <flux:radio value="male" label="Male" />
                <flux:radio value="female" label="Female" />
                <flux:radio value="others" label="Others" />
            </div>
        </flux:radio.group>

        <div class="grid grid-cols-2 gap-2">
            <flux:input wire:model="mobile" label="Phone" placeholder="Phone number" badge="Required"
                autocomplete="off" />
            <flux:input wire:model="email" label="Email" placeholder="Email" badge="Optional" autocomplete="off" />
        </div>

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="lg">Address</flux:heading>
                <flux:text class="mt-2">Enter the customer's address details.</flux:text>
            </div>

            <flux:select wire:model.live="selected_state" label="State" placeholder="Choose State...">
                @foreach ($states as $state_id => $state_name)
                    <flux:select.option value="{{ $state_id }}">{{ $state_name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model="selected_district" label="District" placeholder="Choose District...">
                @foreach ($districts as $district_id => $district_name)
                    <flux:select.option value="{{ $district_id }}">{{ $district_name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="city" label="City" placeholder="City" badge="Required" />
            <flux:textarea wire:model="address" label="Address" placeholder="Enter address here..." />
            <flux:input type='number' wire:model="pincode" label="Pincode" placeholder="Pincode" badge="Required" />
        </flux:card>

        <flux:separator />

        <div class="flex items-center justify-end gap-4">
            <flux:modal.close>
                <flux:button variant="filled" size="sm">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" size="sm" variant="primary" class="px-6 py-2 font-medium">
                {{ $customer_id ? 'Update' : 'Save' }}
            </flux:button>
        </div>

    </form>
</flux:modal>
