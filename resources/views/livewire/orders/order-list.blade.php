<div>
    <flux:table :paginate="$orders">
        <flux:table.columns>

            <flux:table.column>#</flux:table.column>
            <flux:table.column>Code</flux:table.column>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Date</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Total</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($orders as $order)
                <flux:table.row :key="$order->id">
                    <flux:table.cell>{{ $orders->firstItem() + $loop->index }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:heading class="font-semibold">{{ $order->code }}</flux:heading>
                    </flux:table.cell>

                    <flux:table.cell>{{ $order->customer->name }}</flux:table.cell>

                    <flux:table.cell>
                        {{ $order->date }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $order->status }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $order->total }}
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <!-- Empty State -->
                <flux:table.row>
                    <flux:table.cell colspan="8" class="text-center py-12 text-red-500">
                        No data found
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
