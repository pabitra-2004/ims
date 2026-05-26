<?php

namespace App\Livewire\Orders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderCreate extends Component
{
    public string $search = '';

    public array $filter = [
        'categories' => [],
    ];

    public $categories = [];

    public array $selected_products = [];

    public function mount()
    {

        Product::inRandomOrder()->take(4)->get()->each(fn($product) => $this->addToCart($product));

        $products = Product::select('category_id')->distinct();
        $this->categories = Category::select('id', 'name')
            ->whereIn('id', $products)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function quickViewProduct(string $id)
    {
        $this->dispatch('quick-view-product', $id);
    }

    #[Computed()]
    public function products()
    {
        return Product::with(['category:id,name'])->search($this->search)->filter($this->filter)->latest()->get();
    }

    public function addToCart(Product $product)
    {
        $key = array_search($product->id, array_column($this->selected_products, 'id'));

        if ($key === false) {
            $this->selected_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images[0] ?? null,
                'category' => $product->category->name ?? 'N/A',
                'qty' => 1,
            ];
        } else {
            $this->selected_products[$key]['qty']++;
        }
        Flux::modals()->close();
    }

    public function clearFilters()
    {
        $this->filter['categories'] = [];
    }


    public function checkout()
    {

        $order = new Order();
        $order->code = now()->timestamp;
        $order->customer_id = Customer::inRandomOrder()->first()->id;
        $order->date = now();
        $order->sub_total = collect($this->selected_products)->sum(function (array $product) {
            return $product['price'] * $product['qty'];
        });
        $order->total = $order->sub_total;
        $order->save();

        // 1. normal save
        // foreach ($this->selected_products as $product) {
        //     $orderDetails = new OrderDetail();
        //     $orderDetails->order_id = $order->id;
        //     $orderDetails->product_id = $product['id'];
        //     $orderDetails->price = $product['price'];
        //     $orderDetails->quantity = $product['qty'];
        //     $orderDetails->save();
        // }

        // 2. save using relation
        $order_details = array_map(function ($product) {
            return [
                'product_id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $product['qty'],
            ];
        }, $this->selected_products);
        $order->orderDetails()->createMany($order_details);

        $this->dispatch('toast-fire', type: 'success', message: 'Order created.');
    }

    public function render()
    {
        return view('livewire.orders.order-create');
    }
}
