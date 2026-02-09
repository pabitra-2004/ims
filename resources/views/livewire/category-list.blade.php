<div>
    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell variant="strong">{{ $categories->firstItem() + $loop->index }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:heading class="font-semibold">{{ $category->name }}</flux:heading>
                        <flux:text class="mt-1.5 text-xs">{{ $category->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell>{{ $category->slug }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:field variant="inline" wire:click="toggleActiveInactive({{ $category->id }})">
                            <flux:switch :checked="$category->is_active" />
                            <flux:label>
                                @if ($category->is_active)
                                    <flux:badge color="green" size="sm" inset="top bottom"
                                        class="w-16 justify-center">
                                        Active
                                    </flux:badge>
                                @else
                                    <flux:badge color="zinc" size="sm" inset="top bottom"
                                        class="w-16 justify-center">Inactive</flux:badge>
                                @endif
                            </flux:label>
                        </flux:field>
                    </flux:table.cell>

                    <flux:table.cell align="center">
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>

                            <flux:menu>
                                <flux:menu.item icon="pencil-square"
                                    wire:click="$dispatch('edit-category', '{{ $category->id }}')">Edit
                                </flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger"
                                    wire:click="deleteCategory({{ $category->id }})"
                                    wire:confirm="Are you sure you want to delete this category?">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>

                        <flux:text class="mt-1.5 text-xs"> &#128337; {{ $category->updated_at->diffForHumans() }}
                        </flux:text>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
