@auth
    @if (auth()->check() && auth()->user()->hasVerifiedEmail())
        <div x-data="{ open: false }" class="mt-4">
            <button @click="open = true" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
            🚩 Denunciar
            </button>

            <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1001]" style="display: none;">
            <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                <h2 class="text-lg font-semibold mb-4">Denunciar Banheiro</h2>
                <form action="{{ route('reports.store') }}" method="POST">
                @csrf
                <input type="hidden" name="restroom_id" value="{{ $restroom->id }}">
                <textarea name="reason" rows="4" class="w-full border rounded px-3 py-2 mb-4" placeholder="Descreva o problema (opcional)"></textarea>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Cancelar
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Enviar denúncia
                    </button>
                </div>
                </form>
                <button @click="open = false" class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl font-bold">&times;</button>
            </div>
            </div>
        </div>
    @endif
@endauth
