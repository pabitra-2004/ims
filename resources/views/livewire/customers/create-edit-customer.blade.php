<flux:modal name="create-edit-customer" flyout position="bottom" variant="floating" @close="close"
    class=" --overflow-hidden">
    <form wire:submit="saveCustomer" class="space-y-6 p-2">

        <div class="space-y-1">
            <flux:heading size="lg" class="font-semibold tracking-wide">
                {{ $customer_id ? 'Update' : 'Create' }} Customer
            </flux:heading>

            <flux:text class="text-gray-400 text-sm">
                Enter details to {{ $customer_id ? 'update the' : 'add a new' }} customer.
            </flux:text>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <flux:card class="space-y-6">
                <div class="--w-96 w-25">
                    <label class="relative border-0 p-0 bg-transparent" label="Upload files">
                        <input type="file" wire:model='photo' wire:ignore="" class="sr-only" tabindex="-1"
                            style="position: absolute; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border: 0px;">

                        <div class="w-full aspect-4/5 overflow-hidden flex flex-col items-center justify-center rounded-lg border-dashed border-zinc-200 dark:border-white/10 border-2 bg-zinc-50 dark:bg-white/10 transition-colors in-data-dragging:bg-zinc-100 in-data-dragging:border-zinc-300 dark:in-data-dragging:bg-white/15 dark:in-data-dragging:border-white/20 [[disabled]_&amp;]:opacity-75 [[disabled]_&amp;]:pointer-events-none"
                            tabindex="0">
                            @php
                                $imgsrc = $photo
                                    ? $photo->temporaryUrl()
                                    : ($existing_photo
                                        ? asset('storage/' . $existing_photo)
                                        : null);
                            @endphp
                            @if ($imgsrc)
                                <img src="{{ $imgsrc }}"
                                    class="object-cover object-center flex-1 hover:cursor-pointer"
                                    alt="{{ $name }} image" title="click to change photo">
                            @else
                                <div class="flex flex-col items-center gap-2 py-5 px-6 sm:py-10 sm:px-16">
                                    <svg class="mb-4 shrink-0 [:where(&amp;)]:size-6 text-zinc-400 dark:text-white/60 transition [[disabled]:hover_&amp;]:text-zinc-400 dark:[[disabled]:hover_&amp;]:text-white/60 in-data-dragging:text-zinc-800 dark:in-data-dragging:text-white [[data-flux-file-upload-trigger]:hover_&amp;]:text-zinc-800 dark:[[data-flux-file-upload-trigger]:hover_&amp;]:text-white in-data-loading:opacity-0"
                                        data-flux-icon="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z"
                                            clip-rule="evenodd"></path>
                                    </svg>

                                    <div
                                        class="text-sm font-medium text-zinc-800 dark:text-white cursor-default [[disabled]_&amp;]:opacity-75">
                                        Drop files here or click to browse
                                    </div>

                                    <div class="relative text-zinc-500 dark:text-white/60 cursor-default text-sm">
                                        JPG, PNG, GIF up to 10MB
                                    </div>
                                </div>
                            @endif
                        </div>

                    </label>
                    <flux:error name="photo" />
                </div>

                <flux:input wire:model="name" label="Full Name" placeholder="e.g. Pabitra Das" badge="Required"
                    class="w-full" autocomplete="off" />
                
                    <flux:radio.group wire:model="gender" label="Gender" badge="Required">
                    <div class="flex gap-6">
                        <flux:radio value="male" label="Male" />
                        <flux:radio value="female" label="Female" />
                        <flux:radio value="others" label="Others" />
                    </div>
                </flux:radio.group>

                <div class="grid grid-cols-2 gap-2">
                    <flux:input wire:model="mobile" label="Phone" placeholder="Phone number" badge="Required"
                        autocomplete="off" />
                    <flux:input wire:model="email" label="Email" placeholder="Email" badge="Optional"
                        autocomplete="off" />
                </div>
            </flux:card>

            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Address</flux:heading>
                    <flux:text class="mt-2">Enter the customer's address details.</flux:text>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <flux:select wire:model.live="selected_state" label="State" badge="Required"
                        placeholder="Choose State...">
                        @foreach ($states as $state_id => $state_name)
                            <flux:select.option value="{{ $state_id }}">{{ $state_name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model="selected_district" label="District" badge="Required"
                        placeholder="Choose District...">
                        @foreach ($districts as $district_id => $district_name)
                            <flux:select.option value="{{ $district_id ?? 0 }}">{{ $district_name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <flux:input wire:model="city" label="City" placeholder="City" badge="Required" />
                    <flux:input type='number' wire:model="pincode" label="Pincode" placeholder="Pincode"
                        badge="Required" />
                </div>
                <flux:textarea wire:model="address" label="Address" placeholder="Enter address here..." />
            </flux:card>
        </div>

        <flux:separator />

        <div class="flex items-center justify-end gap-4">
            <flux:modal.close>
                <flux:button variant="filled" size="sm">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" size="sm" variant="primary" class="px-6 py-2 font-medium">
                {{ $customer_id ? 'Update' : 'Save' }}
            </flux:button>
        </div>

    </form>
</flux:modal>
