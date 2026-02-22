<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Meetings List</h1>

                <a href="{{ route('admin.meetings.create') }}"
                   class="px-4 py-2 bg-black text-white text-s font-semibold hover:bg-gray-600 shadow-lg shadow-gray-700">
                    New Meeting
                </a>
            </div>
        </div>        

        {{-- White card container --}}
        <div class="bg-white shadow-md border border-gray-100 p-6">

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.meetings.index') }}"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                {{-- Trek filter --}}
                <div class="md:col-span-2">
                    <x-input-label for="trek_id" value="Trek (registration and name)" />
                    <select id="trek_id" name="trek_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($trekId === 'all')>All</option>
                        @foreach ($treks as $trek)
                            <option value="{{ $trek->id }}" @selected((string)$trekId === (string)$trek->id)>
                                {{ $trek->regnumber }} - {{ $trek->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Enrollment --}}
                <div>
                    <x-input-label for="inscripcion" value="Enrollment" />
                    <select id="inscripcion" name="inscripcion"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                        <option value="all" @selected($inscripcion === 'all')>All</option>
                        <option value="active" @selected($inscripcion === 'active')>Open</option>
                        <option value="inactive" @selected($inscripcion === 'inactive')>Closed</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="md:col-span-4 flex gap-3">
                    <x-primary-button class="bg-sky-500 hover:bg-sky-700 rounded-none shadow-lg shadow-gray-700">
                        Filter
                    </x-primary-button>

                    @if($trekId !== 'all' || $inscripcion !== 'all')
                        <a href="{{ route('admin.meetings.index') }}"
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
                            <th class="py-3 px-4 text-left border border-gray-100">ID</th>
                            <th class="py-3 px-4 text-left border border-gray-100">Trek</th>
                            <th class="py-3 px-4 text-left border border-gray-100">Guide</th>
                            <th class="py-3 px-4 text-left border border-gray-100">Day</th>
                            <th class="py-3 px-4 text-left border border-gray-100">Time</th>
                            <th class="py-3 px-4 text-left border border-gray-100">Enrollment Period</th>
                            <th class="py-3 px-4 text-center border border-gray-100 w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($meetings as $meeting)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $meeting->id }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900 border border-gray-100">{{ $meeting->trek?->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $meeting->user?->name }} {{ $meeting->user?->lastname }}</td>
                            <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $meeting->day_formatted }}</td>
                            <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $meeting->hour }}</td>
                            <td class="py-3 px-4 border border-gray-100">
                                @php
                                    $enrollStart = \Carbon\Carbon::parse($meeting->day)->subMonth()->format('M d, Y');
                                    $enrollEnd = \Carbon\Carbon::parse($meeting->day)->subWeek()->format('M d, Y');
                                    $isOpen = \Carbon\Carbon::now()->between(
                                        \Carbon\Carbon::parse($meeting->day)->subMonth(),
                                        \Carbon\Carbon::parse($meeting->day)->subWeek()
                                    );
                                @endphp
                                @if($isOpen)
                                    <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $enrollStart }} - {{ $enrollEnd }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-red-500 px-3 py-1 rounded-full text-xs font-medium">
                                        {{ $enrollStart }} - {{ $enrollEnd }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border border-gray-100 w-40">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.meetings.show', $meeting->id) }}" class="px-3 py-1 bg-lime-400 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">View</a>
                                    <a href="{{ route('admin.meetings.edit', $meeting->id) }}" class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">Edit</a>                                    
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-500">No meetings to display.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Results --}}
            <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                Showing {{ $meetings->firstItem() ?? 0 }}
                to {{ $meetings->lastItem() ?? 0 }}
                of {{ $meetings->total() }} results
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 mb-10 flex justify-center">
            {{ $meetings->links('admin.pagination') }}
        </div>        
    </div>
</x-app-layout>
