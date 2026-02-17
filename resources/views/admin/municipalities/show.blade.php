<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Municipality Details</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.municipalities.edit', $municipality->id) }}"
                       class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>

                    <a href="{{ route('admin.municipalities.index') }}"
                       class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10 space-y-4">

            {{-- Municipality details --}}
            <div><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $municipality->name }}</span></div>
            <div><span class="text-gray-500">Zone:</span> <span class="font-medium">{{ $municipality->zone?->name ?? '-' }}</span></div>
            <div><span class="text-gray-500">Island:</span> <span class="font-medium">{{ $municipality->island?->name ?? '-' }}</span></div>
            <div><span class="text-gray-500">Created At:</span> <span class="font-medium">{{ $municipality->created_at?->format('d-m-Y H:i') }}</span></div>
            <div><span class="text-gray-500">Updated At:</span> <span class="font-medium">{{ $municipality->updated_at?->format('d-m-Y H:i') }}</span></div>

            <br>

            {{-- Treks --}}
            <h2 class="text-lg font-semibold mb-4">Treks</h2>
            <div class="space-y-3">
                @forelse($municipality->treks as $trek)
                    <div class="border border-gray-100 p-4 hover:bg-gray-100 text-sm text-gray-800 rounded-md">
                        <div>Trek ID: {{ $trek->id }}</div>
                        <div>Registration number: {{ $trek->regnumber }}</div>
                        <div>Name: {{ $trek->name }}</div>
                        <div>Status: {{ $trek->status === 'y' ? 'Active' : 'Inactive' }}</div>
                        <div>Meetings: {{ $trek->meetings_count }}</div>
                    </div>
                @empty
                    <div class="text-gray-500">No treks.</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
