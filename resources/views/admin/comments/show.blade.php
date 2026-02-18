<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Comment Details</h1>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.comments.edit', $comment->id) }}"
                       class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">
                        Edit
                    </a>

                    <a href="{{ route('admin.comments.index') }}"
                       class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-8xl mx-auto px-8 mt-10 mb-10 space-y-4">

            {{-- Comment details --}}
            
            <div><span class="text-gray-500">User:</span> <span class="font-medium">{{ $comment->user?->name }} {{ $comment->user?->lastname }}</span></div>
            <div><span class="text-gray-500">User Role:</span> <span class="font-medium">{{ $comment->user?->role?->name ?? '-' }}</span></div>
            <div><span class="text-gray-500">Meeting:</span> <span class="font-medium">{{ $comment->meeting?->id ?? '-' }}</span></div>                
            <div><span class="text-gray-500">Score:</span> <span class="font-medium">{{ $comment->score }}</span></div>
            <div><span class="text-gray-500">Trek:</span> <span class="font-medium">{{ $comment->meeting?->trek?->name ?? '-' }}</span></div>
            <div><span class="text-gray-500">Trek Guide:</span> <span class="font-medium">{{ $comment->meeting?->user?->name }} {{ $comment->meeting?->user?->lastname }}</span></div>
            <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $comment->status === 'y' ? 'Approved' : 'Pending' }}</span></div>
            <div><span class="text-gray-500">Created At:</span> <span class="font-medium">{{ $comment->created_at?->format('d-m-Y H:i') }}</span></div>
            <div><span class="text-gray-500">Updated At:</span> <span class="font-medium">{{ $comment->updated_at?->format('d-m-Y H:i') }}</span></div>
            <br>
            <div class="mt-2"><span class="text-gray-500">Content:</span>
                <div class="font-medium bg-white p-4 border border-sky-400 mt-1 hover:bg-gray-200">{{ $comment->comment }}</div>
            </div>
            <br>

            {{-- Comment images --}}
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-4">Images</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($comment->images as $image)
                        <div class="border border-lime-400 bg-gray-50  p-3">
                            <img src="{{ $image->url }}" alt="Comment image {{ $comment->id }}" class="w-full h-48 object-cover rounded-md">
                            <p class="mt-2 text-xs text-lime-500 break-all">{{ $image->url }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">No images available.</p>
                    @endforelse
                </div>
            </div>

            {{-- Comment navigation --}}
            <div class="mt-8 px-6 flex justify-center gap-4">

                @if($previous)
                    <a href="{{ route('admin.comments.show', $previous->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Previous
                    </a>
                @endif

                @if($next)
                    <a href="{{ route('admin.comments.show', $next->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
