<div>
    <!-- Learn as if you were to live forever. - Mahatma Gandhi -->

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

                        <flux:button icon="trash" size="xs" variant="primary" color="rose"
                            wire:click="removeProduct({{ $index }})" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
