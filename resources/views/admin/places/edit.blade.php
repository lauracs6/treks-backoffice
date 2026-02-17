<x-app-layout>
    <div class="bg-white min-h-screen">

        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Edit Place</h1>

                <a href="{{ route('admin.places.index') }}"
                class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                    Back
                </a>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">
            <div class="p-6">

                <form method="POST" action="{{ route('admin.places.update',$place->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    @include('admin.places.form',['place'=>$place])

                    <div class="flex justify-center gap-3">
                        <button class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                            Save
                        </button>
                        <a href="{{ route('admin.places.index') }}"
                        class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                            Back
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
