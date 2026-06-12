<?php

namespace App\Livewire\Orders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
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
    public array $custom_items = [];

    public string $view = 'livewire.orders.create-order';

    public string $custom_item_price;
    public string $custom_item_name;

    public string $phone = '';
    public string $email = '';
    public string $name = '';
    public string $gender = 'male';

    public array $states = [];
    public array $districts = [];

    public string $selected_state = '';
    public string $selected_district = '';
    public string $city;
    public string $address;
    public string $pincode;

    public function mount()
    {
        Product::inRandomOrder()->take(4)->get()->each(fn($product) => $this->addToCart($product));
        for ($i = 0; $i < 3; $i++) {
            $this->custom_items[] = [
                'name' => ucwords(fake()->words(3, true)),
                'price' => random_int(50, 200),
                'qty' => 1,
            ];
        }
        $this->categories = Category::select(['id', 'name'])->orderBy('name', 'asc')->get()->toArray();

        $this->view = 'livewire.orders.partials.confirm-order'; // for testing

        $this->states = State::orderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function updatedSelectedState()
    {
        $this->selected_district = '';
        $this->loadDistricts();
    }

    public function loadDistricts()
    {
        $this->districts = District::orderBy('name', 'asc')
            ->whereStateId($this->selected_state)
            ->pluck('name', 'id')
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
    }

    public function removeProduct(int $index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
    }

    public function removeItem(int $index)
    {
        unset($this->custom_items[$index]);
        $this->custom_items = array_values($this->custom_items);
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
        $order->custom_items = $this->custom_items;
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

    public function addCustomItem()
    {
        $this->custom_items[] = [
            'name' => $this->custom_item_name,
            'price' => $this->custom_item_price,
            'qty' => 1,
        ];

        $this->modal('add-custom-item')->close();
        $this->dispatch('toast-fire', type: 'success', message: 'Custom item added.');
        $this->reset('custom_item_price', 'custom_item_name');
    }

    public function render()
    {
        return view($this->view);
    }
}
