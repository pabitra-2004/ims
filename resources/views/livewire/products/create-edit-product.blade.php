@use('Illuminate\Support\Facades\Storage')
<flux:modal name="create-edit-product" flyout position="bottom" variant="floating" @close="close"
    class="relative p-4 border sm:p-6 rounded-t-3xl bg-white/95 dark:bg-zinc-900/95 text-zinc-800 dark:text-zinc-100 backdrop-blur-xl border-zinc-200/60 dark:border-zinc-700/60">
    <div
        class="absolute left-1/2 top-1.5 h-1.5 w-20 sm:w-28 -translate-x-1/2 rounded-full bg-zinc-300/80 shadow-lg dark:bg-zinc-600/80">
    </div>

    <form wire:submit="saveProduct" class="space-y-6 select-none " autocomplete="off">
        <div>
            <flux:heading class="text-lg sm:text-xl">{{ $product_id ? 'Update' : 'Create' }} Product</flux:heading>
            <flux:text class="mt-1.5 text-zinc-500 dark:text-zinc-400">Enter details to
                {{ $product_id ? 'update the' : 'add a new' }} product.
            </flux:text>
        </div>

        <div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-12">

            <div class="lg:col-span-4">
                <div
                    class="p-4 bg-white border shadow-sm border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-xl">
                    <flux:heading size="lg" variant="strong">Product Images
                        <flux:badge size="sm" class="ml-1">Optional</flux:badge>
                    </flux:heading>

                    <div class="w-full mt-4">
                        <flux:input type="file" id="product-images" wire:model="images" multiple class="hidden" />

                        @if (empty($existing_images) && empty($images))
                            <div>
                                <label for="product-images"
                                    class="flex flex-col items-center justify-center gap-3 p-4 transition-all border rounded-lg shadow-sm cursor-pointer sm:p-6 border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-800/80 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700/80 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-12">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" />
                                    </svg>

                                    <div>
                                        <flux:heading class="tracking-wide">Drop files here or click to browse
                                        </flux:heading>
                                        <flux:text class="mt-2 tracking-wide">JPG, PNG, GIF up to 2MB</flux:text>
                                    </div>
                                </label>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                                @foreach ($existing_images as $index => $image)
                                    <div
                                        class="relative w-24 h-24 overflow-hidden transition-all duration-300 ease-in-out bg-white border rounded-lg shadow-sm dark:bg-zinc-800 aspect-square group hover:scale-105 border-zinc-300 dark:border-zinc-700">
                                        <img src="{{ Storage::url($image) }}" class="object-cover size-full">

                                        <div
                                            class="absolute inset-0 flex items-center justify-center transition duration-200 opacity-0 bg-black/50 group-hover:opacity-100">
                                            <flux:button wire:click="removeImage({{ $index }})" icon="trash"
                                                loading="false" variant="primary" color="rose" size="sm"
                                                class="cursor-pointer" />
                                        </div>
                                    </div>
                                @endforeach


                                @foreach ($images ?? [] as $index => $image)
                                    <div
                                        class="relative w-24 h-24 overflow-hidden transition-all duration-300 ease-in-out bg-white border rounded-lg shadow-sm dark:bg-zinc-800 aspect-square group hover:scale-105 border-zinc-300 dark:border-zinc-700">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                            class="object-cover size-full">

                                        <div
                                            class="absolute inset-0 flex items-center justify-center transition duration-200 opacity-0 bg-black/50 group-hover:opacity-100">
                                            <flux:button wire:click="removeNewImage({{ $index }})" icon="trash"
                                                loading="false" variant="primary" color="rose" size="sm"
                                                class="cursor-pointer" />
                                        </div>
                                    </div>
                                @endforeach

                                <label for="product-images"
                                    class="flex flex-wrap items-center justify-center w-24 h-24 transition-all duration-300 ease-in-out border rounded-lg cursor-pointer hover:scale-105 group border-zinc-300 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700">
                                    <flux:avatar icon="plus" circle
                                        class="p-4 transition group-hover:scale-105 bg-zinc-200 dark:bg-zinc-600" />

                                </label>
                            </div>
                        @endif
                        <flux:error name="images" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 ">
                <div
                    class="p-4 space-y-6 bg-white border shadow-sm sm:p-6 rounded-xl border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 ">
                        <flux:input type="text" wire:model="code" label="Code" badge="Required"
                            placeholder="Product code (e.g., FMA26483)" required />
                        <flux:input type="text" wire:model.blur.live="name" label="Name" badge="Required"
                            placeholder="Product name" autocomplete="off" required />
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <flux:input type="text" wire:model="slug" label="Slug" badge="Required"
                            placeholder="slug (e.g., water-bottle)" required />

                        <flux:select wire:model="category_id" label="Category" badge="Required">
                            <flux:select.option value="">Choose category...</flux:select.option>

                            @foreach ($categories as $id => $name)
                                <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <flux:input type="number" wire:model="price" label="Price" badge="Required"
                            placeholder="Enter product price" required />

                        <flux:input disabled label="Disabled" placeholder="Disabled" />
                    </div>

                    <flux:textarea wire:model="description" label="Description" placeholder="Enter description here..."
                        badge="Optional" />
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-zinc-300 dark:border-zinc-700">
            <flux:button type="submit" variant="primary" class="w-full px-6 transition-all duration-300 sm:w-auto">
                Save
                Product</flux:button>
        </div>


    </form>
</flux:modal>
