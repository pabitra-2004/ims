<div>
    <flux:table :paginate="$orders">
        <flux:table.columns>
            <flux:table.column>Order ID</flux:table.column>
            <flux:table.column>Customer Name</flux:table.column>
            <flux:table.column>Order Date</flux:table.column>
            <flux:table.column>Amount</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($orders as $order)
                <flux:table.row :key="$order->id">
                    <flux:table.cell>
                        <flux:heading class="font-semibold text-sm text-zinc-600"># {{ $order->code }}
                        </flux:heading>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">
                        {{ $order->customer->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:text class="text-sm font-medium">
                            {{ $order->created_at->format('F j, Y g:i A') }}
                        </flux:text>
                    </flux:table.cell>

                    <flux:table.cell>
                        &#8377; {{ $order->total }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $order->status }}
                    </flux:table.cell>

                    <flux:table.cell class="flex items-center gap-2">
                        <flux:dropdown>
                            <flux:button icon="ellipsis-horizontal" variant="filled" size="sm" />
                            <flux:menu>
                                <flux:menu.item size="sm" href="{{ route('orders.invoice', $order) }}"
                                    target="_blank">Invoice</flux:menu.item>
                                <flux:menu.separator />

                                <flux:menu.item variant="danger" icon="trash" color="rose" :loading="false"
                                    tooltip="Delete"
                                    wire:swal-confirm="{ 
                                        text: 'Are you sure you want to delete this order?', 
                                        action: 'deleteOrder', 
                                        params: [ {{ $order->id }} ],
                                        buttonsStyling: false,
                                        customClass: {
                                            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-medium px-5 py-2 rounded-lg transition duration-200',
                                            cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2 rounded-lg ml-2 transition duration-200',
                                        }, 
                                    }">
                                    Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>

                </flux:table.row>
            @empty
                <!-- Empty State -->
                <flux:table.row>
                    <flux:table.cell colspan="12">
                        <div class="flex flex-1 items-center justify-center flex-col gap-4 h-120">
                            <img src="{{ asset('no_data_found.png') }}" alt="" class="size-16">
                            <div class="text-center">
                                <flux:heading size="xl" variant="subtle">Oops!</flux:heading>
                                <flux:text size="lg">No data found</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
