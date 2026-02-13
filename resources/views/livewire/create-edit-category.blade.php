<flux:modal name="create-edit-category" @close="close" class="md:w-xl">
    <form wire:submit='saveCategory' class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $category_id ? 'Update' : 'Create' }} Catergory</flux:heading>
            <flux:text class="mt-2">Enter details to {{ $category_id ? 'update the' : 'add a new' }} category.
            </flux:text>
        </div>

        <flux:input wire:model.blur.live='name' label="Name" placeholder="Category Name" badge="Required" required />

        <flux:input wire:model='slug' label="Slug" placeholder="Slug" badge="Required" required
            description="eg: water-bottle" />

        <flux:textarea wire:model='description' label="Description" placeholder="Enter description here."
            badge="Optional" />


        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </div>
    </form>
</flux:modal>
