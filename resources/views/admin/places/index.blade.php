<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Places List</h1>

                <a href="{{ route('admin.places.create') }}"
                   class="px-4 py-2 bg-black text-white text-s font-semibold hover:bg-gray-600 shadow-lg shadow-gray-700">
                    New place
                </a>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">            

            <x-flash-status class="mb-4" />

            {{-- Error messages --}}
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.places.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

                {{-- Search --}}
                <div class="md:col-span-2">
                    <x-input-label for="q" value="Search" />
                    <x-text-input id="q" name="q" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        value="{{ $search }}"
                        placeholder="Name or GPS" />
                </div>

                {{-- Type --}}
                <div>
                    <x-input-label for="type" value="Type" />
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($type === 'all')>All</option>
                        @foreach($types as $t)
                            <option value="{{ $t->id }}" @selected((string)$type === (string)$t->id)>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <x-input-label for="status" value="Status" />
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($status === 'all')>All</option>
                        <option value="active" @selected($status === 'active')>Active</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-3">
                    <button class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Search
                    </button>

                    @if($search !== '' || $type !== 'all' || $status !== 'all')
                        <a href="{{ route('admin.places.index') }}"
                        class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                            Clear
                        </a>
                    @endif
                </div>

            </form>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-black border-b border-gray-100 text-gray-100">
                        <tr>
                            <th class="py-3 px-4 border">Name</th>
                            <th class="py-3 px-4 border">GPS</th>
                            <th class="py-3 px-4 border">Type</th>
                            <th class="py-3 px-4 border">Status</th>
                            <th class="py-3 px-4 border text-center w-40">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                    @forelse($places as $place)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border">{{ $place->name }}</td>
                            <td class="py-3 px-4 border">{{ $place->gps }}</td>
                            <td class="py-3 px-4 border">{{ $place->placeType?->name }}</td>

                            {{-- Status --}}
                            <td class="py-3 px-4 border">
                                @if($place->status === 'y')
                                    <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-red-500 px-3 py-1 rounded-full text-xs font-medium">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="py-3 px-4 border">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.places.show',$place->id) }}"
                                       class="px-3 py-1 bg-lime-400 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        View
                                    </a>

                                    <a href="{{ route('admin.places.edit',$place->id) }}"
                                       class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        Edit
                                    </a>

                                    @if ($place->status === 'y')
                                        <form method="POST" action="{{ route('admin.places.deactivate', $place->id) }}" onsubmit="return confirm('Are you sure you want to deactivate this place?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-700 text-white text-xs font-semibold shadow-sm">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.places.activate', $place->id) }}" onsubmit="return confirm('Are you sure you want to activate this place?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm">
                                                Activate
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.places.destroy', $place->id) }}" onsubmit="return confirm('Are you sure you want to delete this place?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-800 hover:bg-red-900 text-white text-xs font-semibold shadow-sm">
                                        Delete
                                    </button>
                                </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-500">
                                No places to display.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Results --}}
            <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                Showing {{ $places->firstItem() ?? 0 }}
                to {{ $places->lastItem() ?? 0 }}
                of {{ $places->total() }} results
            </div>
        
            <div class="mt-4 mb-10 flex justify-center">
                {{ $places->links('admin.pagination') }}
            </div>

        </div>
    </div>
</x-app-layout>
