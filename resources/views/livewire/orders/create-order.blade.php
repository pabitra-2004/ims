<div class="grid grid-cols-14 gap-6 flex-1 -mb-4 select-none">
    <div class="h-full flex flex-col rounded-2xl col-span-10 p-6 space-y-4 bg-white shadow-lg">
        <div>
            <flux:heading>Products</flux:heading>
        </div>

        <div class="flex gap-4">
            <flux:dropdown>
                <flux:button icon="funnel" icon:trailing="chevron-down">Category</flux:button>

                <flux:menu>
                    <flux:menu.checkbox.group wire:model.live="filter.categories">
                        @foreach ($categories as $category)
                            <flux:menu.checkbox class="text-wrap" :value="$category['id']">
                                {{ $category['name'] }}
                            </flux:menu.checkbox>
                        @endforeach
                    </flux:menu.checkbox.group>
                    <flux:menu.separator />
                    <flux:menu.item variant="danger" wire:click="clearFilters">Clear</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:input icon="magnifying-glass" placeholder="Search products" wire:model.live='search' />
        </div>

        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden overflow-y-auto scrollbar-thin scroll-smooth">
                <div class="grid grid-cols-6 gap-6">
                    @forelse ($this->products as $product)
                        <div class="space-y-2 border rounded overflow-hidden">
                            <button type="button" class="contents" wire:click="quickViewProduct({{ $product->id }})">
                                @isset($product->images[0])
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        class="aspect-square cursor-pointer">
                                @else
                                    <img src="{{ asset('default_images.png') }}"
                                        class="aspect-square object-cover cursor-pointer" title="No image avaliable">
                                @endisset
                            </button>

                            <div class="space-y-2 p-2">
                                <div class="h-10">
                                    <p class="text-xs font-medium line-clamp-2">{{ $product->name }}</p>
                                </div>
                                <flux:badge size='sm'>{{ $product->category->name }}</flux:badge>

                                <div class="flex justify-between items-center">
                                    <span class="tabular-nums text-sm font-medium">&#8377;
                                        {{ number_format($product->price) }}</span>

                                    <flux:button size="xs" icon="shopping-cart" variant="primary" color="indigo"
                                        wire:click="addToCart('{{ $product->id }}')" class="cursor-pointer">Add
                                    </flux:button>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="absolute inset-0 --bg-red-600 flex flex-col items-center justify-center gap-4">
                            <img src="{{ asset('no_data_found.png') }}" alt="" class="size-16">
                            <div class="text-center">
                                <flux:heading size="xl" variant="subtle">Oops!</flux:heading>
                                <flux:text size="lg">No data found</flux:text>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="h-full flex flex-col rounded-2xl col-span-4 p-6 space-y-4 bg-white shadow-lg">
        <div>
            <flux:heading>Selected Items</flux:heading>
        </div>

        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden overflow-y-auto --mr-5 scrollbar-thin scrollbar-gutter-stable">
                <div class="divide-y divide-neutral-300 pr-3">
                    @foreach ($selected_products as $index => $product)
                        <div class="py-5 flex gap-4">
                            @isset($product['image'])
                                <img src="{{ asset('storage/' . $product['image']) }}"
                                    class="aspect-square w-22 rounded-xs shadow-sm">
                            @else
                                <img src="{{ asset('default_images.png') }}"
                                    class="aspect-square w-22 rounded-xs shadow-sm">
                            @endisset

                            <div class="flex-1 inline-flex flex-col space-y-1">
                                <div class="flex-1 inline-flex justify-between gap-4">
                                    <p class="text-sm font-medium line-clamp-2">{{ $product['name'] }}</p>
                                    <span class="tabular-nums text-base font-medium flex-none text-nowrap">&#8377;
                                        {{ number_format($product['price']) }}</span>
                                </div>
                                <div class="flex-none">
                                    <flux:badge size='sm'>{{ $product['category'] }}</flux:badge>
                                </div>
                                <div class="flex justify-between items-center gap-2">
                                    <label class="text-sm font-medium text-gray-500 mr-2 inline-flex items-center">
                                        Qty:
                                        <input type="number" min='1'
                                            x-on:input="$el.value = $el.value.replace(/^0+/, '1')"
                                            x-on:keydown="if(['-', '+', 'e', 'E', '.'].includes($event.key)) $event.preventDefault()"
                                            wire:model.live="selected_products.{{ $index }}.qty"
                                            class="max-w-15 w-full px-2 border-none focus:outline-none" />
                                    </label>

                                    <flux:button icon="trash" size="xs" variant="primary" color="rose"
                                        wire:click="removeProduct({{ $index }})" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full">
            <flux:button variant="primary" color="blue" class="w-full" wire:click="checkout">Checkout</flux:button>
        </div>
    </div>
</div>
