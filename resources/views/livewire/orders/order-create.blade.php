<div class="grid grid-cols-14 gap-6 flex-1">
    <div class="h-full flex flex-col rounded-2xl col-span-10 p-6 space-y-4 bg-zinc-300/20 shadow">
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
            <div class="absolute inset-0 overflow-hidden overflow-y-auto -mr-5">

                <div class="grid grid-cols-4 gap-6 pr-1">

                    @foreach ($this->products as $product)
                        <div class="space-y-2 border rounded overflow-hidden">
                            <flux:modal.trigger name="view-product" wire:click="viewProduct({{ $product->id }})">
                                @isset($product->images[0])
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        class="aspect-square cursor-pointer">
                                @else
                                    <img src="{{ asset('default_images.png') }}"
                                        class="aspect-square object-cover cursor-pointer" title="No image avaliable">
                                @endisset
                            </flux:modal.trigger>

                            <div class="space-y-2 p-2">
                                <div class="h-10">
                                    <p class="text-sm font-medium line-clamp-2">{{ $product->name }}</p>
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
                    @endforeach


                    <flux:modal name="view-product" flyout variant="floating" position="bottom" class="w-7xl">
                        @if ($this->view_product)
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">
                                        Product Details
                                    </flux:heading>

                                    <flux:text class="mt-1 text-sm">
                                        Here you can manage your products
                                    </flux:text>
                                </div>

                                <flux:separator />
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex gap-2 border border-gray-300 rounded-xl p-3">
                                        <div class="flex flex-col gap-2 h-96 overflow-auto p-1">

                                            @forelse(array_slice($this->view_product->images ?? [], 1) as $image)
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    class="w-20 h-20 object-cover rounded-lg cursor-pointer">
                                            @empty
                                                <img src="{{ asset('default_images.png') }}"
                                                    class="w-20 h-20 object-cover rounded-lg border">
                                            @endforelse
                                        </div>

                                        <div class="flex-1">
                                            <img src="{{ !empty($this->view_product->images[0])
                                                ? asset('storage/' . $this->view_product->images[0])
                                                : asset('default_images.png') }}"
                                                class="w-full h-96 object-cover rounded-lg shadow-sm">
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-4 rounded-xl pl-4">
                                        <div class="flex justify-between gap-4">
                                            <flux:heading size="xl">
                                                {{ $this->view_product?->name }}
                                            </flux:heading>

                                            @if ($this->view_product->is_active)
                                                <flux:badge color="emerald" variant="filled">
                                                    <div class="size-1.5 rounded-full bg-green-400 mr-1.5"></div>Active
                                                </flux:badge>
                                            @else
                                                <flux:badge color="pink" variant="filled">Inactive</flux:badge>
                                            @endif
                                        </div>
                                        {{-- <div class="flex divide-x  divide-neutral-300 justify-between">
                                            <span>
                                                Last Updated
                                                {{ $this->view_product->category->updated_at->format('d M Y, h:i A') ?? 'N/A' }}
                                            </span>
                                            <span>
                                                Category
                                                {{ $this->view_product->category->name ?? 'N/A' }}
                                            </span>
                                            <span>
                                                Price
                                                ₹{{ number_format($this->view_product->price) }}

                                            </span>
                                        </div> --}}
                                        <div class="flex items-center divide-x divide-neutral-300">

                                            <div class="flex-1 px-4 py-3">
                                                <span>Last Updated</span>
                                                <p class="mt-1 text-sm font-semibold">
                                                    {{ optional($this->view_product->category->updated_at)->format('d M Y, h:i A') ?? 'N/A' }}
                                                </p>
                                            </div>

                                            <div class="flex-1 px-4 py-3">
                                                <span>Category</span>
                                                <p class="mt-1 text-sm font-semibold ">
                                                    {{ $this->view_product->category->name ?? 'N/A' }}
                                                </p>
                                            </div>

                                            <div class="flex-1 px-4 py-3">
                                                <span>Price</span>
                                                <p class="mt-1 text-lg font-bold">
                                                    ₹{{ number_format($this->view_product->price) }}
                                                </p>
                                            </div>

                                        </div>
                                        <flux:text class="mt-2 text-justify">
                                            {{ $this->view_product?->description }}
                                        </flux:text>

                                        <div>
                                            <flux:button variant="primary"
                                                wire:click="addToCart({{ $this->view_product?->id }})">
                                                Add To Cart
                                            </flux:button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endif
                    </flux:modal>
                </div>
            </div>
        </div>
    </div>

    <div class="h-full flex flex-col rounded-2xl col-span-4 p-6 space-y-4 bg-zinc-300/20 shadow">
        <div>
            <flux:heading>Order summary</flux:heading>
        </div>

        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden overflow-y-auto -mr-5 ">
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
                                <div>
                                    <label class="text-sm font-medium text-gray-500 mr-2 inline-flex items-center">
                                        Qty:
                                        <input type="number" min='1'
                                            x-on:input="$el.value = $el.value.replace(/^0+/, '1')"
                                            x-on:keydown="if(['-', '+', 'e', 'E', '.'].includes($event.key)) $event.preventDefault()"
                                            wire:model.live="selected_products.{{ $index }}.qty"
                                            class="max-w-15 w-full px-2 border-none focus:outline-none" />
                                    </label>
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
