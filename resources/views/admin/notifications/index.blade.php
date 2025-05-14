<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Notificaciones") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($filteredNotifications->isEmpty())
                        <p>{{ __("No hay notificaciones nuevas.") }}</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($filteredNotifications as $notification)
                                <li class="p-4 bg-gray-100 rounded">
                                    <p>{{ $notification->data["message"] }}</p>
                                    @if (isset($notification->data["user_procedure_id"]))
                                        <a href="{{ route("procedures.show", $notification->data["user_procedure_id"]) }}"
                                           class="text-blue-500 hover:underline">
                                            {{ __("Ver Trámite") }}
                                        </a>
                                    @endif
                                    <p class="text-sm text-gray-500">{{ $notification->created_at->format("d/m/Y H:i") }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
