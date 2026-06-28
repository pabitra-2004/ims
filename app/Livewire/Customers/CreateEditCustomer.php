<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\District;
use App\Models\State;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEditCustomer extends Component
{
    use WithFileUploads;

    /*--------------------------------------------------------------------------
    | properties
    |--------------------------------------------------------------------------*/
    #[Validate('image|max:10240')] // 10MB Max
    public $photo;

    public ?string $existing_photo = null;

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
        $this->existing_photo = $customer->photo;
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
            'photo' => ['nullable', 'image', 'max:10240'], // 10MB Max
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'mobile' => ['required', 'string', 'digits:10',  'regex:/^[6-9]\d{9}$/',  Rule::unique('customers', 'mobile')->ignore($this->customer_id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($this->customer_id)],
            'selected_state' => ['required', 'exists:states,id'],
            'selected_district' => ['required', 'exists:districts,id'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:500'],
            'pincode' => ['required', 'digits:6'],
        ]);

        $photoPath = $this->existing_photo;
        if ($this->photo) {
            if ($this->existing_photo) {
                Storage::disk('public')->delete($this->existing_photo);
            }
            $photoPath = $this->photo->store('images/customers', 'public');
        }

        $customer = Customer::updateOrCreate(
            ['id' => $this->customer_id],
            [
                'photo' => $photoPath ?? null,
                'name' => $this->name,
                'gender' => $this->gender,
                'mobile' => $this->mobile,
                'email' => $this->email ?? null,
            ]
        );

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
        $this->reset('photo', 'existing_photo', 'name', 'gender', 'mobile', 'email', 'selected_state', 'selected_district', 'city', 'address', 'pincode');
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
