<?php

use App\Models\District;
use App\Models\State;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public ?int $selected_state = null;
    public $states = [];
    public $sortBy = 'lgd_code';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->states = State::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public function updatedSelectedState() 
    {
        $this->resetPage();
    }
    
    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    #[Computed]
    public function districts()
    {
        return District::when($this->selected_state, function ($query) {
            $query->where('state_id', $this->selected_state);
        })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }
};
?>

<div>
    <div class="select-none">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">Districts</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can see your Districts</flux:text>
            </div>
        </div>

        <flux:separator variant="subtle" class="my-3" />

        <div class="flex flex-col space-y-3">
            <div class="flex justify-end">
                <flux:select wire:model.live="selected_state" size="sm" class="w-60">
                    <flux:select.option value="">All States</flux:select.option>
                    @foreach ($this->states as $id => $name)
                        <flux:select.option value="{{ $id }}">
                            {{ $name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:table :paginate="$this->districts"
                class="border overflow-hidden rounded-lg border-gray-600 select-none">
                <flux:table.columns>
                    <flux:table.column sortable sorted direction="desc" wire:click="sort('lgd_code')"
                        class="w-[12%] border-r text-center pr-0" align="center">
                        LGD Code
                    </flux:table.column>

                    <flux:table.column class="w-[38%] border-r">
                        Name
                    </flux:table.column>

                    <flux:table.column class="w-[37%] border-r">
                        Local Name
                    </flux:table.column>

                    <flux:table.column class="w-[13%] text-center pl-0" align="center">
                        Short Name
                    </flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($this->districts as $district)
                        <flux:table.row>
                            <flux:table.cell class="w-[12%] border-r text-center">
                                {{ $district->lgd_code }}
                            </flux:table.cell>

                            <flux:table.cell class="w-[38%] border-r">
                                {{ $district->name }}
                            </flux:table.cell>

                            <flux:table.cell class="w-[37%] border-r">
                                {{ $district?->local_name }}
                            </flux:table.cell>

                            <flux:table.cell class="w-[13%] text-center pl-0">
                                {{ $district->short_name }}
                            </flux:table.cell>

                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center py-12 text-gray-400">
                                No states found.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

        </div>
    </div>
</div>
