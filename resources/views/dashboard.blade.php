<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bienvenido, ') . auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Panel de Control') }}</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        {{ auth()->user()->role === 'admin' ? __('Gestiona trámites y requisitos desde aquí.') : __('Explora y comienza nuevos trámites.') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @if (auth()->user()->role === 'client')
                            <!-- Botón para clientes -->
                            <a href="{{ route('procedures.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Ver Trámites Disponibles') }}
                            </a>
                        @elseif (auth()->user()->role === 'admin')
                            <!-- Botones para administradores -->
                            <a href="{{ route('admin.procedures.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Gestionar Trámites') }}
                            </a>
                            <a href="{{ route('admin.requirements.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Gestionar Requisitos') }}
                            </a>
                        @endif
                    </div>

                    @if (auth()->user()->role === 'client')
                        <!-- Resumen de trámites iniciados para clientes -->
                        <h3 class="text-lg font-semibold mb-4">{{ __('Tus Trámites Iniciados') }}</h3>
                        @php
                            $userProcedures = auth()->user()->procedures ?? collect([]);
                        @endphp
                        @if ($userProcedures->isEmpty())
                            <p class="text-sm text-gray-600">{{ __('No has iniciado ningún trámite aún.') }}</p>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                @foreach ($userProcedures as $userProcedure)
                                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                                        <h4 class="text-md font-semibold">{{ $userProcedure->procedure->name }}</h4>
                                        <p class="text-sm">Estado: {{ $userProcedure->status }}</p>
                                        <p class="text-sm">Fecha de inicio: {{ $userProcedure->start_date->format('d/m/Y') }}</p>
                                        <a href="{{ route('procedures.show', $userProcedure) }}" class="text-blue-500 underline">{{ __('Ver Detalles') }}</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
