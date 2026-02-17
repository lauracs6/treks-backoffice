<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- Header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Edit Comment</h1>

                <a href="{{ route('admin.comments.index') }}"
                   class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">
                    Back
                </a>
            </div>
        </div>

        {{-- Form & Details --}}
        <div class="max-w-4xl mx-auto px-8 mt-10 space-y-6">

            {{-- Comment info --}}
            <div class="border border-gray-100 bg-white p-6 space-y-4">

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <div class="text-m  text-gray-600">User name:                         
                        <span class="text-m  text-black">{{ $comment->user?->name }} {{ $comment->user?->lastname }}</span></div> 
                        <div class="text-m text-gray-600">User email: 
                        <span class="text-m  text-black">{{ $comment->user?->email }}</span></div> 
                        <div class="text-m text-gray-600">Trek name: 
                        <span class="text-m  text-black">{{ $comment->meeting?->trek?->name ?? '-' }}</span></div>
                    </div>                    

                    <div class="sm:col-span-2">
                        <div class="text-m text-black font-semibold">Meeting</div>
                        @if ($comment->meeting)                            
                            <div class="text-m  text-gray-600">Id:                         
                            <span class="text-m  text-black"></span>{{ $comment->meeting->id }}</div> 
                            <div class="text-m text-gray-600">Day: 
                            <span class="text-m  text-black">{{ $comment->meeting->day_formatted ?: '-' }}</span></div> 
                            <div class="text-m text-gray-600">Registration start: 
                            <span class="text-m  text-black">{{ $comment->meeting->app_date_ini_formatted ?: '-' }}</span></div>
                            <div class="text-m text-gray-600">Registration end: 
                            <span class="text-m  text-black">{{ $comment->meeting->app_date_end_formatted ?: '-' }}</span></div>
                        </div>
                        @else
                            <div class="font-medium">-</div>
                        @endif                    

                    <div>
                        <div class="text-m text-gray-600">Score: 
                        <span class="font-medium text-black">{{ $comment->score }}</span></div>                    
                        <div class="text-m text-gray-600">Status: 
                        <span class="font-medium text-black">{{ $comment->status === 'y' ? 'Approved' : 'Pending' }}</span></div>
                    </div>
                </div>

                <div>
                    <div class="text-m text-black font-semibold">Comment</div>
                    <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $comment->comment }}</p>
                </div>

                {{-- Images --}}
                <div>
                    <div class="text-m text-black font-semibold">Images</div>
                    @if ($comment->images->isEmpty())
                        <p class="mt-2 text-sm text-gray-600">No images.</p>
                    @else
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                            @foreach ($comment->images as $image)
                                <div class="border border-lime-400 bg-white p-2">
                                    @if ($image->display_url)
                                        <a href="{{ $image->display_url }}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ $image->display_url }}" alt="Comment image {{ $image->id }}" class="h-28 w-full object-cover rounded-md border border-slate-200" loading="lazy" />
                                        </a>
                                    @endif
                                    <div class="mt-2 text-xs text-lime-500 break-all">{{ $image->url }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Edit form --}}
            <form method="POST" action="{{ route('admin.comments.update', $comment->id) }}" class="space-y-6 p-6 bg-white">
                @csrf
                @method('PATCH')

                <x-input-label for="status" value="Status" />
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    <option value="y" @selected(old('status', $comment->status) === 'y')>Approved</option>
                    <option value="n" @selected(old('status', $comment->status) === 'n')>Pending</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />

                <div class="flex justify-center gap-3 mt-4">
                    <button type="submit" class="px-4 py-2 bg-sky-500 text-white hover:bg-sky-700 shadow-lg shadow-gray-700">Save</button>
                    <a href="{{ route('admin.comments.index') }}" class="px-4 py-2 bg-black text-white hover:bg-gray-700 shadow-lg shadow-gray-700">Back</a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
