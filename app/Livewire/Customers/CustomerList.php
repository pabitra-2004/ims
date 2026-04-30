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

    public array $selected = [];

    public bool $selectAll = false;

    public array $pageCustomerIds = [];

    #[On('customer-saved')]
    public function customerSaved(){
        $this->resetPage();
    }

    public function updatingPage()
    {
        $this->selectAll = false;
        $this->selected = [];
    }

    public function updatedSelectAll(bool $checked)
    {
        $this->selected = $checked ? $this->pageCustomerIds : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = ! empty($this->pageCustomerIds) && count(array_intersect($this->selected, $this->pageCustomerIds)) === count($this->pageCustomerIds);
    }

    public function deleteSelected()
    {
        $ids = array_intersect($this->selected, $this->pageCustomerIds);
        if (empty($ids)) {
            return;
        }
        Customer::whereIn('id', $ids)->delete();

        $this->selected = array_diff($this->selected, $ids);
        $this->selectAll = false;
        $this->resetPage();
        $this->dispatch('toast-fire', type: 'success', message: 'Selected categories deleted!');
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
            ->latest('updated_at')
            ->paginate($this->quantity);
            
        // store current page IDs
        $this->pageCustomerIds = $customers->pluck('id')->toArray();

        return view('livewire.customers.customer-list')->with('customers', $customers);
    }
}
