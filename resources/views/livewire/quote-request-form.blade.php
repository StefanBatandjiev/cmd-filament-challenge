<div class="space-y-6">
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">

        <div>
            <label class="block font-semibold">Name</label>
            <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Email</label>
            <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Phone</label>
            <input type="text" wire:model.defer="phone" class="w-full border rounded px-3 py-2" />
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Address</label>
            <input type="text" wire:model.defer="address" class="w-full border rounded px-3 py-2" />
            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Service</label>
            <select wire:model.defer="service" class="w-full border rounded px-3 py-2">
                <option value="">Select a service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->value }}">{{ $service->getLabel() }}</option>
                @endforeach
            </select>
            @error('service') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Booking Date & Time</label>
            <input type="datetime-local" wire:model.defer="booked_at" class="w-full border rounded px-3 py-2" />
            @error('booked_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Duration (in hours)</label>
            <input type="number" wire:model.defer="duration" min="1" class="w-full border rounded px-3 py-2" />
            @error('duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Additional Notes</label>
            <textarea wire:model.defer="notes" rows="4" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg cursor-pointer">
                Submit
            </button>
        </div>
    </form>
</div>
