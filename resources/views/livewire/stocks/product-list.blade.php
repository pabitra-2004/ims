<div>
    {{-- @dd($products); --}}

    <div class="w-full grid grid-cols-2 items-center gap-4 mb-4">

        <!-- Per Page -->
        <div class="w-fit">
            <flux:select wire:model.change.live="quantity">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option :value="$item">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <!-- Filters + search -->
        <div class="flex flex-wrap items-center justify-end gap-4">

            <!-- Search -->
            <flux:input icon="magnifying-glass" {{-- wire:model.live.debounce.350ms="search" --}} placeholder="Search anything here..." clearable
                class="max-w-xs" title="Search by name, code" />


            <!-- Filter Dropdown -->
            <flux:dropdown>
                <flux:button icon="funnel" icon:trailing="chevron-down">Filter</flux:button>

                <flux:menu>
                    <!-- Status Filter -->
                    <flux:menu.submenu heading="Status">
                        <flux:menu.checkbox.group {{-- wire:model.live="filters.status" --}}>
                            <flux:menu.checkbox value="active">Active</flux:menu.checkbox>
                            <flux:menu.checkbox value="inactive">Inactive</flux:menu.checkbox>
                        </flux:menu.checkbox.group>

                        <flux:menu.separator />

                        <flux:menu.item variant="danger" {{-- wire:click="clearFilters('status')" --}}>
                            Clear
                        </flux:menu.item>
                    </flux:menu.submenu>

                    <flux:menu.separator />

                    <flux:menu.item variant="danger" wire:click="#">
                        Reset Filters
                    </flux:menu.item>

                </flux:menu>
            </flux:dropdown>

        </div>
    </div>

    <flux:button color="rose" icon="trash" :disabled="count($selected) === 0" wire:click="deleteSelected">
        Delete Selected ({{ count($selected) }})
    </flux:button>

    <flux:table :paginate="$products">

        <flux:table.columns sticky class="bg-transparent">
            <flux:table.column sticky class="bg-transparent">
                <input type="checkbox" wire:model.live="selectAll">
            </flux:table.column>
            <flux:table.column sticky class="bg-transparent">#</flux:table.column>
            <flux:table.column>Product</flux:table.column>
            <flux:table.column>Product Code</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Stock</flux:table.column>
            <flux:table.column>Reserved</flux:table.column>
            <flux:table.column>Available</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($products as $product)
                <flux:table.row :key="$product->id">
                    <flux:table.cell>
                        <input type="checkbox" value="{{ $product->id }}" wire:model.live="selected">
                    </flux:table.cell>

                    <flux:table.cell>{{ $products->firstItem() + $loop->index }}</flux:table.cell>

                    <flux:table.cell class="flex items-center gap-3 ">
                        <flux:avatar size="sm" circle src="https://unavatar.io/x/calebporzio" />
                        <div class="flex flex-col">
                            <flux:heading>{{ $product->name }}</flux:heading>
                            <flux:text class="max-sm:hidden truncate max-w-xs">{{ $product->description }}</flux:text>
                        </div>
                    </flux:table.cell>

                    <flux:table.cell>#{{ $product->code }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:badge size="sm" class="max-w-32">
                            <span class="truncate">{{ $product->category->name }}</span>
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        @if ($product->stock?->quantity > 10)
                            <flux:badge size="sm" color="green">In Stock</flux:badge>
                        @elseif ($product->stock?->quantity > 0)
                            <flux:badge size="sm" color="yellow">Low stock</flux:badge>
                        @else
                            <flux:badge size="sm" color="rose">Out of stock</flux:badge>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $product->stock?->quantity ?? 0 }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $product->stock->reserved ?? 0 }}
                        {{-- <div x-data="{ count: 0 }" x-modelable="count" {{ $attributes }}>
                            <button x-on:click="count--">-</button>

                            <span x-text="count"></span>

                            <button x-on:click="count++">+</button>
                        </div> --}}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{-- {{ $product->stock?->quantity ? ($product->stock->quantity - $product->stock->reserved) : 0 }} --}}
                        {{ $product->stock?->quantity ? $product->stock->quantity - $product->stock->reserved : 0 }}
                    </flux:table.cell>

                    <!-- Action buttons -->
                    <flux:table.cell>

                        {{-- <flux:button :loading="false" size="xs" icon="pencil-square" variant="primary"
                            color="indigo" class="mr-1.5" tooltip="Edit"
                            wire:click="$dispatch('edit-inventory', {product: {{ $product->id }} })" /> --}}

                        <flux:button size="xs" icon="trash" variant="primary" color="rose" loading="true"
                            tooltip="Delete"
                            wire:swal-confirm="{ 
                                text: 'You want to delete this product?', 
                                action: 'deleteInventory', 
                                params: [ {{ $product->id }} ],
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                                } 
                            }" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
