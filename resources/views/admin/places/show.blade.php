<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Place Details</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.places.edit',$place->id) }}"
                    class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>

                    <a href="{{ route('admin.places.index') }}"
                    class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">

            <div><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $place->name }}</span></div>
            <div><span class="text-gray-500">Type:</span> <span class="font-medium">{{ $place->placeType?->name }}</span></div>            
            <div><span class="text-gray-500">Latitude:</span> <span class="font-medium">{{ $place->latitude }}</span></div>
            <div><span class="text-gray-500">Longitude:</span> <span class="font-medium">{{ $place->longitude }}</span></div>
            <br>
            {{-- Treks table --}}
            
                <h2 class="text-lg font-semibold mb-4">Treks</h2>
                <div class="space-y-3">
                @forelse($place->treks as $trek)
                <div class="border border-gray-100 p-4 hover:bg-gray-100 text-m text-gray-800">
                <div>Trek id: {{ $trek->id }}</div>
                <div>Trek registration number: {{ $trek->regnumber }}</div>
                <div>Trek name: {{ $trek->name }}</div>
                <div>Order in trek: {{ $trek->pivot?->order }}</div>
                </div>
                @empty
                <div class="text-gray-500">No treks.</div>
                @endforelse
            
        </div>

            {{-- Place pagination --}}
            <div class="mt-8 flex justify-center gap-4">

                @if($previous)
                    <a href="{{ route('admin.places.show', $previous->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19l-7-7 7-7"/>
                        </svg>
                        Previous
                    </a>
                @endif

                @if($next)
                    <a href="{{ route('admin.places.show', $next->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif

            </div>

    </div>
</x-app-layout>
