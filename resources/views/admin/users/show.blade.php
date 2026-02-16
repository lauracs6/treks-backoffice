<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back to Users
                    </a> 
                </div>               
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">

            {{-- White card container --}}
            <div class="bg-white shadow-md border border-gray-100 p-6 mb-10">

                {{-- USER INFO --}}
                <div>               

                    <div class="space-y-4 text-sm">
                        <div><span class="text-gray-500">Name:</span> <span class="font-medium text-gray-900">{{ $user->name }}</span></div>
                        <div><span class="text-gray-500">Last name:</span> <span class="font-medium text-gray-900">{{ $user->lastname }}</span></div>
                        <div><span class="text-gray-500">DNI:</span> <span class="font-medium text-gray-900">{{ $user->dni }}</span></div>
                        <div><span class="text-gray-500">Email:</span> <span class="font-medium text-gray-900">{{ $user->email }}</span></div>
                        <div><span class="text-gray-500">Phone:</span> <span class="font-medium text-gray-900">{{ $user->phone }}</span></div>
                        <div><span class="text-gray-500">Role:</span> 
                            <span class="bg-gray-100 text-sky-600 px-3 py-1 rounded-full text-xs font-medium">{{ $user->role?->name ?? '-' }}</span>
                        </div>
                        <div><span class="text-gray-500">Status:</span> 
                            @if ($user->status === 'y')
                                <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">Active</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">Inactive</span>
                            @endif
                        </div>
                        <div><span class="text-gray-500">Email verified:</span> <span class="font-medium text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y H:i') : 'No' }}</span></div>
                        <div><span class="text-gray-500">Created at:</span> <span class="font-medium text-gray-900">{{ $user->created_at?->format('d-m-Y H:i') }}</span></div>
                        <div><span class="text-gray-500">Updated at:</span> <span class="font-medium text-gray-900">{{ $user->updated_at?->format('d-m-Y H:i') }}</span></div>
                    </div>
                </div>

                {{-- GUIDE MEETINGS --}}
                <div>
                    <br>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Meetings as Guide</h2>

                    <div class="space-y-4">
                        @forelse ($createdMeetings as $meeting)
                            <div class="border border-gray-100 bg-white p-4 text-sm hover:bg-gray-100">
                                <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $meeting->id }}</span></div>
                                <div><span class="text-gray-500">Trek:</span> <span class="font-medium text-gray-900">{{ $meeting->trek?->name ?? '-' }}</span></div>
                                <div><span class="text-gray-500">Day:</span> <span class="font-medium text-gray-900">{{ $meeting->day_formatted }}</span></div>
                                <div><span class="text-gray-500">Hour:</span> <span class="font-medium text-gray-900">{{ $meeting->hour }}</span></div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-500">No meetings as guide.</div>
                        @endforelse
                    </div>
                </div>

                {{-- ATTENDEE MEETINGS --}}
                <div>
                    <br>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Meetings as Attendee</h2>

                    <div class="space-y-4">
                        @forelse ($user->meetings as $meeting)
                            <div class="border border-gray-100 bg-white p-4 text-sm hover:bg-gray-100">
                                <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $meeting->id }}</span></div>
                                <div><span class="text-gray-500">Trek:</span> <span class="font-medium text-gray-900">{{ $meeting->trek?->name ?? '-' }}</span></div>
                                <div><span class="text-gray-500">Day:</span> <span class="font-medium text-gray-900">{{ $meeting->day_formatted }}</span></div>
                                <div><span class="text-gray-500">Hour:</span> <span class="font-medium text-gray-900">{{ $meeting->hour }}</span></div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-500">No associated meetings.</div>
                        @endforelse
                    </div>
                </div>

                {{-- COMMENTS --}}
                <div>
                    <br>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Comments</h2>

                    <div class="space-y-4">
                        @forelse ($user->comments as $comment)
                            <div class="border border-gray-100 bg-white p-4 text-sm hover:bg-gray-100">
                                <div><span class="text-gray-500">Id:</span> <span class="font-medium text-gray-900">{{ $comment->id }}</span></div>
                                <div><span class="text-gray-500">Meeting:</span> <span class="font-medium text-gray-900">{{ $comment->meeting?->trek?->name ?? '-' }} (#{{ $comment->meeting_id }})</span></div>
                                <div><span class="text-gray-500">Score:</span> <span class="font-medium text-gray-900">{{ $comment->score }}</span></div>
                                <div><span class="text-gray-500">Status:</span> 
                                    @if ($comment->status === 'y')
                                        <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">Approved</span>
                                    @else
                                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                                    @endif
                                </div>
                                <div><span class="text-gray-500">Text:</span> <span class="font-medium text-gray-900">{{ $comment->comment }}</span></div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-500">No comments.</div>
                        @endforelse
                    </div>
                </div>
        </div>

        {{-- User Pagination --}}
        <div class="mt-4 mb-10 flex justify-center gap-4">
            @if($previous)
                <a href="{{ route('admin.users.show', $previous->id) }}"
                class="px-4 py-2 bg-black text-white shadow-lg shadow-gray-700 hover:bg-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
            @endif

            @if($next)
                <a href="{{ route('admin.users.show', $next->id) }}"
                class="px-4 py-2 bg-black text-white shadow-lg shadow-gray-700 hover:bg-gray-700 flex items-center">
                    Next
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
