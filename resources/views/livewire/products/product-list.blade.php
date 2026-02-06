<div>
    <flux:table :paginate="$products">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Code</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column align="center">Actions</flux:table.column>

            <!-- ... -->
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($products as $product)
                <flux:table.row :key="$product->id">
                    <flux:table.cell variant="strong">{{ $products->firstItem() + $loop->index }}</flux:table.cell>

                    <flux:table.cell>{{ $product->code }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:heading level="3">{{ $product->name }}</flux:heading>
                        <flux:text class="mt-1" variant="subtle">{{ $product->description }}</flux:text>
                    </flux:table.cell>

                    <flux:table.cell align="center">
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                                </flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        wire:click="deleteProduct({{ $product->id }})"
                                        wire:confirm="Are you sure you want to delete this product?"
                                        >Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                            <flux:text class="mt-1.5 text-xs"> &#128337; {{ $product->updated_at->diffForHumans() }}
                            </flux:text>
                    </flux:table.cell>
                    <!-- ... -->
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
