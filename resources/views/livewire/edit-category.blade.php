<div>

    <flux:modal name="edit-category" @close="close" class="md:w-xl">
        <form wire:submit='updateCategory' class="space-y-6">
            <div>
                <flux:heading size="lg">Update Category</flux:heading>
                <flux:text class="mt-2">Enter details to update the category.</flux:text>
            </div>

            <flux:input wire:model.blur.live='name' label="Name" placeholder="Category Name" badge="Required" required />

            <flux:input wire:model='slug' label="Slug" placeholder="Slug" badge="Optional"
                description="eg: water-bottle" />

            <flux:textarea wire:model='description' label="Description" placeholder="Enter description here."
                badge="Optional" />


            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
