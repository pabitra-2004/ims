<flux:modal name="quick-view" flyout variant="floating" position="bottom" class="w-7xl">
    @if ($this->product)
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

            <div class="flex flex-row gap-10">
                <div class="shrink-0 flex flex-row gap-3 p-3 h-100">
                    <div class="shrink-0 w-24 inline-flex flex-col gap-2 overflow-hidden overflow-y-auto p-2">
                        @foreach ($product->images as $index => $image)
                            <img src="{{ asset('storage/' . $image) }}"
                                class="size-20 object-cover rounded-lg cursor-pointer {{ $index != $previewImageIndex ?: 'ring-2 ring-offset-2 ring-cyan-500' }}"
                                wire:click="$set('previewImage', '{{ $image }}'); $set('previewImageIndex', '{{ $index }}');">
                        @endforeach
                    </div>
                    <img src="{{ asset('storage/' . $this->previewImage) }}"
                        class="w-full h-auto aspect-square object-cover rounded-lg shadow-sm" loading='lazy'>
                </div>

                <div class="grow flex flex-col gap-4 rounded-xl pl-4">
                    <div class="flex justify-between gap-4">
                        <flux:heading size="xl">
                            {{ $this->product?->name }}
                        </flux:heading>

                        @if ($this->product->is_active)
                            <flux:badge color="emerald" variant="filled">
                                <div class="size-1.5 rounded-full bg-green-400 mr-1.5"></div>Active
                            </flux:badge>
                        @else
                            <flux:badge color="pink" variant="filled">Inactive</flux:badge>
                        @endif
                    </div>
                    <div class="flex items-center divide-x divide-neutral-300">

                        <div class="flex-1 px-4 py-3">
                            <span>Last Updated</span>
                            <p class="mt-1 text-sm font-semibold">
                                {{ optional($this->product->category->updated_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="flex-1 px-4 py-3">
                            <span>Category</span>
                            <p class="mt-1 text-sm font-semibold ">
                                {{ $this->product->category->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="flex-1 px-4 py-3">
                            <span>Price</span>
                            <p class="mt-1 text-lg font-bold">
                                ₹{{ number_format($this->product->price) }}
                            </p>
                        </div>

                    </div>
                    <flux:text class="mt-2 text-justify">
                        {{ $this->product?->description }}
                    </flux:text>
                </div>
            </div>
        </div>
    @endif
</flux:modal>
