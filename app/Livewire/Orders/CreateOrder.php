<?php

namespace App\Livewire\Orders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateOrder extends Component
{
    public string $search = '';
    public array $filter = [
        'categories' => [],
    ];

    public $categories = [];

    public array $selected_products = [];

    public string $view = 'livewire.orders.create-order';

    public string $phone = '';
    public string $email = '';
    public string $name = '';
    public string $gender = 'male';

    public function mount()
    {
        Product::inRandomOrder()->take(4)->get()->each(fn ($product) => $this->addToCart($product));

        $this->categories = Category::select(['id', 'name'])->orderBy('name', 'asc')->get()->toArray();

        // $this->view = 'livewire.orders.partials.confirm-order'; // for testing
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
    }

    public function removeProduct(int $index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
    }

    public function clearFilters()
    {
        $this->filter['categories'] = [];
    }

    public function checkout()
    {
        if (empty($this->selected_products)) {
            $this->dispatch('toast-fire', type: 'error', message: 'Please add products');

            return;
        }

        $this->view = 'livewire.orders.partials.confirm-order';

        // $order = new Order;
        // $order->code = now()->timestamp;
        // $order->customer_id = Customer::inRandomOrder()->first()->id;
        // $order->date = now();
        // $order->sub_total = collect($this->selected_products)->sum(function (array $product) {
        //     return $product['price'] * $product['qty'];
        // });
        // $order->total = $order->sub_total;
        // $order->save();
    }

    #[Computed()]
    public function subTotal()
    {
        return collect($this->selected_products)->sum(function (array $product) {
            return $product['price'] * $product['qty'];
        });
    }

    public function placeOrder()
    {
        if (empty($this->selected_products)) {
            return;
        }

        $customer = Customer::firstOrNew(['mobile' => $this->phone]);
        $customer->name = $this->name;
        $customer->mobile = $this->phone;
        $customer->email = $this->email;
        $customer->gender = $this->gender;
        $customer->save();

        // $customer = Customer::updateOrCreate([
        //     'mobile' => $this->phone,
        // ], [
        //     'name' => $this->name,
        //     'mobile' => $this->phone,
        //     'email' => $this->email,
        //     'gender' => $this->gender,
        // ]);

        $order = new Order;
        $order->code = now()->timestamp;
        $order->customer_id = $customer->id;
        $order->date = now();
        $order->sub_total = $this->subTotal;
        $order->total = $order->sub_total;
        $order->save();

        $order_details = array_map(function ($product) {
            return [
                'product_id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $product['qty'],
            ];
        }, $this->selected_products);
        $order->orderDetails()->createMany($order_details);

        $this->dispatch('toast-fire', type: 'success', message: 'Order created.');

        return redirect()->route('orders.index');
    }

    public function updatedPhone(string $value)
    {
        $customer = Customer::firstWhere('mobile', $value);
        if ($customer) {
            $this->name = $customer->name;
            $this->email = $customer->email;
        }
    }

    public function render()
    {
        return view($this->view);
    }
}
