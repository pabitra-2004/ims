<div>
    <div class="grid grid-cols-2 gap-4 items-center mb-6">
        <div>
            <flux:select wire:model.change.live="quantity" class="w-fit">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div class="flex justify-end-safe items-center gap-4">
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">Filters</flux:button>

                <flux:menu>
                    <flux:menu.checkbox.group wire:model.live="filters">
                        <flux:menu.checkbox keep-open value="active">Active
                        </flux:menu.checkbox>
                        <flux:menu.checkbox keep-open value="inactive">Inactive
                        </flux:menu.checkbox>
                    </flux:menu.checkbox.group>

                    <flux:menu.separator />
                    <flux:menu.item variant="danger" wire:click="clearFilters">Clear</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms='search'
                placeholder="Search Categories..." clearable class="max-w-xs" />
        </div>
    </div>

    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell class="py-2!" variant="strong">{{ $categories->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <flux:table.cell class="py-2!">
                        <flux:heading class="font-semibold">{{ $category->name }}</flux:heading>
                        <flux:text class="mt-1.5 text-xs">{{ $category->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell class="py-2!">{{ $category->slug }}</flux:table.cell>

                    <flux:table.cell class="py-2!">
                        <flux:field variant="inline" wire:click="toggleActiveInactive({{ $category->id }})">
                            <flux:switch :checked="$category->is_active" />
                            <flux:label>
                                @if ($category->is_active)
                                    <flux:badge color="green" size="sm" inset="top bottom"
                                        class="w-16 justify-center">
                                        Active
                                    </flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm" inset="top bottom"
                                        class="w-16 justify-center">Inactive</flux:badge>
                                @endif
                            </flux:label>
                        </flux:field>
                    </flux:table.cell>

                    <flux:table.cell class="py-2!" align="center">
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>

                            <flux:menu>
                                <flux:menu.item icon="pencil-square"
                                    wire:click="$dispatch('edit-category', '{{ $category->id }}')">Edit
                                </flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger"
                                    wire:click="deleteCategory({{ $category->id }})"
                                    wire:confirm="Are you sure you want to delete this category?">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>

                    </flux:table.cell>

                    <flux:table.cell class="py-2!" align="center">
                        <flux:text class="mt-1.5 text-xs"> &#128337; {{ $category->updated_at->diffForHumans() }}
                        </flux:text>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
