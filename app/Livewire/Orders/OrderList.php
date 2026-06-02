<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.orders.order-list', [
            'orders' => Order::with(['customer', 'orderDetails'])
                ->latest('updated_at')
                ->paginate(10)
        ]);
    }
}
