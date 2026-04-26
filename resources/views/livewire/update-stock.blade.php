<flux:modal name="update-stock" flyout position="bottom" variant="floating"
    class="w-full max-w-4xl mx-auto flex flex-col gap-5 
           rounded-t-3xl bg-white shadow-2xl 
           backdrop:backdrop-blur-md p-5"
    @close="close">
    <div class="w-1/10 h-1.5 bg-gray-400 rounded-full absolute top-1.5 left-1/2 -translate-x-1/2"></div>

    <!-- Content -->
    <div class="grid grid-cols-2 gap-4 max-h-120 overflow-y-auto m-3">

        <!-- Search -->
        <div class="p-4 border border-gray-500 shadow-2xl rounded-xl space-y-3">
            <flux:input icon="magnifying-glass" wire:model.live.debounce.350ms="search_product"
                placeholder="Search by product name or code..." clearable title="Search by name, code" class="w-full" />

            @if ($search_product)
                <ul class="space-y-2 max-h-96 overflow-y-auto bg-zing-200">
                    @foreach ($products as $product)
                        <li class="bg-gray-200/20 rounded-lg">
                            <flux:button variant="ghost" size="sm" wire:click="selectProduct({{ $product->id }})"
                                class="w-full justify-start hover:bg-gray-300">
                                {{ $product->name }}
                            </flux:button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Product Details -->
        <div class="p-4 border border-gray-500 rounded-xl space-y-3">

            @if ($existing_photo)
                <div class="flex justify-center">
                    <flux:avatar size="xl" src="{{ asset('storage/' . $existing_photo) }}" class="shadow-md" />
                </div>
            @endif

            <div class="grid grid-cols-2 gap-3">
                <flux:input type="text" wire:model="code" label="Code" disabled />
                <flux:input type="text" wire:model="name" label="Name" disabled />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <flux:input type="text" wire:model="slug" label="Slug" disabled />
    
                <flux:select wire:model="category_id" label="Category" disabled>
                    @foreach ($categories as $category)
                        <flux:select.option value="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:textarea wire:model="description" label="Description" disabled class="min-h-12!" />
            <flux:separator />
            <div>
                <flux:input type="text" wire:model.live.debounce.350ms="quantity" label="Quantity"  />
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
