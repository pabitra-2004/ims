<?php

namespace App\Livewire\Orders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateOrder extends Component
{
    /* -----------------------------------------------------------------
    | Properties
    |------------------------------------------------------------------*/
    // view
    public string $view = 'livewire.orders.create-order';

    // Search & Filters
    public string $search = '';
    public $categories = [];
    public array $filter = [
        'categories' => [],
    ];

    // Shopping Cart
    public array $selected_products = [];
    public array $custom_items = [];
    public string $custom_item_name;
    public string $custom_item_price;

    // Customer Information
    public string $phone = '';
    public string $name = '';
    public string $email = '';
    public string $gender = 'male';

    // Customer Address
    public string $selected_state = '';
    public string $selected_district = '';
    public string $customer_city;
    public string $customer_address;
    public string $customer_pincode;

    public array $states = [];
    public array $districts = [];

    // Order Summary
    public $discount = 0;
    public $platform_fee = 0;

    /* -----------------------------------------------------------------
    | Lifecycle Hooks
    |------------------------------------------------------------------*/
    public function mount()
    {
        Product::inRandomOrder()
            ->take(3)
            ->get()
            ->each(fn ($product) => $this->addToCart($product));

        for ($i = 0; $i < 2; $i++) {
            $this->custom_items[] = [
                'name' => ucwords(fake()->words(3, true)),
                'price' => random_int(50, 200),
                'qty' => 1,
            ];
        }

        $this->categories = Category::select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();

        $this->states = State::orderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();

        // $this->view = 'livewire.orders.partials.confirm-order'; // for testing

        $this->platform_fee = fake()->numberBetween(50, 100);
        $this->discount = fake()->numberBetween(500, 3000);
    }

    public function updatedPhone(string $value)
    {
        $customer = Customer::with(['addresses'])->firstWhere('mobile', $value);
        if ($customer) {
            $this->name = $customer->name;
            $this->email = $customer->email;
            $this->gender = $customer->gender;

            $address = $customer->addresses->first();
            if ($address) {
                $this->selected_state = $address->state_id;
                $this->loadDistricts();
                $this->selected_district = $address->district_id;
                $this->customer_city = $address->city;
                $this->customer_address = $address->address;
                $this->customer_pincode = $address->pin_code;
            }
        }
    }

    public function updatedSelectedState()
    {
        $this->selected_district = '';
        $this->loadDistricts();
    }

    /* -----------------------------------------------------------------
     | Computed Properties
     |------------------------------------------------------------------*/
    #[Computed()]
    public function products()
    {
        return Product::with(['category:id,name'])
            ->search($this->search)
            ->filter($this->filter)
            ->latest()
            ->get();
    }

    #[Computed()]
    public function productsMrp()
    {
        $total = 0;

        foreach ($this->selected_products as $product) {
            $total += $product['price'] * $product['qty'];
        }

        return $total;
    }

    #[Computed]
    public function customItemsTotal(): float
    {
        $total = 0;

        foreach ($this->custom_items as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return $total;
    }

    #[Computed]
    public function subTotal(): float
    {
        return $this->productsMrp + $this->customItemsTotal;
    }

    #[Computed()]
    public function grandTotal()
    {
        return $this->subTotal + $this->platform_fee - $this->discount;
    }

    /* -----------------------------------------------------------------
    | Product Actions
    |------------------------------------------------------------------*/
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

    // remove products
    public function removeProduct(int $index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
    }

    public function quickViewProduct(string $id)
    {
        $this->dispatch('quick-view-product', $id);
    }

    public function clearFilters()
    {
        $this->filter['categories'] = [];
    }

    /* -----------------------------------------------------------------
    | Custom Item Actions
    |------------------------------------------------------------------*/
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

    // remove custom item
    public function removeItem(int $index)
    {
        unset($this->custom_items[$index]);
        $this->custom_items = array_values($this->custom_items);
    }

    /* -----------------------------------------------------------------
    | Checkout
    |------------------------------------------------------------------*/

    public function checkout()
    {
        if (empty($this->selected_products)) {
            $this->dispatch('toast-fire', type: 'error', message: 'Please add products');

            return;
        }

        $this->view = 'livewire.orders.partials.confirm-order';
    }

    public function placeOrder()
    {
        if (empty($this->selected_products)) {
            $this->dispatch('toast-fire', type: 'warning', message: 'Add at least one products');

        }

        if (blank($this->phone)) {
            $this->dispatch('toast-fire', position: 'top-end', type: 'warning', message: 'Fill user details.');
        }

        $customer = Customer::whereMobile($this->phone)->first();

        $this->validate([
            'phone' => ['required', 'size:10'],
            'name' => [Rule::requiredIf(! $customer), 'nullable', 'string', 'max:255'],
            'email' => [Rule::requiredIf(! $customer), 'nullable', 'email', 'max:255'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'selected_state' => ['nullable', 'exists:states,id'],
            'selected_district' => ['nullable', 'exists:districts,id'],
            'customer_city' => ['nullable', 'string', 'max:100'],
            'customer_address' => ['nullable', 'string', 'max:500'],
            'customer_pincode' => ['nullable', 'digits:6'],
            'selected_products' => ['nullable', 'array', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'platform_fee' => ['nullable', 'numeric', 'min:0'],
        ]);

        $customer = Customer::firstOrNew(['mobile' => $this->phone]);
        $customer->name = $this->name;
        $customer->mobile = $this->phone;
        $customer->email = $this->email;
        $customer->gender = $this->gender;
        $customer->save();

        if ($this->selected_state && $this->selected_district && $this->customer_address && $this->customer_city && $this->customer_pincode) {
            $customer->addresses()->create(
                [
                    'state_id' => $this->selected_state,
                    'district_id' => $this->selected_district,
                    'address' => $this->customer_address,
                    'city' => $this->customer_city,
                    'pin_code' => $this->customer_pincode,
                ]
            );
        }

        $order = new Order;
        $order->code = now()->timestamp;
        $order->customer_id = $customer->id;
        $order->date = now();
        $order->sub_total = $this->subTotal;
        $order->discount = $this->discount;
        $order->additional_charges = $this->platform_fee;
        $order->total = $this->grandTotal;
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

    /* -----------------------------------------------------------------
    | Private Helpers
    |------------------------------------------------------------------*/
    private function loadDistricts()
    {
        $this->districts = District::orderBy('name', 'asc')
            ->whereStateId($this->selected_state)
            ->pluck('name', 'id')
            ->toArray();
    }

    /* -----------------------------------------------------------------
    | Render
    |------------------------------------------------------------------*/
    public function render()
    {
        return view($this->view);
    }
}
