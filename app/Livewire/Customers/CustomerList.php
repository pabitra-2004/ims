<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;

    public int $quantity = 10;
    public ?string $search = '';


    #[On('customer-saved')]
    public function customerSaved(){
        $this->resetPage();
    }

    public function updatedQuantity(){
        $this->resetPage();
    }
       public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();
        $this->resetPage();
        $this->dispatch('toast-fire', type: 'success', message: 'Customer delete successfully');
    }

    public function render()
    {
        $customers = Customer::with('addresses')
            ->search($this->search)
            ->latest('updated_at')
            ->paginate($this->quantity);

        return view('livewire.customers.customer-list')->with('customers', $customers);
    }
}
