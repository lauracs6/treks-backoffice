<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Comments</h1>                
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10">

            <x-flash-status class="mb-4" />

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.comments.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                {{-- Status Tabs --}}
                <div class="md:col-span-2 flex flex-wrap gap-2 items-center">
                    <a href="{{ route('admin.comments.index', ['status' => 'pending', 'trek_id' => $trekId]) }}"
                       class="px-3 py-2 text-sm font-medium {{ $status === 'pending' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700' }}">
                        Pending
                    </a>
                    <a href="{{ route('admin.comments.index', ['status' => 'all', 'trek_id' => $trekId]) }}"
                       class="px-3 py-2 text-sm font-medium {{ $status === 'all' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700' }}">
                        All
                    </a>
                    <a href="{{ route('admin.comments.index', ['status' => 'approved', 'trek_id' => $trekId]) }}"
                       class="px-3 py-2 text-sm font-medium {{ $status === 'approved' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700' }}">
                        Approved
                    </a>                    
                </div>

                {{-- Trek Filter --}}
                <div class="flex items-center gap-3">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <x-input-label for="trek_id" value="Trek" />
                    <select id="trek_id" name="trek_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="all" @selected($trekId === 'all')>All</option>
                        @foreach ($treks as $trek)
                            <option value="{{ $trek->id }}" @selected((string) $trekId === (string) $trek->id)>
                                {{ $trek->regnumber }} - {{ $trek->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-sky-500 text-white text-s hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Filter
                    </button>

                    @if ($trekId !== 'all')
                        <a href="{{ route('admin.comments.index', ['status' => $status]) }}"
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
                            <th class="py-3 px-4 border">Id</th>
                            <th class="py-3 px-4 border">User</th>
                            <th class="py-3 px-4 border">Trek</th>
                            <th class="py-3 px-4 border">Meeting</th>
                            <th class="py-3 px-4 border">Score</th>
                            <th class="py-3 px-4 border">Status</th>
                            <th class="py-3 px-4 border">Total images</th>
                            <th class="py-3 px-4 border text-center w-40">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 border">{{ $comment->id }}</td>
                            <td class="py-3 px-4 border">{{ $comment->user?->name }} {{ $comment->user?->lastname }}</td>
                            <td class="py-3 px-4 border">
                                <div>Id: {{ $comment->meeting?->trek?->id ?? '-' }}</div>
                                <div>Name: {{ $comment->meeting?->trek?->name ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4 border">
                                @if ($comment->meeting)
                                    <div>Id: {{ $comment->meeting->id }}</div>
                                    <div>Date: {{ $comment->meeting->day_formatted ?: '-' }}</div>                                    
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-3 px-4 border">{{ $comment->score }}</td>
                            <td class="py-3 px-4 border">
                                @if ($comment->status === 'y')
                                    <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">
                                        Approved
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-orange-500 px-3 py-1 rounded-full text-xs font-medium">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border">{{ $comment->images_count }}</td>
                            <td class="py-3 px-4 border">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.comments.show', $comment->id) }}"
                                       class="px-3 py-1 bg-lime-500 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        View
                                    </a>
                                    <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                       class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-gray-500">
                                No comments to show.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Results --}}
            <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                Showing {{ $comments->firstItem() ?? 0 }} to {{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} results
            </div>

            {{-- Pagination --}}
            <div class="mt-4 mb-10 flex justify-center">
                {{ $comments->links('admin.pagination') }}
            </div>

        </div>
    </div>
</x-app-layout>
