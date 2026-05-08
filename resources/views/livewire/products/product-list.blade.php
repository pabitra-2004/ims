<div class="w-full box-border select-none">

    <div class="w-full grid grid-cols-2 items-center gap-4 mb-4">

        <!-- Per Page -->
        <div class="w-fit">
            <flux:select wire:model.change.live="quantity">
                @foreach ([5, 10, 15, 20] as $item)
                    <flux:select.option :value="$item">{{ $item }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <!-- Filters + Search -->
        <div class="flex flex-wrap items-center justify-end gap-4">

            <!-- Filter Dropdown -->
            <flux:dropdown>
                <flux:button icon="funnel" icon:trailing="chevron-down">Filter by</flux:button>

                <flux:menu>
                    <!-- Status Filter -->
                    <flux:menu.submenu heading="Status">
                        <flux:menu.checkbox.group wire:model.live="filters.status">
                            <flux:menu.checkbox value="active">Active</flux:menu.checkbox>
                            <flux:menu.checkbox value="inactive">Inactive</flux:menu.checkbox>
                        </flux:menu.checkbox.group>

                        <flux:menu.separator />

                        <flux:menu.item variant="danger" wire:click="clearFilters('status')">
                            Clear
                        </flux:menu.item>
                    </flux:menu.submenu>

                    <!-- Category Filter -->
                    <flux:menu.submenu heading="Category">

                        <div class="w-64">
                            <!-- Search Category -->
                            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="searchCategories"
                                placeholder="Search Categories..." clearable class="max-w-xs"
                                title="Search categories" />

                            <!-- Category List -->
                            <div class="max-h-60 overflow-y-auto scrollbar-modern scrollbar-thin-1 my-1 pr-1">
                                <flux:menu.checkbox.group wire:model.live="filters.categories">
                                    @foreach ($categories as $category)
                                        <flux:menu.checkbox keep-open class="text-wrap" :value="$category['id']">
                                            {{ $category['name'] }}
                                        </flux:menu.checkbox>
                                    @endforeach
                                </flux:menu.checkbox.group>
                            </div>

                            <flux:menu.separator />

                            <flux:menu.item wire:click="clearFilters('categories')">
                                Clear
                            </flux:menu.item>

                        </div>
                    </flux:menu.submenu>

                    <flux:menu.separator />

                    <flux:menu.item variant="danger" wire:click="clearFilters">
                        Reset Filters
                    </flux:menu.item>

                </flux:menu>
            </flux:dropdown>

            <!-- Search -->
            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="search" placeholder="Search Products..."
                clearable class="max-w-xs" title="Search by name, code, slug" />

        </div>
    </div>


    <!-- Products Table -->
    <flux:table :paginate="$products" class="table-fixed w-full">

        <!-- Table Columns -->
        <flux:table.columns>

            <flux:table.column class="w-[2%]">#</flux:table.column>

            <flux:table.column class="w-[7%]">
                Code
            </flux:table.column>

            <flux:table.column class="w-[35%]" sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                wire:click="sort('name')">
                Name
            </flux:table.column>

            <flux:table.column class="w-[12%]">
                Slug
            </flux:table.column>

            <flux:table.column class="w-[10%]">
                Category
            </flux:table.column>

            <flux:table.column class="w-[10%]">
                Status
            </flux:table.column>

            <flux:table.column class="w-[10%] pr-0" sortable :sorted="$sortBy === 'updated_at'"
                :direction="$sortDirection" wire:click="sort('updated_at')">
                Last Updated
            </flux:table.column>

            <flux:table.column class="w-[6%]">
                Actions
            </flux:table.column>
        </flux:table.columns>

        <!-- Table Rows -->
        <flux:table.rows>

            @forelse ($products as $product)
                <flux:table.row :key="$product->id">
                    <!-- Serial -->
                    <flux:table.cell variant="strong">
                        {{ $products->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <!-- Code -->
                    <flux:table.cell>
                        {{ $product->code }}
                    </flux:table.cell>

                    <!-- product photo, name, description -->
                    <flux:table.cell class="flex items-center gap-3 ">
                        <flux:avatar size="xl"
                            src="{{ $product->images ? asset('storage/' . $product->images[0]) : asset('default_images.png') }}"
                            alt="{{ $product->name }}" />
                        <div class="truncate">
                            <flux:heading level="3">
                                {{ $product->name }}
                            </flux:heading>
                            <flux:text variant="subtle" class="mt-1">
                                <div class="truncate">
                                    {{ $product->description }}
                                </div>
                            </flux:text>
                        </div>
                    </flux:table.cell>


                    <!-- Slug -->
                    <flux:table.cell class="truncate">
                        {{ $product->slug }}
                    </flux:table.cell>

                    <!-- Category -->
                    <flux:table.cell class="truncate">
                        {{ $product->category->name }}
                    </flux:table.cell>

                    <!-- Status -->
                    <flux:table.cell class="py-2!">
                        <label class="inline-flex items-center me-5 cursor-pointer" onclick="event.preventDefault()"
                            wire:swal-confirm="{
                                title: 'Change Status?',
                                text: 'This action will update the status.',
                                action: 'toggleActiveInactive', 
                                params: [{{ $product->id }}],
                                confirmButtonText: 'Toggle', 
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'px-5 py-2 mr-4 rounded-md text-white font-medium bg-green-600 transition duration-200 hover:bg-green-700 active:bg-green-800',
                                    cancelButton: 'px-5 py-2 rounded-md font-medium bg-gray-200 text-gray-700 transition duration-200 hover:bg-gray-300 active:bg-gray-400',
                                }
                            }">
                            <input type="checkbox" value="" class="sr-only peer" @checked($product->is_active)>
                            <div
                                class="relative w-9 h-5 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-500 dark:peer-checked:bg-blue-500">
                            </div>
                            <flux:badge color="{{ $product->is_active ? 'green' : 'zinc' }}" size="sm"
                                class="w-16 justify-center select-none ms-2">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </label>
                    </flux:table.cell>

                    <!-- Updated -->
                    <flux:table.cell>
                        <flux:text class="text-xs mt-1.5 truncate">
                            &#128337;
                            {{ $product->updated_at->diffForHumans(['options' => \Carbon\Carbon::JUST_NOW]) }}
                        </flux:text>
                    </flux:table.cell>

                    <!-- Actions -->
                    <flux:table.cell>

                        <flux:button :loading="false" size="xs" icon="pencil-square" variant="primary"
                            color="indigo" class="mr-1.5" tooltip="Edit"
                            wire:click="$dispatch('edit-product', {product: {{ $product->id }} })" />

                        <flux:button size="xs" icon="trash" variant="primary" color="rose" loading="true"
                            tooltip="Delete"
                            wire:swal-confirm="{ 
                                text: 'Are you sure you want to delete this post?', 
                                action: 'deleteProduct', 
                                params: [ {{ $product->id }} ],
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                                } 
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
