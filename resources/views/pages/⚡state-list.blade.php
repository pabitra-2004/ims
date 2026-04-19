<?php
use Livewire\Component;
use App\Models\State;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public ?string $search = '';
    public $sortBy = 'lgd_code';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }


    #[Computed]
    public function states()
    {
        return State::search($this->search)
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);
    }
};
?>

<div>
    <div class="mb-2 select-none">
        <div class="grid grid-cols-2 gap-4 items-center">
            <div>
                <flux:heading size="lg" level="2">States</flux:heading>
                <flux:text class="mt-1 text-sm">Here you can see your States</flux:text>
            </div>
        </div>

        <flux:separator variant="subtle" class="my-2" />

        <div class="flex justify-end-safe items-center">
            <flux:input icon="magnifying-glass" size="sm" wire:model.live.debounce.300ms='search'
                placeholder="Search states..." clearable autocomplete="off" class="max-w-xs" />
        </div>
    </div>

    <flux:table :paginate="$this->states" class="border  overflow-hidden rounded-lg border-gray-600 select-none">
        <flux:table.columns>
            <flux:table.column sortable sorted direction="desc" wire:click="sort('lgd_code')" class="w-[12%] border-r pr-0" align="center">LGD Code
            </flux:table.column>
            <flux:table.column class="w-[38%] border-r">Name</flux:table.column>
            <flux:table.column class="w-[37%] border-r">Local Name</flux:table.column>
            <flux:table.column class="w-[12%]" align="center">State or UT</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse($this->states as $state)
                <flux:table.row :key="$state->id">
                    <flux:table.cell class="w-[12%] border-r" align="center">{{ $state->lgd_code }}</flux:table.cell>
                    <flux:table.cell class="w-[38%] border-r">{{ $state->name }}</flux:table.cell>
                    <flux:table.cell class="w-[37%] border-r">{{ $state->local_name }}</flux:table.cell>
                    <flux:table.cell class="w-[12%]" align="center">{{ $state->state_ut }}</flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="8" class="text-center py-12 text-gray-400">
                        No states found.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse

        </flux:table.rows>
    </flux:table>
</div>
