<div>
    <flux:table :paginate="$states">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>LGD Code</flux:table.column>
            <flux:table.column>State Name</flux:table.column>
            <flux:table.column>Local Name</flux:table.column>
            <flux:table.column>States/UT</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($states as $state)
                <flux:table.row :key="$state->id">
                    <flux:table.cell class="flex items-center gap-3">{{ $state->id }}</flux:table.cell>

                    <flux:table.cell>{{ $state->lgd_code }}</flux:table.cell>

                    <flux:table.cell>{{ $state->local_name }}</flux:table.cell>

                    <flux:table.cell>{{ $state?->local_name }}</flux:table.cell>

                    <flux:table.cell>{{ $state->state_ut }}</flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
