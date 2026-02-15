<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
        <div class="max-w-7xl mx-auto mt-10 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden">
                <div class="p-8 text-center">
                    <p class="text-xl sm:text-3xl font-extrabold leading-tight">
                        <span class="text-white bg-black shadow-lg shadow-lime-500 px-6 py-4 hover:bg-gray-800">WELCOME TO BALEARTREK</span>                        
                        <br>
                        <br>
                        <br>                         
                        <span class="text-gray-700">You are now in the </span>
                        <span class="text-sky-500">Backoffice</span>                        
                    </p>
                </div>
            </div>
        </div>    
</x-app-layout>
