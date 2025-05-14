<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Notificaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($notifications->isEmpty())
                        <p class="text-sm text-gray-600">{{ __('No tienes notificaciones disponibles.') }}</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($notifications as $notification)
                                <div class="p-4 border rounded shadow-sm">
                                    <p class="text-sm">{{ $notification->data['message'] ?? 'Sin mensaje' }}</p>
                                    <small class="text-gray-500 block mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if (!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm">{{ __('Marcar como leída') }}</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
