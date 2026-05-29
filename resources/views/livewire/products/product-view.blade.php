<div>
    <div class="select-none box-border">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">
                    Product Details
                </flux:heading>

                <flux:text class="mt-1 text-sm">
                    Here you can manage your products
                </flux:text>
            </div>
        </div>

        <flux:separator class="mt-2 mb-4" />

        <div class="grid grid-cols-2 gap-4">
            <div class="flex gap-2 border border-gray-300 rounded-xl p-3">

                <div class="flex flex-col gap-2 h-96 overflow-auto p-1">
                    @foreach (array_slice($product->images ?? [], 1) as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                            class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-80 outline-1 outline-gray-400 outline-offset-2">
                    @endforeach

                    @if (empty($product->images))
                        <img src="{{ asset('default_images.png') }}" class="w-20 h-20 object-cover rounded-lg border">
                    @endif
                </div>

                <div class="flex-1">
                    <img src="{{ asset('storage/' . ($product->images[0] ?? 'default_images.png')) }}"
                        class="w-full h-96 object-cover  rounded-lg shadow-sm" alt="{{ $product->name }}">
                </div>
            </div>

            <div class="flex flex-col gap-4 --border border-gray-300 rounded-xl pl-4">
                <div>
                    <flux:heading size="xl">
                        {{ $product->name }}
                    </flux:heading>

                    <flux:text class="mt-2 text-justify">
                        {{ $product->description }}
                    </flux:text>
                </div>

                <div class=" mt-2">
                    <div>
                        <flux:heading size="xl" variant="strong">
                            ₹{{ number_format($product->price, 2) }}
                        </flux:heading>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
