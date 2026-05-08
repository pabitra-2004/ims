{{-- <div>
    @dd($products->toArray());
    <div class="mb-6 w-full">
        <div class="flex items-center justify-between gap-3">
            <div>
                <flux:heading variant="strong" size="lg" class="font-bold">Create Order</flux:heading>
                <flux:text variant="subtle">Manage and create customer orders</flux:text>
            </div>

            <div class="flex gap-3">
                <flux:input icon="magnifying-glass" size="sm" wire:model.live.debounce.350ms="search"
                    placeholder="Search Categories..." clearable
                    class="w-full rounded-xl border-zinc-300" />

                <a href="{{ route('orders.index') }}">
                    <flux:button icon="arrow-long-left" variant="filled" size="sm">
                        Back
                    </flux:button>
                </a>
            </div>
        </div>

        <flux:separator class="mt-5" />
    </div>
    <div>
        <div class="w-full grid grid-cols-5 gap-3">
            @forelse ($products as $product)
                <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700 flex flex-col space-y-3">

                    <a href="#" class="rounded-lg overflow-hidden">
                        <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('default_images.png') }}"
                            alt="{{ $product->name }} image"
                            class="w-full aspect-3/2 object-cover rounded-lg transition duration-300 hover:scale-105" />
                    </a>

                    <div>
                        <h5 class="text-lg text-heading font-semibold tracking-tight">{{ $product->name }}</h5>

                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xl font-extrabold text-heading">$599</span>
                            <flux:button size="xs" variant="primary" icon="shopping-cart">Add to cart</flux:button>
                        </div>
                    </div>
                </flux:card>
            @empty
                <p>no data found</p>
            @endforelse
        </div>
    </div>
</div> --}}









<div>
    <div class="mb-6 w-full">
        <div class="flex items-center justify-between gap-3">
            <div>
                <flux:heading variant="strong" size="lg" class="font-bold">
                    Create Order
                </flux:heading>

                <flux:text variant="subtle">
                    Manage and create customer orders
                </flux:text>
            </div>

            <div class="flex gap-3">
                <flux:input icon="magnifying-glass" size="sm" wire:model.live.debounce.350ms="search"
                    placeholder="Search Products..." clearable class="w-full rounded-xl border-zinc-300" />

                <a href="{{ route('orders.index') }}">
                    <flux:button icon="arrow-long-left" variant="filled" size="sm">
                        Back
                    </flux:button>
                </a>
            </div>
        </div>

        <flux:separator class="mt-5" />
    </div>

    <div class="grid grid-cols-12 gap-6">

        {{-- Products --}}
        <div class="{{ count($cart) > 0 ? 'col-span-8' : 'col-span-12' }}">

            <div class="grid {{ count($cart) > 0 ? 'grid-cols-4' : 'grid-cols-5' }} gap-4">

                @forelse ($products as $product)
                    <flux:card size="sm"
                        class="overflow-hidden p-0! hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">

                        <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('default_images.png') }}"
                            alt="{{ $product->name }}" class="h-40 w-full object-cover" />

                        <div class="p-3 space-y-3">

                            <div>
                                <flux:heading variant="strong" size="lg">
                                    {{ $product->name }}
                                </flux:heading>

                                <flux:text variant="subtle" class="mt-1 line-clamp-2">
                                    {{ $product->description }}
                                </flux:text>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold">
                                    ₹ 500
                                </span>

                                <flux:button size="xs" variant="primary" icon="shopping-cart"
                                    wire:click="addToCart({{ $product->id }})">
                                    Add to cart
                                </flux:button>
                            </div>

                        </div>

                    </flux:card>
                @empty
                    <div class="col-span-full">
                        <p class="text-center text-zinc-500">
                            No products found
                        </p>
                    </div>
                @endforelse

            </div>
        </div>

        @if (count($cart) > 0)
            <div class="col-span-4">

                <div class="sticky top-4 rounded-xl border  shadow-sm">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <flux:heading variant="strong" size="lg">Shopping Cart</flux:heading>
                            <flux:badge>{{ count($cart) }} Items</flux:badge>
                        </div>

                        <flux:button icon="x-mark" variant="subtle" />
                    </div>

                    <div class="max-h-115 --h-100 border overflow-y-auto px-4">
                        @foreach ($cart as $item)
                            <div class="flex gap-3 border-b py-4">
                                <img src="{{ $item['photo'] ?? asset('default_images.png') }}"
                                    class="size-20 rounded-lg object-cover border" alt="{{ $item['name'] }}" />

                                <div class="flex flex-1 flex-col justify-between">

                                    <div class="flex items-start justify-between">
                                        <h4 class="font-medium">
                                            {{ $item['name'] }}
                                        </h4>

                                        <p class="font-semibold">
                                            ₹ 500
                                        </p>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between gap-2">
                                        <div class="flex gap-2 items-center text-gray-300">
                                            Qty:
                                            <flux:button icon="minus" size="xs" />

                                            <span class="text-sm font-medium w-8 text-center">
                                                3
                                            </span>

                                            <flux:button icon="plus" size="xs" />
                                        </div>

                                        <flux:link as="button" variant="ghost"
                                            class="text-blue-400 hover:text-blue-500 cursor-pointer --hover:underline">
                                            Remove</flux:link>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class=" p-4">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex flex-col items-start gap-1">
                                <flux:text>Subtotal</flux:text>
                                <flux:text>Shipping</flux:text>
                                <flux:text>Tax</flux:text>
                                <flux:heading size="sm">Order Total</flux:heading>

                            </div>
                            <div class="flex flex-col items-start gap-1">
                                <flux:text> ₹ 10500</flux:text>
                                <flux:text> ₹ 50</flux:text>
                                <flux:text> ₹ 700</flux:text>
                                <flux:heading size="sm"> ₹ 11250</flux:heading>
                            </div>
                        </div>

                        <flux:button variant="primary" size="sm" class="w-full">Continue Payment</flux:button>
                    </div>

                </div>

            </div>
        @endif

    </div>
</div>
