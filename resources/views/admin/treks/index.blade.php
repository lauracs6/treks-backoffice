<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Treks List</h1>

                <a href="{{ route('admin.treks.create') }}"
                   class="px-4 py-2 bg-black text-white text-s font-semibold hover:bg-gray-600 shadow-lg shadow-gray-700">
                    New trek
                </a>
            </div>
        </div>        

            {{-- White card container --}}
            <div class="bg-white shadow-md border border-gray-100 p-6">

                {{-- Filters --}}
                <form method="GET" action="{{ route('admin.treks.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <x-input-label for="q" value="Search" />
                        <x-text-input id="q" name="q" type="text"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                            value="{{ $search }}"
                            placeholder="Enter trek name" />
                    </div>

                    {{-- Island --}}
                    <div>
                        <x-input-label for="island" value="Island" />
                        <select id="island" name="island"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="all">All</option>
                            @foreach ($islands as $island)
                                <option value="{{ $island->id }}" @selected($islandId == $island->id)>
                                    {{ $island->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Municipality --}}
                    <div>
                        <x-input-label for="municipality" value="Municipality" />
                        <select id="municipality" name="municipality"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="all">All</option>
                            @foreach ($municipalities as $municipality)
                                <option value="{{ $municipality->id }}" @selected($municipalityId == $municipality->id)>
                                    {{ $municipality->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="md:col-span-4 flex gap-3">
                        <x-primary-button class="bg-sky-500 hover:bg-sky-700 rounded-none shadow-lg shadow-gray-700">
                            Search
                        </x-primary-button>

                        @if($search !== '' || $islandId !== 'all' || $municipalityId !== 'all')
                            <a href="{{ route('admin.treks.index') }}"
                               class="px-4 py-2 bg-black text-white text-sm font-medium hover:bg-gray-600 shadow-lg shadow-gray-700">
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
                                <th class="py-3 px-4 text-left border border-gray-100">Registration</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Name</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Island</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Municipality</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Places</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Status</th>
                                <th class="py-3 px-4 text-center border border-gray-100 w-40">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($treks as $trek)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $trek->regnumber }}</td>
                                    <td class="py-3 px-4 font-medium text-gray-900 border border-gray-100">{{ $trek->name }}</td>
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $trek->municipality?->island?->name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $trek->municipality?->name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $trek->interesting_places_count }}</td>
                                    <td class="py-3 px-4 border border-gray-100">
                                        @if ($trek->status === 'y')
                                            <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">Active</span>
                                        @else
                                            <span class="bg-gray-100 text-red-500 px-3 py-1 rounded-full text-xs font-medium">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 border border-gray-100 w-40">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.treks.show', $trek->id) }}" class="px-3 py-1 bg-lime-400 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">View</a>
                                            <a href="{{ route('admin.treks.edit', $trek->id) }}" class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">Edit</a>
                                            @if ($trek->status === 'y')
                                                <form method="POST" action="{{ route('admin.treks.deactivate', $trek->id) }}" onsubmit="return confirm('Are you sure you want to deactivate this trek?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-400 text-white text-xs font-semibold shadow-sm shadow-gray-700">Deactivate</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.treks.activate', $trek->id) }}" onsubmit="return confirm('Are you sure you want to activate this trek?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-400 text-white text-xs font-semibold shadow-sm shadow-gray-700">Activate</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-gray-500">No treks to display.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Results --}}
                <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                    Showing {{ $treks->firstItem() ?? 0 }}
                    to {{ $treks->lastItem() ?? 0 }}
                    of {{ $treks->total() }} results
                </div>

            </div>

            {{-- Pagination --}}
            <div class="mt-4 mb-10 flex justify-center">
                {{ $treks->links('admin.pagination') }}
            </div>        
    </div>
</x-app-layout>
