<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">User Details</h1>

                <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                    Back to Users
                </a>
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
    </div>
</x-app-layout>
