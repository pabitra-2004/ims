<div>
    <div class="grid grid-cols-2 gap-4 items-center mb-6">
        <div class="flex justify-start items-center gap-4">
            <flux:select wire:model.change.live="quantity" class="w-fit">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="bg-green-200 rounded py-1.5 px-3">
                Selected: <span class="font-semibold">{{ count($selected) }}</span>
            </div>
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

    <div class="flex gap-4 justify-end-safe items-center">
        <flux:button wire:click="actionForAll('delete')">Delete All</flux:button>
        <flux:button wire:click="actionForAll('active')">Active All</flux:button>
        <flux:button wire:click="actionForAll('inactive')">Inactive All</flux:button>
    </div>

    {{-- @dd($categories->implode('id', ', ')) --}}

    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>
                {{-- <flux:checkbox wire:click="select('{{ $categories->implode('id', ', ') }}')" /> --}}

                @php
                    $categoryIds = $categories->pluck('id')->all();
                    $intersect_values = array_intersect($categoryIds, $selected);
                    $checked = count($intersect_values) === count($categoryIds);
                @endphp

                <input type="checkbox" wire:click="select('{{ implode(', ', $categoryIds) }}')"
                    {{ $checked ? 'checked' : '' }} />
                {{ $checked ? 'checked' : 'unchecked' }}

            </flux:table.column>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell class="py-2!" align="center">
                        {{-- <flux:checkbox :value="$category->id" /> --}}

                        <input type="checkbox" value="{{ $category->id }}" wire:model.live='selected'
                            class="input-checkbox-category" />
                    </flux:table.cell>

                    <flux:table.cell class="py-2!" variant="strong">{{ $categories->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <flux:table.cell class="py-2!">
                        <flux:heading class="font-semibold">{{ $category->name }}</flux:heading>
                        <flux:text class="mt-1.5 text-xs">{{ $category->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell class="py-2!">{{ $category->slug }}</flux:table.cell>

                    <flux:table.cell class="py-2!">

                        <label class="inline-flex items-center me-5 cursor-pointer" onclick="event.preventDefault()"
                            wire:swal-confirm="{
                                text: 'Are you sure you want to change the status?',
                                action: 'toggleActiveInactive',
                                params: [{{ $category->id }}],
                            }">
                            <input type="checkbox" value="" class="sr-only peer" @checked($category->is_active)>
                            <div
                                class="relative w-9 h-5 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500 dark:peer-checked:bg-orange-500">
                            </div>
                            <flux:badge color="{{ $category->is_active ? 'green' : 'zinc' }}" size="sm"
                                inset="top bottom" class="w-16 justify-center select-none ms-3">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </label>

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
                                    wire:swal-confirm="{ text: 'Are you sure you want to delete this category?', action: 'deleteCategory', params: [{{ $category->id }}]}">
                                    Delete
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
