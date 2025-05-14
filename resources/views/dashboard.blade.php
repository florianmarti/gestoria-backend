<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Bienvenido, ") . auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session("success"))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session("success") }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">{{ __("Panel de Control") }}</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        {{ auth()->user()->role === "admin" ? __("Gestiona trámites, requisitos y documentos desde aquí.") : __("Explora y comienza nuevos trámites.") }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    @if (auth()->user()->role === "admin")
                        <!-- Panel de estadísticas -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg shadow">
                                <h4 class="text-sm font-medium text-blue-800">{{ __("Trámites Completados") }}</h4>
                                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\UserProcedure::where('status', 'completed')->count() }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg shadow">
                                <h4 class="text-sm font-medium text-green-800">{{ __("Requisitos Totales") }}</h4>
                                <p class="text-2xl font-bold text-green-600">{{ \App\Models\ProcedureRequirement::count() }}</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg shadow">
                                <h4 class="text-sm font-medium text-purple-800">{{ __("Documentos Pendientes") }}</h4>
                                <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Document::where('status', 'pending')->count() }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        @if (auth()->user()->role === "client")
                            <!-- Botones para clientes -->
                            <a href="{{ route('procedures.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __("Ver Trámites Disponibles") }}
                            </a>
                            <a href="{{ route('notifications.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                {{ __("Ver Notificaciones") }}
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span class="ml-2 bg-red-500 text-white text-xs font-semibold rounded-full px-2 py-1">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                        @elseif (auth()->user()->role === "admin")
                            <!-- Tarjetas para administradores -->
                            <a href="{{ route('admin.procedures.index') }}" class="bg-blue-100 text-blue-800 p-4 rounded-lg shadow hover:bg-blue-200 transition flex items-center justify-center text-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ __("Gestionar Trámites") }}</span>
                            </a>
                            <a href="{{ route('admin.requirements.index') }}" class="bg-green-100 text-green-800 p-4 rounded-lg shadow hover:bg-green-200 transition flex items-center justify-center text-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ __("Gestionar Requisitos") }}</span>
                            </a>
                            <a href="{{ route('admin.documents.index') }}" class="bg-purple-100 text-purple-800 p-4 rounded-lg shadow hover:bg-purple-200 transition flex items-center justify-center text-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ __("Gestionar Documentos") }}</span>
                            </a>
                            <a href="{{ route('admin.notifications.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                {{ __("Ver Notificaciones") }}
                            </a>
                        @endif
                    </div>

                    @if (auth()->user()->role === "client")
                        <!-- Resumen de trámites iniciados para clientes -->
                        <h3 class="text-lg font-semibold mb-4">{{ __("Tus Trámites Iniciados") }}</h3>
                        @php
                            $userProcedures = auth()->user()->procedures ?? collect([]);
                        @endphp
                        @if ($userProcedures->isEmpty())
                            <p class="text-sm text-gray-600">{{ __("No has iniciado ningún trámite aún.") }}</p>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                @foreach ($userProcedures as $userProcedure)
                                    <div class="bg-white p-4 shadow-sm rounded-lg">
                                        <h4 class="text-md font-semibold text-gray-900">{{ $userProcedure->procedure->name }}</h4>
                                        <p class="text-sm text-gray-600">Estado: {{ $userProcedure->status }}</p>
                                        <p class="text-sm text-gray-600">Fecha de inicio: {{ $userProcedure->start_date->format('d/m/Y') }}</p>
                                        <div class="flex items-center justify-between mt-2">
                                            <a href="{{ route('procedures.show', $userProcedure) }}" class="text-blue-500 underline">{{ __("Ver Detalles") }}</a>
                                            <div>
                                                <form action="{{ route('procedures.destroy', $userProcedure) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500" onclick="return confirm('¿Estás seguro de eliminar este trámite?');">{{ __("Eliminar") }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Notificaciones para clientes -->
                        <h3 class="text-lg font-semibold mt-6 mb-4">{{ __("Notificaciones") }}</h3>
                        @if (auth()->user()->notifications->isEmpty())
                            <p class="text-sm text-gray-600">{{ __("No tienes notificaciones.") }}</p>
                        @else
                            <div class="grid grid-cols-1 gap-4">
                                @foreach (auth()->user()->notifications as $notification)
                                    <div class="bg-white p-4 shadow-sm rounded-lg">
                                        <p class="text-sm text-gray-600">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        @if (isset($notification->data['rejection_reason']))
                                            <p class="text-sm text-red-600">
                                                {{ __("Motivo") }}: {{ $notification->data['rejection_reason'] }}
                                            </p>
                                        @endif
                                        <p class="text-sm text-gray-600">
                                            {{ __("Fecha") }}: {{ $notification->created_at->format('d/m/Y H:i') }}
                                        </p>
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
