<div>
    <div class="grid grid-cols-8 gap-6 h-full">
        <div class="col-span-6 space-y-6">
            <flux:card class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Products</h2>

                    <flux:modal.trigger name="add-custom-item">
                        <flux:button variant="ghost" icon="plus" class="text-indigo-600! font-semibold!">Add Custom Item
                        </flux:button>
                    </flux:modal.trigger>
                </div>

                <flux:input.group>
                    <flux:input placeholder="Search..." icon="magnifying-glass" kbd="⌘K" size="sm" />
                    <flux:button size="sm">Browse</flux:button>
                </flux:input.group>

                <div class="space-y-4 divide-y divide-neutral-300 divide-dashed">
                    @foreach ($selected_products as $index => $product)
                        <div class="flex gap-4 pb-4 last:pb-0">
                            @isset($product['image'])
                                <img src="{{ asset('storage/' . $product['image']) }}"
                                    class="aspect-square w-20 rounded-xs shadow-sm">
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

                                    <flux:button type="button" wire:click="removeProduct({{ $index }})"
                                        icon="x-mark" size="xs" variant="subtle">Remove</flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- </div> --}}
                    {{-- <div class="space-y-4 divide-y divide-neutral-300 divide-dashed"> --}}
                    @foreach ($custom_items as $index => $item)
                        <div class="flex gap-4 pb-4 last:pb-0">
                            <img src="{{ asset('default_images.png') }}"
                                class="aspect-square w-22 rounded-xs shadow-sm">

                            <div class="flex-1 inline-flex flex-col space-y-1">
                                <div class="flex-1 inline-flex justify-between gap-4">
                                    <p class="text-sm font-medium line-clamp-2">{{ $item['name'] }}</p>
                                    <span class="tabular-nums text-base font-medium flex-none text-nowrap">&#8377;
                                        {{ number_format($item['price']) }}</span>
                                </div>
                                <div class="flex justify-between items-center gap-2">
                                    <label class="text-sm font-medium text-gray-500 mr-2 inline-flex items-center">
                                        Qty:
                                        <input type="number" min='1'
                                            x-on:input="$el.value = $el.value.replace(/^0+/, '1')"
                                            x-on:keydown="if(['-', '+', 'e', 'E', '.'].includes($event.key)) $event.preventDefault()"
                                            wire:model.live="custom_items.{{ $index }}.qty"
                                            class="max-w-15 w-full px-2 border-none focus:outline-none" />
                                    </label>

                                    <flux:button type="button" wire:click="removeItem({{ $index }})"
                                        icon="x-mark" size="xs" variant="subtle">
                                        Remove
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </flux:card>

            <flux:card>
                <div class="space-y-3">
                    <flux:heading size="lg" variant="strong">Order Summery</flux:heading>

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
                            {{ $this->subTotal }}
                        </flux:heading>
                    </div>

                </div>
            </flux:card>
        </div>

        {{-- column 2 --}}
        <div class="col-span-2 space-y-6">
            <flux:card class="space-y-4">
                <flux:input mask="9999999999" label="Phone Number" wire:model.enter.live='phone' badge="Required" />
                <flux:input label="Name" wire:model='name' badge="Required" />
                <flux:input label="Email" wire:model='email' badge="Optional" />
                <flux:select label="Gender" wire:model='gender' badge="Required">
                    <flux:select.option value="male">Male</flux:select.option>
                    <flux:select.option value="female">Female</flux:select.option>
                </flux:select>
            </flux:card>

            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Billing Address</flux:heading>
                    <flux:text class="mt-2">Enter the customer's address details.</flux:text>
                </div>

                <flux:select wire:model.live="selected_state" label="State" badge="Required"
                    placeholder="Choose State...">
                    @foreach ($states as $state_id => $state_name)
                        <flux:select.option value="{{ $state_id }}">{{ $state_name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="selected_district" label="District" badge="Required"
                    placeholder="Choose District...">
                    @foreach ($districts as $district_id => $district_name)
                        <flux:select.option value="{{ $district_id ?? 0 }}">{{ $district_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="city" label="City" placeholder="City" badge="Required" />
                <flux:input type='number' wire:model="pincode" label="Pincode" placeholder="Pincode"
                    badge="Required" />
                <flux:textarea wire:model="address" label="Address" placeholder="Enter address here..." />
            </flux:card>
        </div>
    </div>

    <flux:button class="w-full" variant="primary" wire:click="placeOrder">Place Order</flux:button>

    <flux:modal name="add-custom-item" class="md:w-96 mt-30!">
        <form class="space-y-6" wire:submit="addCustomItem">
            <div>
                <flux:heading size="lg">Add Custom Item</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:input label="Name" placeholder="Name" wire:model='custom_item_name' />
            <flux:input label="Price" placeholder="Price" wire:model='custom_item_price' mask="9999" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
