<div>

    <flux:modal name="create-category" class="md:w-xl">
        <form wire:submit='saveCategory' class="space-y-6">
            <div>
                <flux:heading size="lg">Create Catergory</flux:heading>
                <flux:text class="mt-2">Enter details to add a new category.</flux:text>
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
