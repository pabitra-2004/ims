<div class="border-box">
    <div class="w-full grid grid-cols-2 gap-4 items-center mb-2">
        <div class="flex justify-start items-center gap-2">
            <flux:select wire:model.change.live="quantity" class="w-fit --hover:text-white" size="sm">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex justify-end-safe items-center">
            <flux:input icon="magnifying-glass" size="sm" wire:model.live.debounce.300ms='search'
                placeholder="Search Customer..." clearable class="max-w-xs" />
        </div>
    </div>

    <flux:table :paginate="$customers" class="w-full table-fixed">
        <flux:table.columns>
            <flux:table.column class="w-[5%]">#</flux:table.column>
            <flux:table.column class="w-[27%]">Name</flux:table.column>
            <flux:table.column class="w-[22%]">Email</flux:table.column>
            <flux:table.column class="w-[14%]">Phone</flux:table.column>
            <flux:table.column class="w-[9%]">Gender</flux:table.column>
            <flux:table.column class="w-[15%]">Last Updated</flux:table.column>
            <flux:table.column class="w-[7%] pr-0 text">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows class="text-xs">
            @forelse ($customers as $customer)
                <flux:table.row :key="$customer->id">
                    <flux:table.cell class="w-[5%]">
                        {{ $customers->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[27%]">
                        <div class="capitalize truncate w-full flex items-center gap-4">
                            <flux:avatar size="xl"
                                src="{{ $customer->photo ? asset('storage/' . $customer->photo) : asset('default_images.png') }}"
                                alt="{{ $customer->name }}" />
                            {{ $customer->name }}
                        </div>
                    </flux:table.cell>

                    <flux:table.cell class="w-[22%] truncate">
                        {{ $customer->email }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[14%]">
                        {{ $customer->mobile }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[9%] capitalize">
                        {{ $customer->gender }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[15%]">
                        <flux:text class="text-xs truncate w-full">
                            &#128337;
                            {{ $customer->updated_at->diffForHumans(['options' => \Carbon\Carbon::JUST_NOW]) }}
                        </flux:text>
                    </flux:table.cell>

                    <flux:table.cell class="w-[7%] pr-0">
                        <flux:button size="xs" icon="pencil-square" variant="primary" color="indigo"
                            :loading="false" tooltip="Edit" class="mr-1.5"
                            wire:click="$dispatch('edit-customer', {customer: {{ $customer->id }} })" />

                        <flux:button size="xs" icon="trash" variant="primary" color="rose"
                            :loading="false" tooltip="Delete"
                            wire:swal-confirm="{ 
                                text: 'Are you sure you want to delete this customer?', 
                                action: 'deleteCustomer', 
                                params: [ {{ $customer->id }} ],
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                                }, 
                            }" />
                    </flux:table.cell>

                </flux:table.row>
            @empty
                <!-- Empty State -->
                <flux:table.row>
                    <flux:table.cell colspan="8" class="text-center py-12 text-red-500">
                        No data found
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

</div>
