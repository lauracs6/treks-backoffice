<x-flash-status class="mb-6" />

<div class="space-y-6">

    {{-- Name --}}
    <div>
        <x-input-label for="name" value="Name" class="block text-sm font-medium text-gray-700 mb-1" />
        <x-text-input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $place->name ?? '') }}"
            required
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
    </div>

    {{-- Coordinates --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <x-input-label for="latitude" value="Latitude" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input
                id="latitude"
                name="latitude"
                type="text"
                placeholder="39.5696"
                value="{{ old('latitude', $place->latitude ?? '') }}"
                required
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
            />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2 text-sm" />
        </div>

        <div>
            <x-input-label for="longitude" value="Longitude" class="block text-sm font-medium text-gray-700 mb-1" />
            <x-text-input
                id="longitude"
                name="longitude"
                type="text"
                placeholder="2.6502"
                value="{{ old('longitude', $place->longitude ?? '') }}"
                required
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
            />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2 text-sm" />
        </div>

    </div>

    {{-- Place Type --}}
    <div>
        <x-input-label for="place_type_id" value="Type of place" class="block text-sm font-medium text-gray-700 mb-1" />
        <select
            id="place_type_id"
            name="place_type_id"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
        >
            <option value="">Select a type</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}"
                    @selected(old('place_type_id', $place->place_type_id ?? '') == $type->id)>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('place_type_id')" class="mt-2 text-sm" />
    </div>

</div>
