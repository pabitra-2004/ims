<div class="overflow-hidden">
    <flux:modal name="create-edit-product" flyout position="bottom" variant="floating" @close="close"
        class="backdrop:backdrop-blur-sm rounded-t-3xl relative overflow-y-auto">

        <div class="w-1/5 rounded-full h-2 shadow bg-black absolute top-2 left-1/2 -translate-x-1/2"></div>

        <form wire:submit="saveProduct" class="space-y-6 select-none" autocomplete="off">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ $product_id ? 'Update' : 'Create' }} Product</flux:heading>
                    <flux:text class="mt-2">Enter details to {{ $product_id ? 'update the' : 'add a new' }} product.
                    </flux:text>
                </div>
                <div class="flex w-full gap-10">

                    <div class="w-96">
                        <label class="relative border-0 p-0 bg-transparent" label="Upload files">
                            <input type="file" wire:model='photo' wire:ignore="" dclass="sr-only" tabindex="-1"
                                style="position: absolute; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border: 0px;">

                            <div class="w-full aspect-4/5 overflow-hidden flex flex-col items-center justify-center rounded-lg border-dashed border-zinc-200 dark:border-white/10 border-2 bg-zinc-50 dark:bg-white/10 transition-colors in-data-dragging:bg-zinc-100 in-data-dragging:border-zinc-300 dark:in-data-dragging:bg-white/15 dark:in-data-dragging:border-white/20 [[disabled]_&amp;]:opacity-75 [[disabled]_&amp;]:pointer-events-none"
                                tabindex="0">

                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="object-cover flex-1" alt="Preview">
                                @else
                                    <div class="flex flex-col items-center gap-2 py-5 px-6 sm:py-10 sm:px-16">
                                        <svg class="mb-4 shrink-0 [:where(&amp;)]:size-6 text-zinc-400 dark:text-white/60 transition [[disabled]:hover_&amp;]:text-zinc-400 dark:[[disabled]:hover_&amp;]:text-white/60 in-data-dragging:text-zinc-800 dark:in-data-dragging:text-white [[data-flux-file-upload-trigger]:hover_&amp;]:text-zinc-800 dark:[[data-flux-file-upload-trigger]:hover_&amp;]:text-white in-data-loading:opacity-0"
                                            data-flux-icon="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd"
                                                d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z"
                                                clip-rule="evenodd"></path>
                                        </svg>

                                        <div
                                            class="text-sm font-medium text-zinc-800 dark:text-white cursor-default [[disabled]_&amp;]:opacity-75">
                                            Drop files here or click to browse
                                        </div>

                                        <div class="relative text-zinc-500 dark:text-white/60 cursor-default text-sm">
                                            JPG, PNG, GIF up to 10MB
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </label>
                    </div>

                    <div class="flex-1 space-y-6">
                        <flux:input type="text" wire:model="code" label="Code"
                            placeholder="Product code (e.g., 1FM2A3)" />
                        <flux:input type="text" wire:model.blur.live="name" label="Name" placeholder="Product name"
                            autocomplete="off" />

                        <flux:input type="text" wire:model="slug" label="Slug"
                            placeholder="slug (e.g., water-bottle)" />

                        <flux:select wire:model="category_id" label="Category">
                            <flux:select.option>Choose Category...</flux:select.option>
                            @foreach ($categories as $index => $category)
                                <flux:select.option value="{{ $index }}">{{ $category }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:textarea wire:model="description" label="Description"
                            placeholder="Enter description here..." badge="Optional" />
                    </div>
                </div>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary" class="px-6">
                        Save Product
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
