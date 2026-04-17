<div>
    <div class="grid grid-cols-2 gap-4 items-center mb-2">
        <div class="flex justify-start items-center gap-2">
            <flux:select wire:model.change.live="quantity" class="w-fit" size="sm">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:button icon="trash" color="rose" :loading="false" size="sm"
                :disabled="count($selected) === 0"
                wire:swal-confirm="{ 
                        text: 'Are you sure you want to delete this category?', 
                        action: 'actionForAll', 
                        params: [ 'delete' ],
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                        }, 
                    }">
                Delete Selected ({{ count($selected) }})
            </flux:button>

            <flux:button size="sm" :disabled="count($selected) === 0"
                wire:swal-confirm="{
                        title: 'Change Status?',
                        text: 'This action will update the status.',
                        action: 'actionForAll', 
                        params: [ 'active' ],
                        confirmButtonText: 'Toggle', 
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'px-5 py-2 mr-4 rounded-md text-white font-medium bg-green-600 transition duration-200 hover:bg-green-700 active:bg-green-800',
                            cancelButton: 'px-5 py-2 rounded-md font-medium bg-gray-200 text-gray-700 transition duration-200 hover:bg-gray-300 active:bg-gray-400',
                        }
                    }">
                Active All
            </flux:button>

            <flux:button size="sm" :disabled="count($selected) === 0"
                wire:swal-confirm="{
                        title: 'Change Status?',
                        text: 'This action will update the status.',
                        action: 'actionForAll', 
                        params: [ 'inactive' ],
                        confirmButtonText: 'Toggle', 
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'px-5 py-2 mr-4 rounded-md text-white font-medium bg-green-600 transition duration-200 hover:bg-green-700 active:bg-green-800',
                            cancelButton: 'px-5 py-2 rounded-md font-medium bg-gray-200 text-gray-700 transition duration-200 hover:bg-gray-300 active:bg-gray-400',
                        }
                    }">
                Inactive All
            </flux:button>
        </div>
        <div class="flex justify-end-safe items-center gap-2">
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down" size="sm">Filters</flux:button>

                <flux:menu>
                    <flux:menu.checkbox.group wire:model.live="filters">
                        <flux:menu.checkbox value="active">Active
                        </flux:menu.checkbox>
                        <flux:menu.checkbox value="inactive">Inactive
                        </flux:menu.checkbox>
                    </flux:menu.checkbox.group>

                    <flux:menu.separator />
                    <flux:menu.item variant="danger" wire:click="clearFilters">Clear</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:input icon="magnifying-glass" size="sm" wire:model.live.debounce.300ms='search'
                placeholder="Search Categories..." clearable class="max-w-xs" />
        </div>
    </div>

    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>
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
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Last Updated</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell>
                        <label for="checkboxSlideUp"
                            class="flex items-center gap-2 text-sm font-medium text-on-surface dark:text-on-surface-dark has-checked:text-on-surface-strong dark:has-checked:text-on-surface-dark-strong has-disabled:cursor-not-allowed has-disabled:opacity-75">
                            <span class="relative flex items-center">
                                <input id="checkboxSlideUp" type="checkbox"
                                    class="before:content[''] peer relative size-4 appearance-none overflow-hidden rounded-sm border border-outline bg-surface-alt before:absolute before:inset-0 checked:border-primary checked:before:bg-primary focus:outline-outline-strong checked:focus:outline-primary active:outline-offset-0 disabled:cursor-not-allowed dark:border-outline-dark dark:bg-surface-dark-alt dark:checked:border-primary-dark dark:checked:before:bg-primary-dark dark:focus:outline-outline-dark-strong dark:checked:focus:outline-primary-dark"
                                    value="{{ $category->id }}" wire:model.live="selected" />

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="4"
                                    class="pointer-events-none invisible absolute left-1/2 top-1/2 size-3 -translate-x-1/2 -translate-y-1/4 peer-checked:-translate-y-1/2 transition duration-200 text-on-primary peer-checked:visible dark:text-on-primary-dark">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                        </label>
                    </flux:table.cell>

                    <flux:table.cell>{{ $categories->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:heading class="font-semibold">{{ $category->name }}</flux:heading>
                        <flux:text class="mt-1.5 text-xs">{{ $category->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>{{ $category->slug }}</flux:table.cell>

                    <flux:table.cell>
                        <label class="flex items-center select-none cursor-pointer" onclick="event.preventDefault()"
                            wire:swal-confirm="{
                                title: 'Change Status?',
                                text: 'This action will update the status.',
                                action: 'toggleActiveInactive', 
                                params: [{{ $category->id }}],
                                confirmButtonText: 'Toggle', 
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'px-5 py-2 mr-4 rounded-md text-white font-medium bg-green-600 transition duration-200 hover:bg-green-700 active:bg-green-800',
                                    cancelButton: 'px-5 py-2 rounded-md font-medium bg-gray-200 text-gray-700 transition duration-200 hover:bg-gray-300 active:bg-gray-400',
                                }
                            }">
                            <input type="checkbox" value="" class="sr-only peer" @checked($category->is_active)>
                            <div
                                class="relative w-9 h-5 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500 dark:peer-checked:bg-orange-500">
                            </div>
                            <flux:badge color="{{ $category->is_active ? 'green' : 'zinc' }}" size="sm"
                                class="w-16 justify-center ms-2.5">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </label>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-xs truncate">
                            &#128337;
                            {{ $category->updated_at->diffForHumans(['options' => \Carbon\Carbon::JUST_NOW]) }}
                        </flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:button size="xs" icon="pencil-square" variant="primary" color="indigo"
                            :loading="false" tooltip="Edit" class="mr-1.5"
                            wire:click="$dispatch('edit-category', {category: {{ $category->id }} })" />

                        <flux:button size="xs" icon="trash" variant="primary" color="rose"
                            :loading="false" tooltip="Delete"
                            wire:swal-confirm="{ 
                                text: 'Are you sure you want to delete this category?', 
                                action: 'deleteCategory', 
                                params: [ {{ $category->id }} ],
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
