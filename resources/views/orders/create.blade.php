<x-layouts::app>

    <div class="flex flex-col gap-6 size-full">

        <div>
            <flux:heading>User profile</flux:heading>
            <flux:text class="mt-2">This information will be displayed publicly.</flux:text>
        </div>

        <flux:separator />

        <livewire:orders.order-create />
        {{-- 
        <div class="border-2 rounded flex-1 relative grid grid-cols-2 gap-8 p-4 h-full">
            <div class="flex flex-col border rounded-md bg-green-400 h-full p-2">
                <div class="h-15 bg-red-400">Fixed Content</div>
                <div class="bg-blue-400 flex-1 relative">

                    <div class="absolute inset-2 bg-amber-50 overflow-y-auto">
                        <div class="h-[50rem] bg-amber-500">Full Size content</div>

                    </div>


                </div>
            </div>
            <div class="flex flex-col border rounded-md bg-green-400 h-full p-2">
                <div class="h-15 bg-red-400">Fixed Content</div>
                <div class="flex-1 relative bg-blue-400 overflow-y-scroll">

                    <div class="absolute inset-0">
                        Full Size scrollable content
                        <div class="h-[50rem]"></div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

</x-layouts::app>
