<x-flash-status class="mb-4" />

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="regnumber" value="Registration number" />
        <x-text-input id="regnumber" name="regnumber" type="text" class="mt-1 block w-full" value="{{ old('regnumber', $trek->regnumber ?? '') }}" required />
        <x-input-error :messages="$errors->get('regnumber')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $trek->name ?? '') }}" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="municipality_id" value="Municipality" />
    <select id="municipality_id" name="municipality_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Select a municipality</option>
        @foreach ($municipalities as $municipality)
            <option value="{{ $municipality->id }}" @selected(old('municipality_id', $trek->municipality_id ?? '') == $municipality->id)>
                {{ $municipality->name }} ({{ $municipality->island?->name ?? '-' }})
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('municipality_id')" class="mt-2" />
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="y" @selected(old('status', $trek->status ?? 'y') === 'y')>Active</option>
            <option value="n" @selected(old('status', $trek->status ?? 'y') === 'n')>Inactive</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="image" value="Image" />
        <input id="image" name="image" type="file" accept="image/*"
               class="mt-1 block w-full text-sm text-gray-700 
                      file:mr-4 file:py-2 file:px-4 file:rounded-md 
                      file:border-0 file:text-xs file:font-semibold 
                      file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />

        @if ($trek->image_display_url)
            <div class="mt-3 flex items-center gap-4">
                <img src="{{ $trek->image_display_url }}" alt="Current image" class="h-16 w-24 object-cover rounded-md border border-gray-300 shadow-sm" />
                <div class="text-sm text-gray-600 break-all">
                    Actual: {{ $trek->imageUrl }}
                </div>
            </div>
        @endif

        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $trek->description ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor.create(document.querySelector('#description'))
        .catch(error => console.error(error));
});
</script>

<div class="border-t pt-6" x-data="interestingPlacesManager()">
    <div class="text-xs uppercase text-gray-500">Interesting places</div>
    <p class="mt-1 text-sm text-gray-600">Select a place and its order</p>

    <!-- Lista de seleccionados -->
    <template x-for="(place, index) in selectedPlaces" :key="place.id">
        <div class="flex items-center gap-3 border rounded-md p-3 mb-2">
            <div class="flex-1" x-text="place.name"></div>
            <input type="number" :name="'places['+place.id+'][order]'" class="w-16 border-gray-300 rounded-md shadow-sm" x-model.number="place.order" min="0">
            <input type="hidden" :name="'places['+place.id+'][selected]'" value="1">
            <button type="button" @click="removePlace(index)" class="ml-3 px-2 py-1 bg-red-500 text-white hover:bg-red-700 text-sm shadow-sm shadow-gray-700">Remove</button>
        </div>
    </template>

    <!-- Añadir lugar -->
    <div class="mt-4 flex items-center gap-2">
        <select x-model="newPlaceId" class="border-gray-300 rounded-md shadow-sm flex-1">
            <option value="">Select a place</option>
            @foreach ($interestingPlaces as $place)
                <option value="{{ $place->id }}">{{ $place->name }} ({{ $place->placeType?->name ?? '-' }})</option>
            @endforeach
        </select>
        <input type="number" x-model.number="newPlaceOrder" placeholder="Order" min="0" class="w-16 border-gray-300 rounded-md shadow-sm">
        <button type="button" @click="addPlace()" class="px-3 py-1 bg-sky-500 text-white hover:bg-sky-700 text-sm shadow-sm shadow-gray-700">Add</button>
    </div>
</div>

<script>
function interestingPlacesManager() {
    return {
        selectedPlaces: @json($selectedPlacesData),
        newPlaceId: '',
        newPlaceOrder: 0,
        allPlaces: @json($interestingPlaces->map(fn($p)=>['id'=>$p->id,'name'=>$p->name])->values()),

        addPlace() {
            if(!this.newPlaceId) return;
            if(this.selectedPlaces.some(p=>p.id==this.newPlaceId)) return;
            const place=this.allPlaces.find(p=>p.id==this.newPlaceId);
            this.selectedPlaces.push({id:place.id,name:place.name,order:this.newPlaceOrder||0});
            this.newPlaceId=''; this.newPlaceOrder=0;
        },

        removePlace(index){ this.selectedPlaces.splice(index,1); }
    }
}
</script>
