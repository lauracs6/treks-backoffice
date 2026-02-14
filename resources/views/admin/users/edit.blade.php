<x-app-layout>   
    <div class="bg-white min-h-screen">

        {{-- White header --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 rounded-lg bg-sky-500 text-white text-s hover:bg-sky-300">
                    Back to Users
                </a>
            </div>
        </div>

        <div class="py-6 bg-white">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 shadow-m">
                <div class="p-6 text-slate-900">
                    <x-flash-status class="mb-4" />
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $user->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="lastname" value="Lastname" />
                            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" value="{{ old('lastname', $user->lastname) }}" required />
                            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="dni" value="DNI" />
                            <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" value="{{ old('dni', $user->dni) }}" required />
                            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $user->phone) }}" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="role_id" value="Role" />
                            @if ($isAdminUser ?? false)
                                <x-text-input type="text" class="mt-1 block w-full bg-gray-100 text-gray-700" value="admin" disabled />
                                <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                            @else
                                <select id="role_id" name="role_id" class="mt-1 block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm">
                                <option value="y" @selected(old('status', $user->status) === 'y')>Activate</option>
                                <option value="n" @selected(old('status', $user->status) === 'n')>Deactivate</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex justify-center gap-4">
                            <x-primary-button type="submit" class="bg-sky-500 hover:bg-sky-700 rounded-lg shadow-sm">
                                Save
                            </x-primary-button>
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg bg-black text-gray-100 text-sm font-medium hover:bg-gray-500">
                                Back to Users
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
