<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Trek Details</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.treks.edit', $trek->id) }}"
                       class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>

                    <a href="{{ route('admin.treks.index') }}"
                       class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back to Treks
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">

            {{-- White card container --}}
            <div class="bg-white shadow-md border border-gray-100 p-6 mb-10">
                <div class="text-black font-bold text-xl">{{ $trek->name }}</div>
                <br>
                {{-- IMAGE --}}
                @if ($trek->image_display_url)
                    <div class="mb-6">
                        <img src="{{ $trek->image_display_url }}"
                             alt="{{ $trek->regnumber }}"
                             class="w-full max-w-xl border border-gray-200">
                    </div>
                @endif

                {{-- TREK INFO --}}
                <div class="space-y-4 text-sm">
                    <div><span class="text-gray-500">Registration number:</span> <span class="font-medium text-gray-900">{{ $trek->regnumber }}</span></div>
                    <div><span class="text-gray-500">Name:</span> <span class="font-medium text-gray-900">{{ $trek->name }}</span></div>

                    <div>
                        <span class="text-gray-500">Status:</span>
                        @if ($trek->status === 'y')
                            <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">Active</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">Inactive</span>
                        @endif
                    </div>

                    <div><span class="text-gray-500">Island:</span> <span class="font-medium text-gray-900">{{ $trek->municipality?->island?->name ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Municipality:</span> <span class="font-medium text-gray-900">{{ $trek->municipality?->name ?? '-' }}</span></div>
                    
                    <div><span class="text-gray-500">Average score:</span>
                            <span class="font-medium text-gray-900">
                                @if($trek->countScore > 0)
                                    {{ number_format($trek->totalScore / $trek->countScore, 2) }}
                                @else
                                -
                                @endif
                            </span>
                    </div>

                    <div><span class="text-gray-500">Created at:</span> <span class="font-medium text-gray-900">{{ $trek->created_at?->format('d-m-Y H:i') }}</span></div>
                    <div><span class="text-gray-500">Updated at:</span> <span class="font-medium text-gray-900">{{ $trek->updated_at?->format('d-m-Y H:i') }}</span></div>

                    <div>
                        <span class="text-gray-500">Description:</span>
                        <div class="font-medium text-gray-900">
                            {!! $trek->description ?: '<span class="text-gray-400">No description</span>' !!}
                        </div>
                    </div>
                </div>

                {{-- INTERESTING PLACES --}}
                <div class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Interesting places</h2>

                    <div class="space-y-4">
                        @forelse ($trek->interestingPlaces as $place)
                            <div class="border border-gray-100 bg-white p-4 text-sm hover:bg-gray-100">
                                <div><span class="text-gray-500">Order:</span> <span class="font-medium text-gray-900">{{ $place->pivot?->order }}</span></div>
                                <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $place->id }}</span></div>
                                <div><span class="text-gray-500">Name:</span> <span class="font-medium text-gray-900">{{ $place->name }}</span></div>
                                <div><span class="text-gray-500">Type:</span> <span class="font-medium text-gray-900">{{ $place->placeType?->name ?? '-' }}</span></div>
                                <div><span class="text-gray-500">GPS:</span> <span class="font-medium text-gray-900">{{ $place->gps }}</span></div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-500">No interesting places.</div>
                        @endforelse
                    </div>
                </div>

                {{-- MEETINGS --}}
                <div class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent meetings</h2>

                    <div class="space-y-4">
                        @forelse ($trek->meetings as $meeting)
                            <div class="border border-gray-100 bg-white p-4 text-sm hover:bg-gray-100">
                                <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $meeting->id }}</span></div>
                                <div><span class="text-gray-500">Guide:</span> <span class="font-medium text-gray-900">{{ $meeting->user?->name }} {{ $meeting->user?->lastname }}</span></div>
                                <div><span class="text-gray-500">Day:</span> <span class="font-medium text-gray-900">{{ $meeting->day_formatted }}</span></div>
                                <div><span class="text-gray-500">Hour:</span> <span class="font-medium text-gray-900">{{ $meeting->hour }}</span></div>
                                <div><span class="text-gray-500">Registration: </span><span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($meeting->day)->subMonth()->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($meeting->day)->subWeek()->format('d-m-Y') }}</span></div>
                                <div><span class="text-gray-500">Comments:</span> <span class="font-medium text-gray-900">{{ $meeting->comments_count }}</span></div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-500">No meetings.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        {{-- Trek Pagination --}}
        <div class="mt-4 mb-10 flex justify-center gap-4">
            @if($previous)
                <a href="{{ route('admin.treks.show', $previous->id) }}"
                class="px-4 py-2 bg-black text-white shadow-lg shadow-gray-700 hover:bg-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
            @endif
            @if($next)
                <a href="{{ route('admin.treks.show', $next->id) }}"
                class="px-4 py-2 bg-black text-white shadow-lg shadow-gray-700 hover:bg-gray-700 flex items-center">
                    Next
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
