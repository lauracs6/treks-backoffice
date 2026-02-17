<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Edit Municipality</h1>

                <a href="{{ route('admin.municipalities.index') }}"
                   class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                    Back
                </a>
            </div>
        </div>

        {{-- Form --}}
        <div class="max-w-4xl mx-auto px-8 mt-10">
            

            <form method="POST" action="{{ route('admin.municipalities.update', $municipality->id) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                @include('admin.municipalities.form', ['municipality' => $municipality])

                <div class="flex justify-center gap-3">
                    <button type="submit" class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Save
                    </button>
                    <a href="{{ route('admin.municipalities.index') }}"
                        class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back
                    </a>
                </div>
            </form>

            
        </div>
    </div>
</x-app-layout>
