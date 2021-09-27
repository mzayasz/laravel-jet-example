<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 leading-tight">
            M ZAYAS
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @livewire('show-posts', ['title' => 'Título de prueba'])

        </div>
    </div>
</x-app-layout>
