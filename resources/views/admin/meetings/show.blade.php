<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Meeting Details</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.meetings.edit', $meeting->id) }}"
                       class="px-4 py-2 bg-sky-500 text-white text-s font-semibold hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>

                    <a href="{{ route('admin.meetings.index') }}"
                       class="px-4 py-2 bg-black text-white text-s font-semibold hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back to Meetings
                    </a>
                </div>
            </div>
        </div>

        {{-- Card container --}}
        <div class="max-w-8xl mx-auto px-8 mt-10">

            <div class="bg-white shadow-md border border-gray-100 p-6 mb-10">
                <div class="text-black font-bold text-xl">{{ $meeting->trek?->name ?? '-' }}</div>
                <br>

                {{-- Trek info --}}
                <div class="space-y-4 text-sm text-gray-800">
                    <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $meeting->id }}</span></div>
                    <div><span class="text-gray-500">Trek registration number:</span> <span class="font-medium text-gray-900">{{ $meeting->trek?->regnumber ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Municipality:</span> <span class="font-medium text-gray-900">{{ $meeting->trek?->municipality?->name ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Island:</span> <span class="font-medium text-gray-900">{{ $meeting->trek?->municipality?->island?->name ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Main guide:</span> <span class="font-medium text-gray-900">{{ $meeting->user?->name }} {{ $meeting->user?->lastname }}</span></div>
                    <div><span class="text-gray-500">Day:</span> <span class="font-medium text-gray-900">{{ $meeting->day_formatted }}</span></div>
                    <div><span class="text-gray-500">Time:</span> <span class="font-medium text-gray-900">{{ $meeting->hour }}</span></div>

                    {{-- Enrollment period --}}
                    @php
                        $enrollStart = \Carbon\Carbon::parse($meeting->day)->subMonth()->format('d-m-Y');
                        $enrollEnd = \Carbon\Carbon::parse($meeting->day)->subWeek()->format('d-m-Y');
                        $isOpen = \Carbon\Carbon::now()->between(
                            \Carbon\Carbon::parse($meeting->day)->subMonth(),
                            \Carbon\Carbon::parse($meeting->day)->subWeek()
                        );
                    @endphp
                    <div>
                        <span class="text-gray-500">Enrollment period:</span>
                        @if($isOpen)
                            <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">{{ $enrollStart }} - {{ $enrollEnd }} (Open)</span>
                        @else
                            <span class="bg-gray-100 text-red-500 px-3 py-1 rounded-full text-xs font-medium">{{ $enrollStart }} - {{ $enrollEnd }} (Closed)</span>
                        @endif
                    </div>

                    {{-- Average score --}}
                    <div>
                        <span class="text-gray-500">Average score:</span>
                        <span class="font-medium text-gray-900">
                            @if($meeting->countScore > 0)
                                {{ number_format($meeting->totalScore / $meeting->countScore, 2) }}
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <div><span class="text-gray-500">Created at:</span> <span class="font-medium text-gray-900">{{ $meeting->created_at?->format('d-m-Y H:i') }}</span></div>
                    <div><span class="text-gray-500">Updated at:</span> <span class="font-medium text-gray-900">{{ $meeting->updated_at?->format('d-m-Y H:i') }}</span></div>
                </div>


                {{-- Extra guides --}}
                <div class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Extra Guides</h2>
                    <ul class="space-y-2 text-sm">
                        @forelse ($extraGuides as $guide)
                            <li class="border border-gray-100 bg-white p-3 rounded hover:bg-gray-50">
                                #{{ $guide->id }} - {{ $guide->name }} {{ $guide->lastname }} ({{ $guide->email }})
                            </li>
                        @empty
                            <li class="text-gray-500">No extra guides.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Attendees --}}
                <div class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Attendees</h2>
                    <ul class="space-y-2 text-sm">
                        @forelse ($attendees as $attendee)
                            <li class="border border-gray-100 bg-white p-3 rounded hover:bg-gray-50">
                                {{ $attendee->id }} - {{ $attendee->name }} {{ $attendee->lastname }} ({{ $attendee->email }})
                            </li>
                        @empty
                            <li class="text-gray-500">No attendees.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Comments --}}
                <div class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Comments</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 border-b border-gray-200 text-gray-900">
                                <tr>
                                    <th class="py-2 px-4 text-left">ID</th>
                                    <th class="py-2 px-4 text-left">User</th>
                                    <th class="py-2 px-4 text-left">Score</th>
                                    <th class="py-2 px-4 text-left">Status</th>
                                    <th class="py-2 px-4 text-left">Images</th>
                                    <th class="py-2 px-4 text-left">Text</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($meeting->comments as $comment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4">#{{ $comment->id }}</td>
                                        <td class="py-2 px-4">{{ $comment->user?->name }} {{ $comment->user?->lastname }}</td>
                                        <td class="py-2 px-4">{{ $comment->score }}</td>
                                        <td class="py-2 px-4">{{ $comment->status === 'y' ? 'Approved' : 'Pending' }}</td>
                                        <td class="py-2 px-4">{{ $comment->images_count }}</td>
                                        <td class="py-2 px-4">{{ $comment->comment }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="py-4 text-gray-500">No comments.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        {{-- Trek Pagination --}}
        <div class="mt-4 mb-10 flex justify-center gap-4">
            @if($previous)
                <a href="{{ route('admin.meetings.show', $previous->id) }}"
                class="px-4 py-2 bg-black text-white shadow-lg shadow-gray-700 hover:bg-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
            @endif

            @if($next)
                <a href="{{ route('admin.meetings.show', $next->id) }}"
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
