<x-flash-status class="mb-6" />

<div class="space-y-6">

    {{-- Name --}}
    <div>
        <x-input-label for="name" value="Name" class="block text-sm font-medium text-gray-700 mb-1" />
        <x-text-input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $municipality->name ?? '') }}"
            required
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
    </div>

    {{-- Zone and Island --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <x-input-label for="zone_id" value="Zone" class="block text-sm font-medium text-gray-700 mb-1" />
            <select
                id="zone_id"
                name="zone_id"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">Selecciona una zona</option>
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}"
                        @selected(old('zone_id', $municipality->zone_id ?? '') == $zone->id)>
                        {{ $zone->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('zone_id')" class="mt-2 text-sm" />
        </div>

        <div>
            <x-input-label for="island_id" value="Island" class="block text-sm font-medium text-gray-700 mb-1" />
            <select
                id="island_id"
                name="island_id"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
            >
                <option value="">Select an island</option>
                @foreach ($islands as $island)
                    <option value="{{ $island->id }}"
                        @selected(old('island_id', $municipality->island_id ?? '') == $island->id)>
                        {{ $island->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('island_id')" class="mt-2 text-sm" />
        </div>

    </div>

</div>
