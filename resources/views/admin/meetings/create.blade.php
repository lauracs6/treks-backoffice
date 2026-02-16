<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header like treks create --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Create Meeting</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.meetings.index') }}"
                       class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back to meetings
                    </a>
                </div>
            </div>
        </div>

        {{-- Form container like treks create --}}
        <div class="max-w-8xl mx-auto px-8 mt-10">
            <div class="p-6 text-slate-900">
                <form method="POST" action="{{ route('admin.meetings.store') }}" class="space-y-6">
                    @csrf

                    {{-- Include the meeting form partial --}}
                    @include('admin.meetings.form', [
                        'meeting' => $meeting ?? null,
                        'treks' => $treks,
                        'guides' => $guides,
                    ])

                    {{-- Submit and back buttons styled like treks create --}}
                    <div class="py-6 flex justify-center gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                            Create Meeting
                        </button>
                        <a href="{{ route('admin.meetings.index') }}"
                           class="px-4 py-2 bg-black text-white text-s hover:bg-gray-700 shadow-lg shadow-gray-700">
                            Back to Meetings
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-app-layout>
