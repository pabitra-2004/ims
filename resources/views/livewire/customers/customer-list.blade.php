<div class="border-box">
    <div class="w-full grid grid-cols-2 gap-4 items-center mb-2">
        <div class="flex justify-start items-center gap-2">
            <flux:select wire:model.change.live="quantity" class="w-fit hover:text-white" size="sm">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:button icon="trash" variant="primary" color="rose" :loading="false" size="sm"
                :disabled="count($selected) === 0"
                wire:swal-confirm="{ 
                        text: 'Are you sure you want to delete this customer?', 
                        action: 'deleteSelected', 
                        params: [  ],
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                        }, 
                    }">
                Delete Selected ({{ count($selected) }})
            </flux:button>
        </div>
    </div>

    <flux:table :paginate="$customers" class="w-full table-fixed">
        <flux:table.columns>
            <flux:table.column class="w-[2%]">
                <label for="checkboxSlideAll"
                    class="flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:cursor-not-allowed has-disabled:opacity-75">
                    <span class="relative flex items-center">
                        <input id="checkboxSlideAll" type="checkbox"
                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline bg-surface-alt before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark"
                            wire:model.live="selectAll" />

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                            stroke="currentColor" fill="none" stroke-width="4"
                            class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/4 peer-checked:-translate-y-1/2 transition duration-200 text-on-primary peer-checked:visible dark:text-on-primary-dark">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                </label>
            </flux:table.column>
            <flux:table.column class="w-[15%]">Name</flux:table.column>
            <flux:table.column class="w-[7%]">Gender</flux:table.column>
            <flux:table.column class="w-[9%]">Phone</flux:table.column>
            <flux:table.column class="w-[20%]">Email</flux:table.column>
            <flux:table.column class="w-[30%]">Address</flux:table.column>
            <flux:table.column class="w-[10%]">Last Updated</flux:table.column>
            <flux:table.column class="w-[7%] pr-0 text">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows class="text-xs">
            @forelse ($customers as $customer)
                <flux:table.row :key="$customer->id">
                    <flux:table.cell class="w-[2%]">
                        <label for="checkboxSlideUp"
                            class="flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:cursor-not-allowed has-disabled:opacity-75">
                            <span class="relative flex items-center">
                                <input id="checkboxSlideUp" type="checkbox"
                                    class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline bg-surface-alt before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark"
                                    value="{{ $customer->id }}" wire:model.live="selected" />

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="4"
                                    class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/4 peer-checked:-translate-y-1/2 transition duration-200 text-on-primary peer-checked:visible dark:text-on-primary-dark">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                        </label>
                    </flux:table.cell>

                    <flux:table.cell class="w-[15%]">
                        <div class="capitalize truncate w-full">{{ $customer->name }}</div>
                    </flux:table.cell>

                    <flux:table.cell class="w-[7%] capitalize">
                        {{ $customer->gender }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[9%]">
                        {{ $customer->mobile }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[20%] truncate">
                        {{ $customer->email }}
                    </flux:table.cell>

                    <flux:table.cell class="w-[30%]">
                        <div class="truncate w-full">
                            {{ $customer->addresses()->first()?->address }}
                        </div>
                    </flux:table.cell>

                    <flux:table.cell class="w-[10%]">
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
