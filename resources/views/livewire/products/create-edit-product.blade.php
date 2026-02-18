<div>
    <flux:modal name="create-edit-product"  @close="close"  class="md:w-xl">
        <form wire:submit="saveProduct" class="space-y-6">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ $product_id ?'Update' : 'Create' }} Product</flux:heading>
                    <flux:text class="mt-2">Enter details to {{ $product_id ? 'update the' : 'add a new' }} product.</flux:text>
                </div>

                <flux:input type="text" wire:model="code" label="Code" placeholder="Product code"
                    description="eg: FMP-EMO-2026-305" />
                <flux:input type="text" wire:model.blur.live="name" label="Name" placeholder="Product name" />

                <flux:input type="text" wire:model="slug" label="Slug" placeholder="Slug" badge="Optional"
                    description="eg: water-bottle" />

                <flux:textarea wire:model="description" label="Description" placeholder="Enter description here..."
                    badge="Optional" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">{{ $product_id ?'Save changes' : 'Add product' }}</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
