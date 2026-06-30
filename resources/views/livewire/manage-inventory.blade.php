@use('Illuminate\Support\Facades\Storage')

<div>
    <div class="grid items-center w-full grid-cols-2 gap-4 mb-2">
        <!-- Per Page -->
        <div class="flex items-center gap-3 w-fit">
            <flux:select size="sm" wire:model.change.live="perPage">
                @foreach ([5, 10, 15, 20, 50] as $item)
                    <flux:select.option :value="$item">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:button color="rose" icon="trash" size="sm" :disabled="count($selected) === 0" wire:click="deleteSelected">
                Delete Selected ({{ count($selected) }})
            </flux:button>
        </div>

        <!-- Filters + search -->
        <div class="flex flex-wrap items-center justify-end gap-2">

            <!-- Search -->
            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="search" size="sm"
                placeholder="Search by name and code" clearable class="max-w-xs" title="Search by name, code" />


            <!-- Filter Dropdown -->
            <flux:dropdown>
                <flux:button icon="funnel" size="sm" icon:trailing="chevron-down">Filter</flux:button>

                <flux:menu>
                    <!-- Status Filter -->
                    <flux:menu.submenu heading="Status">
                        <flux:menu.checkbox.group wire:model.live="filters.status">
                            <flux:menu.checkbox value="in_stock">In Stock</flux:menu.checkbox>
                            <flux:menu.checkbox value="low_stock">Low Stock</flux:menu.checkbox>
                            <flux:menu.checkbox value="out_of_stock">Out of Stock</flux:menu.checkbox>
                        </flux:menu.checkbox.group>

                        <flux:menu.separator />

                        <flux:menu.item variant="danger" wire:click="clearFilters('status')">
                            Clear
                        </flux:menu.item>
                    </flux:menu.submenu>

                    <flux:menu.separator />

                    <flux:menu.item variant="danger" wire:click="clearFilters">
                        Reset Filters
                    </flux:menu.item>

                </flux:menu>
            </flux:dropdown>

        </div>
    </div>

    <flux:table :paginate="$products">
        <flux:table.columns sticky class="bg-transparent">
            <flux:table.column class="pl-2">
                <label for="checkboxSlideAll"
                    class="flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:cursor-not-allowed has-disabled:opacity-75">
                    <span class="relative flex items-center">
                        <input id="checkboxSlideAll" type="checkbox"
                            class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline bg-surface-alt before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark"
                            wire:model.live="selectAll" />

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                            stroke="currentColor" fill="none" stroke-width="4"
                            class="absolute invisible transition duration-200 -translate-x-1/2 pointer-events-none left-1/2 top-1/2 size-3 -translate-y-1/4 peer-checked:-translate-y-1/2 text-on-primary peer-checked:visible dark:text-on-primary-dark">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                </label>
            </flux:table.column>
            <flux:table.column>Product</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column align="center">Stock</flux:table.column>
        </flux:table.columns>
        
        <flux:table.rows>
            @forelse ($products as $product)
                <flux:table.row :key="$product->id">
                    <flux:table.cell>
                        <label for="checkboxSlideUp"
                            class="flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:cursor-not-allowed has-disabled:opacity-75">
                            <span class="relative flex items-center">
                                <input id="checkboxSlideUp" type="checkbox"
                                    class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline bg-surface-alt before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark"
                                    value="{{ $product->id }}" wire:model.live="selected" />

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="4"
                                    class="absolute invisible transition duration-200 -translate-x-1/2 pointer-events-none left-1/2 top-1/2 size-3 -translate-y-1/4 peer-checked:-translate-y-1/2 text-on-primary peer-checked:visible dark:text-on-primary-dark">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                        </label>
                    </flux:table.cell>

                    <flux:table.cell class="flex items-center gap-3 ">
                        <flux:avatar size="xl"
                            src="{{ $product->images ? Storage::url($product->images[0]) : asset('default_images.png') }}"
                            alt="{{ $product->name }} image" />
                        <div class="flex flex-col">
                            <flux:heading>{{ $product->name }}</flux:heading>
                            <flux:text class="max-w-xs truncate max-sm:hidden">[ {{ $product->code }} ]</flux:text>
                        </div>
                    </flux:table.cell>


                    <flux:table.cell>
                        <flux:badge size="sm" class="max-w-32">
                            <span class="truncate">{{ $product->category->name }}</span>
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if ($product->inventory?->quantity)
                            @if ($product->inventory->quantity > 10)
                                <flux:badge size="sm" color="green">In Stock</flux:badge>
                            @elseif ($product->inventory->quantity > 0)
                                <flux:badge size="sm" color="yellow">Low Stock</flux:badge>
                            @endif
                        @else
                            <flux:badge size="sm" color="rose">Out of Stock</flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell align="center">
                        <div class="flex justify-center">
                            <flux:button icon="minus" size="xs" wire:click="decrement({{ $product->id }})"
                                :disabled='!$product->inventory?->quantity' />

                            <span
                                class="w-16 text-lg font-medium tracking-wider text-center text-current select-none tabular-nums">
                                {{ $product->inventory?->quantity ?? 0 }}
                            </span>

                            <flux:button icon="plus" size="xs" wire:click="increment({{ $product->id }})" />
                        </div>
                    </flux:table.cell>

                </flux:table.row>
            @empty
                <!-- Empty State -->
                <flux:table.row>
                    <flux:table.cell colspan="12">
                        <div class="flex flex-col items-center justify-center flex-1 gap-4 h-105">
                            <img src="{{ asset('no_data_found.png') }}" alt="" class="size-16">
                            <div class="text-center">
                                <flux:heading size="xl" variant="subtle">Oops!</flux:heading>
                                <flux:text size="lg">No data found</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

</div>
