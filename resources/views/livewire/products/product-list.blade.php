<div>
    <div class="grid grid-cols-2 items-center gap-4 mb-4">
        <div class="w-fit">
            <flux:select wire:model.change.live="quantity">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex items-center justify-end-safe gap-4 ">
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">Filter</flux:button>

                <flux:menu>
                    <flux:menu.submenu heading="Status">
                        <flux:menu.checkbox.group wire:model.live="filters.status">
                            <flux:menu.checkbox keep-open value="active">Active</flux:menu.checkbox>
                            <flux:menu.checkbox keep-open value="inactive">Inactive</flux:menu.checkbox>
                        </flux:menu.checkbox.group>
                        <flux:menu.separator />
                        <flux:menu.item variant="danger" wire:click="clearFilters('status')">Clear</flux:menu.item>
                    </flux:menu.submenu>

                    <flux:menu.submenu heading="Category">
                        <flux:menu.checkbox.group wire:model.live="filters.categories">
                            @foreach ($categories as $index => $category)
                                <flux:menu.checkbox keep-open value="{{ $index }}">{{ $category }}
                                </flux:menu.checkbox>
                            @endforeach
                        </flux:menu.checkbox.group>

                        <flux:menu.separator />
                        <flux:menu.checkbox wire:click="clearFilters('categories')">Clear</flux:menu.checkbox>
                    </flux:menu.submenu>

                    <flux:menu.separator />
                    <flux:menu.item variant="danger" wire:click="clearFilters">Reset Filters</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="search" placeholder="Search Products..."
                clearable class="max-w-xs" title="Search by name, code, slug" />
        </div>
    </div>

    <flux:table :paginate="$products">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Code</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection"
                wire:click="sort('updated_at')">Last Updated</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($products as $product)
                <flux:table.row :key="$product->id">
                    <flux:table.cell variant="strong">{{ $products->firstItem() + $loop->index }}</flux:table.cell>

                    <flux:table.cell>{{ $product->code }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:heading level="3">{{ $product->name }}</flux:heading>
                        <flux:text class="mt-1" variant="subtle">{{ $product->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text>{{ $product->slug }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text>{{ $product->category->name }}</flux:text>
                    </flux:table.cell>


                    <flux:table.cell>
                        <flux:field variant="inline" wire:click="toggleActiveInactive({{ $product->id }})">
                            <flux:switch :checked="$product->is_active" />
                            <flux:label>
                                @if ($product->is_active)
                                    <flux:badge color="green" size="sm" class="w-15 items-center justify-center">
                                        Active</flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm" class="w-15 items-center justify-center">
                                        Inactive</flux:badge>
                                @endif
                            </flux:label>
                        </flux:field>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="mt-1.5 text-xs"> &#128337; {{ $product->updated_at->diffForHumans() }}
                        </flux:text>
                    </flux:table.cell>

                    <flux:table.cell align="center">
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>

                            <flux:menu>

                                <flux:menu.item wire:click="$dispatch('edit-product', '{{ $product->id }}' )"
                                    icon="pencil-square">Edit</flux:menu.item>

                                <flux:menu.item icon="trash" variant="danger"
                                    wire:click="deleteProduct({{ $product->id }})"
                                    wire:confirm="Are you sure you want to delete this product?">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                    <!-- ... -->
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
