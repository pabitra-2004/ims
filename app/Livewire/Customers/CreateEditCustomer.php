<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\District;
use App\Models\State;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEditCustomer extends Component
{
    /*--------------------------------------------------------------------------
    | properties
    |--------------------------------------------------------------------------*/
    #[Locked]
    public ?string $customer_id = null;

    public array $states = [];
    public array $districts = [];

    public string $name;
    public string $gender = 'male';
    public string $mobile;
    public ?string $email = '';

    public string $selected_state = '';
    public string $selected_district = '';
    public string $city;
    public string $address;
    public string $pincode;


    /*--------------------------------------------------------------------------
    |listeners
    |--------------------------------------------------------------------------*/
    #[On('edit-customer')]
    public function loadCustomer(Customer $customer)
    {
        $this->customer_id = $customer->id;
        $this->name = $customer->name;
        $this->gender = $customer->gender;
        $this->mobile = $customer->mobile;
        $this->email = $customer->email;

        $address = $customer->addresses()->first();
        if ($address) {
            $this->selected_state = $address->state_id;
            $this->loadDistricts();
            $this->selected_district = $address->district_id;
            $this->city = $address->city;
            $this->address = $address->address;
            $this->pincode = $address->pin_code;
        }

        // $this->city = $customer->addresses()->city;

        $this->modal('create-edit-customer')->show();
    }

    public function mount()
    {
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

    /*--------------------------------------------------------------------------
    | actions (create /update)
    |--------------------------------------------------------------------------*/
    public function saveCustomer()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'nullable|email',
        ]);

        $customer = Customer::findOrNew($this->customer_id);
        $customer->name = $this->name;
        $customer->gender = $this->gender;
        $customer->mobile = $this->mobile;
        $customer->email = $this->email;
        $customer->save();

        $address = $customer->addresses()->firstOrNew();
        $address->state_id = $this->selected_state;
        $address->district_id = $this->selected_district;
        $address->city = $this->city;
        $address->address = $this->address;
        $address->pin_code = $this->pincode;
        $address->save();

        $this->dispatch('customer-saved');

        $this->modal('create-edit-customer')->close();
        $message = $this->customer_id ? 'Customer update successfull' : 'Customer added successfull';
        $this->dispatch('toast-fire', type: 'success', message: $message, position: 'bottom-right');
        $this->close();
    }

    /*--------------------------------------------------------------------------
    | reset
    |--------------------------------------------------------------------------*/
    public function close()
    {
        $this->reset('name', 'gender', 'mobile', 'email', 'selected_state', 'selected_district');
        $this->resetValidation();
    }

    /*---------------------------------------------------------------------------
    | render
    |--------------------------------------------------------------------------*/
    public function render()
    {
        return view('livewire.customers.create-edit-customer');
    }
}
