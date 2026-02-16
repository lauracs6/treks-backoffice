<x-flash-status class="mb-4" />

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="trek_id" value="Trek" />
        <select id="trek_id" name="trek_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">Select an existing trek</option>
            @foreach ($treks as $trek)
                <option value="{{ $trek->id }}" @selected(old('trek_id', $meeting->trek_id ?? '') == $trek->id)>
                    {{ $trek->regnumber }} - {{ $trek->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('trek_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="user_id" value="Main Guide" />
        <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">Select a guide</option>
            @foreach ($guides as $guide)
                <option value="{{ $guide->id }}" @selected(old('user_id', $meeting->user_id ?? '') == $guide->id)>
                    {{ $guide->lastname }} {{ $guide->name }} ({{ $guide->email }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
    <div>
        <x-input-label for="day" value="Meeting Day" />
        <x-text-input id="day" name="day" type="date" class="mt-1 block w-full" value="{{ old('day', isset($meeting->day) ? $meeting->day->format('Y-m-d') : '') }}" required />
        <x-input-error :messages="$errors->get('day')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="hour" value="Hour" />
        <x-text-input id="hour" name="hour" type="time" class="mt-1 block w-full" value="{{ old('hour', $meeting->hour_input ?? '') }}" required />
        <x-input-error :messages="$errors->get('hour')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
    <div>
        <div class="text-xs uppercase text-gray-500">Registration Start</div>
        <div class="mt-1 font-medium text-gray-900">{{ $meeting->app_date_ini_formatted ?: '-' }}</div>        
    </div>

    <div>
        <div class="text-xs uppercase text-gray-500">Registration End</div>
        <div class="mt-1 font-medium text-gray-900">{{ $meeting->app_date_end_formatted ?: '-' }}</div>        
    </div>
</div>
