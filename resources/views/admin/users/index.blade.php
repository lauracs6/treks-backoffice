<x-app-layout>
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Users List</h1>
            </div>
        </div>

        

            {{-- White card container --}}
            <div class="bg-white shadow-md border border-gray-100 p-6">

                {{-- Filters --}}
                <form method="GET" action="{{ route('admin.users.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                    <div class="md:col-span-2">
                        <x-input-label for="q" value="Search" />
                        <x-text-input id="q" name="q" type="text"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                            value="{{ $search }}"
                            placeholder="Enter name, email, phone or dni" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Role" />
                        <select id="role" name="role"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="all" @selected($role === 'all')>All</option>
                            @foreach ($roles as $roleOption)
                                <option value="{{ $roleOption->name }}"
                                    @selected($role === $roleOption->name)>
                                    {{ $roleOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="all" @selected($status === 'all')>All</option>
                            <option value="alta" @selected($status === 'alta')>Active</option>
                            <option value="baja" @selected($status === 'baja')>Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex gap-3">
                        <x-primary-button class="bg-sky-500 hover:bg-sky-700 rounded-none shadow-lg shadow-gray-700">
                            Search
                        </x-primary-button>

                        @if($search !== '' || $role !== 'all' || $status !== 'all')
                            <a href="{{ route('admin.users.index') }}"
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
                                <th class="py-3 px-4 text-left border border-gray-100">Name</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Email</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Phone</th>
                                <th class="py-3 px-4 text-left border border-gray-100">DNI</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Role</th>
                                <th class="py-3 px-4 text-left border border-gray-100">Status</th>
                                <th class="py-3 px-4 text-center border border-gray-100">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                @php
                                    $isAdminUser = $user->role?->name === 'admin';
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $user->id }}</td>

                                    <td class="py-3 px-4 font-medium text-gray-900 border border-gray-100">
                                        {{ $user->name }} {{ $user->lastname }}
                                    </td>

                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $user->phone }}</td>
                                    <td class="py-3 px-4 text-gray-600 border border-gray-100">{{ $user->dni }}</td>

                                    <td class="py-3 px-4 border border-gray-100">
                                        <span class="bg-gray-100 text-sky-600 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $user->role?->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-4 border border-gray-100">
                                        @if ($user->status !== 'n')
                                            <span class="bg-gray-100 text-green-500 px-3 py-1 rounded-full text-xs font-medium">
                                                Active
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-red-500 px-3 py-1 rounded-full text-xs font-medium">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Botones centrados y columna más estrecha --}}
                                    <td class="py-3 px-4 border border-gray-100 w-32">
                                        <div class="flex justify-center gap-2">
                                            @if ($isAdminUser)
                                                <button disabled class="px-3 py-1 bg-gray-400 text-white text-xs font-semibold shadow-sm shadow-gray-700 cursor-not-allowed">View</button>
                                                <button disabled class="px-3 py-1 bg-gray-400 text-white text-xs font-semibold shadow-sm shadow-gray-700 cursor-not-allowed">Edit</button>
                                                <button disabled class="px-3 py-1 bg-gray-400 text-white text-xs font-semibold shadow-sm shadow-gray-700 cursor-not-allowed">Deactivate</button>
                                            @else
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="px-3 py-1 bg-lime-400 hover:bg-lime-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">View</a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="px-3 py-1 bg-sky-400 hover:bg-sky-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">Edit</a>

                                                @if ($user->status !== 'n')
                                                    <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}" onsubmit="return confirm('Are you sure you want to deactivate this user?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-red-500 hover:bg-red-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.activate', $user->id) }}" onsubmit="return confirm('Are you sure you want to activate this user?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-emerald-500 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm shadow-gray-700">
                                                            Activate
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-10 text-center text-gray-500">
                                        No users to display.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Results --}}
                <div class="mt-6 text-sm text-gray-600 bg-gray-50 rounded-lg p-4 border border-gray-100 text-center">
                    Showing {{ $users->firstItem() ?? 0 }}
                    to {{ $users->lastItem() ?? 0 }}
                    of {{ $users->total() }} results
                </div>

            </div>

            {{-- Pagination --}}
            <div class="mt-4 mb-10 flex justify-center">
                {{ $users->links('admin.pagination') }}
            </div>

    </div>
</x-app-layout>
