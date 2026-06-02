{{-- <div>
    <flux:heading>Confirm order</flux:heading>
    <flux:text size="lg" variant="subtle">Please review the order details before confirming.</flux:text>

    <div class="divide-y divide-neutral-300 pr-3">
        @foreach ($selected_products as $index => $product)
            <div class="py-5 flex gap-4">
                @isset($product['image'])
                    <img src="{{ asset('storage/' . $product['image']) }}" class="aspect-square w-22 rounded-xs shadow-sm">
                @else
                    <img src="{{ asset('default_images.png') }}" class="aspect-square w-22 rounded-xs shadow-sm">
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
                            <input type="number" min='1' x-on:input="$el.value = $el.value.replace(/^0+/, '1')"
                                x-on:keydown="if(['-', '+', 'e', 'E', '.'].includes($event.key)) $event.preventDefault()"
                                wire:model.live="selected_products.{{ $index }}.qty"
                                class="max-w-15 w-full px-2 border-none focus:outline-none" />
                        </label>

                        <flux:button type="button" wire:click="removeProduct({{ $index }})" icon="x-mark" size="xs" variant="subtle">Remove</flux:button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        <flux:button type="button" wire:click="placeOrder">Place Order</flux:button>
    </div>
</div>  --}}



<div class="grid grid-cols-12 gap-6 flex-1 select-none h-full">
    <div class="flex-1 relative col-span-8 ">
        <div class="absolute inset-0 overflow-hidden overflow-y-auto scroll-thin">
            <div class="grid grid-cols-1 pr-1 gap-2 ">
                @foreach ($selected_products as $index => $product)
                    <div class="flex gap-4 p-4 bg-white shadow-sm border border-gray-300 rounded-2xl">
                        @isset($product['image'])
                            <img src="{{ asset('storage/' . $product['image']) }}"
                                class="aspect-square w-22 rounded-xs shadow-sm">
                        @else
                            <img src="{{ asset('default_images.png') }}" class="aspect-square w-22 rounded-xs shadow-sm">
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

                                <flux:button type="button" wire:click="removeProduct({{ $index }})"
                                    icon="x-mark" size="xs" variant="subtle">Remove</flux:button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="h-full flex flex-col rounded-2xl col-span-4 p-6 space-y-4 bg-white shadow-lg">
        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden --overflow-y-auto">
                <div class="pr-3">
                    <div class="space-y-3">
                        <flux:heading size="lg" variant="strong">Order Details</flux:heading>

                        <div class="space-y-2.5">
                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Order date</flux:heading>
                                <flux:text>{{ now() }}</flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Email</flux:heading>
                                <flux:text>nb cnb</flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Phone</flux:heading>
                                <flux:text>cbcnbcn</flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Payment</flux:heading>
                                <flux:text>Credit Card</flux:text>
                            </div>

                            <div class="flex justify-between gap-4">
                                <flux:heading class="text-gray-500">Shipping address</flux:heading>

                                <flux:text class="text-wrap">West Bengal, India</flux:text>
                            </div>
                        </div>
                    </div>

                    <flux:separator class="my-3" />

                    <div class="space-y-3">
                        <flux:heading size="lg" variant="strong">Order Amount</flux:heading>

                        <div class="space-y-2.5">
                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Original price</flux:heading>
                                <flux:text>
                                    &#8377;
                                    6,592.00
                                </flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Savings</flux:heading>
                                <flux:text>
                                    &#8377;
                                    299.00
                                </flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Store Pickup</flux:heading>
                                <flux:text>
                                    &#8377;
                                    99
                                </flux:text>
                            </div>

                            <div class="flex justify-between">
                                <flux:heading class="text-gray-500">Tax</flux:heading>
                                <flux:text>
                                    &#8377;
                                    799
                                </flux:text>
                            </div>
                        </div>


                        <flux:separator class="my-3" />

                        <div class="flex justify-between">
                            <flux:heading size="lg" variant="strong">Total</flux:heading>

                            <flux:heading size="lg" variant="strong">
                                &#8377;
                                {{ $this->subTotal}}
                            </flux:heading>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <flux:button variant="primary" color="blue" class="w-full" wire:click="placeOrder">Place order
            </flux:button>
        </div>
    </div>
</div>
