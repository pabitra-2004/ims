<flux:modal name="update-stock" flyout position="bottom" variant="floating"
    class="w-full max-w-4xl mx-auto flex flex-col gap-5 
           rounded-t-3xl bg-white shadow-2xl 
           backdrop:backdrop-blur-md p-5">
    <div class="w-1/10 h-1.5 bg-gray-400 rounded-full absolute top-1.5 left-1/2 -translate-x-1/2"></div>

    <!-- Content -->
    <div class="grid grid-cols-2 gap-4 max-h-120 overflow-y-auto m-3">

        <!-- Search -->
        <div class="p-4 border border-gray-500 shadow-2xl rounded-xl space-y-3">
            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="search_product"
                placeholder="Search by product name or code..." clearable title="Search by name, code" class="w-full" />

            <ul class="space-y-2 max-h-96 overflow-y-auto bg-zing-200">
                @foreach ($products as $_product)
                    <li class="bg-gray-200/20 rounded-lg">
                        <flux:button variant="ghost" size="sm" wire:click="selectProduct({{ $_product->id }})"
                            class="w-full justify-start hover:bg-gray-300">
                            {{ $_product->name }}
                        </flux:button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Product Details -->
        <div class="p-4 border border-gray-500 rounded-xl space-y-3">

            @if ($product?->photo)
                <div class="flex justify-center">
                    <flux:avatar size="xl" src="{{ asset('storage/' . $product->photo) }}" class="shadow-md" />
                </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <flux:input readonly variant="filled" label="Code" :value="$product?->code" />
                <flux:input readonly variant="filled" label="Name" :value="$product?->name" />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <flux:input readonly variant="filled" label="Slug" :value="$product?->slug" />
                <flux:input readonly variant="filled" label="Category" :value="$product?->category->name" />
            </div>

            <flux:input readonly variant="filled" label="Description" :value="$product?->description"
                class="min-h-12!" />
            <flux:separator />
            <div>
                <flux:input type="text" wire:model.live.debounce.350ms="quantity" label="Quantity" />
            </div>
        </div>
    </div>


    <div class="flex justify-end gap-3 pt-3 border-t">
        <flux:modal.close>
            <flux:button variant="ghost">Cancel</flux:button>
        </flux:modal.close>

        <flux:button wire:click="save" variant="filled" class="bg-black text-white hover:bg-gray-800">
            Save
        </flux:button>
    </div>

</flux:modal>
