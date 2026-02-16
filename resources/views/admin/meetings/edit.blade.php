<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Edit Meeting</h1>

                <div class="flex space-x-4">                 
                    <a href="{{ route('admin.meetings.index') }}"
                       class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back to Meetings
                    </a>
                </div>
            </div>
        </div>

        
            <div class="bg-white p-6 mb-10">

                <form method="POST" action="{{ route('admin.meetings.update', $meeting->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Include form --}}
                    @include('admin.meetings.form', [
                        'meeting' => $meeting,
                        'treks' => $treks,
                        'guides' => $guides,
                        'attendees' => $attendees,
                    ])

                    <div class="flex justify-center gap-3 mt-6">
                        <button type="submit"
                                class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                            Save
                        </button>
                        <a href="{{ route('admin.meetings.index') }}"
                           class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                            Back to Meetings
                        </a>
                    </div>
                </form>

            </div>
       

    </div>
</x-app-layout>
