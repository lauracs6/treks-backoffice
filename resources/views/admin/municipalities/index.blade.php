<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Municipalities List</h1>

                <a href="{{ route('admin.municipalities.create') }}"
                   class="px-4 py-2 bg-black text-white text-s font-semibold hover:bg-gray-600 shadow-lg shadow-gray-700">
                    Create municipality
                </a>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">

            <x-flash-status class="mb-4" />

            {{-- Filters --}}
            <form method="GET"
                action="{{ route('admin.municipalities.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <div class="md:col-span-2">
                    <x-input-label for="q" value="Search" />
                    <x-text-input id="q" name="q" type="text"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                        value="{{ $search }}"
                        placeholder="Municipality name" />
                </div>

                <div>
                    <x-input-label for="zone" value="Zone" />
                    <select name="zone" id="zone"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($zone === 'all')>All</option>
                        @foreach($zones as $z)
                            <option value="{{ $z->id }}" @selected((string)$zone === (string)$z->id)>
                                {{ $z->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="island" value="Island" />
                    <select name="island" id="island"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($island === 'all')>All</option>
                        @foreach($islands as $i)
                            <option value="{{ $i->id }}" @selected((string)$island === (string)$i->id)>
                                {{ $i->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex gap-3">
                    <button class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Search
                    </button>

                    @if($search !== '' || $zone !== 'all' || $island !== 'all')
                        <a href="{{ route('admin.municipalities.index') }}"
                        class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
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
                            <th class="py-3 px-4 border">Zone</th>
                            <th class="py-3 px-4 border">Island</th>
                            <th class="py-3 px-4 border text-center w-40">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                    @forelse($municipalities as $municipality)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border">
                                {{ $municipality->name }}
                            </td>

                            <td class="py-3 px-4 border">
                                {{ $municipality->zone?->name }}
                            </td>

                            <td class="py-3 px-4 border">
                                {{ $municipality->island?->name }}
                            </td>

                            <td class="py-3 px-4 border">
                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.municipalities.show',$municipality->id) }}"
                                       class="px-3 py-1 bg-lime-500 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        View
                                    </a>

                                    <a href="{{ route('admin.municipalities.edit',$municipality->id) }}"
                                       class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        Edit
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-500">
                                No municipalities to display.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Results --}}
            <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                Showing {{ $municipalities->firstItem() ?? 0 }}
                to {{ $municipalities->lastItem() ?? 0 }}
                of {{ $municipalities->total() }} results
            </div>

            {{-- Pagination --}}
            <div class="mt-4 mb-10 flex justify-center">
                {{ $municipalities->links('admin.pagination') }}
            </div>

        </div>
    </div>
</x-app-layout>
