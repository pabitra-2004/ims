<div class="grid grid-cols-14 gap-8 flex-1">
    <div class="h-full flex flex-col rounded-2xl col-span-10 p-6 space-y-6 bg-white shadow">
        <div>
            <flux:heading>Products</flux:heading>
        </div>

        <flux:input icon="magnifying-glass" placeholder="Search products" wire:model.live='search' />

        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden overflow-y-auto">

                <div class="grid grid-cols-4 gap-10 pr-2">

                    @foreach ($this->products as $product)
                        <div class="space-y-2 border rounded overflow-hidden"
                            wire:click="addToCart('{{ $product->id }}')">
                            @isset($product->images[0])
                                <img src="{{ asset('storage/' . $product->images[0]) }}" class="aspect-square">
                            @endisset

                            <div class="space-y-2 p-2">
                                <div class="h-10">
                                    <p class="text-sm font-medium line-clamp-2">{{ $product->name }}</p>
                                </div>
                                <flux:badge size='sm'>{{ $product->category->name }}</flux:badge>

                                <div>
                                    <span class="tabular-nums text-sm font-medium">&#8377;
                                        {{ number_format($product->price) }}</span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
    <div class="h-full flex flex-col rounded-2xl col-span-4 p-6 space-y-6 bg-white shadow">
        <div>
            <flux:heading>Order summary</flux:heading>
        </div>

        <div class="flex-1 relative">
            <div class="absolute inset-0 overflow-hidden overflow-y-auto">
                <div class="divide-y divide-neutral-300 pr-2">
                    @foreach ($selected_products as $index => $product)
                        <div class="py-5 flex gap-4">
                            <img src="{{ asset('storage/' . $product['image']) }}"
                                class="aspect-square w-22 rounded-xs shadow-sm">
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
    </div>
</div>
