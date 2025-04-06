<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Painel Administrativo - Banheiros
    </h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto">

    <div class="mb-6 flex gap-4">
      <a href="{{ route('admin.restrooms.index') }}"
        class="px-4 py-2 rounded
            {{ request()->has('approved') ? 'bg-gray-100 text-gray-700' : 'bg-purple-600 text-white font-semibold shadow' }}">
        Todos
      </a>

      <a href="{{ route('admin.restrooms.index', ['approved' => 0]) }}"
        class="px-4 py-2 rounded
            {{ request('approved') == '0' ? 'bg-purple-600 text-white font-semibold shadow' : 'bg-gray-100 text-gray-700' }}">
        Pendentes
      </a>
    </div>

    <table class="w-full table-auto border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border">Nome</th>
          <th class="px-4 py-2 border">Tipo</th>
          <th class="px-4 py-2 border">Acessível</th>
          <th class="px-4 py-2 border">Custo</th>
          <th class="px-4 py-2 border">Status</th>
          <th class="px-4 py-2 border">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($restrooms as $restroom)
        <tr>
          <td class="px-4 py-2 border">{{ $restroom->name }}</td>
          <td class="px-4 py-2 border">{{ ucfirst($restroom->type) }}</td>
          <td class="px-4 py-2 border">{{ $restroom->accessible ? 'Sim' : 'Não' }}</td>
          <td class="px-4 py-2 border">R$ {{ number_format($restroom->cost, 2, ',', '.') }}</td>
          <td class="px-4 py-2 border">
            @if ($restroom->approved)
            <span class="text-green-600 font-semibold">Aprovado</span>
            @else
            <span class="text-red-600 font-semibold">Pendente</span>
            @endif
          </td>
          <td class="px-4 py-2 border">
            <div class="flex flex-wrap gap-2">
              @if (! $restroom->approved)
              <form method="POST" action="{{ route('admin.restrooms.approve', $restroom) }}">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2 rounded-md shadow-md transition focus:outline-none focus:ring-2 focus:ring-green-400 opacity-100">
                  Aprovar
                </button>
              </form>
              @endif

              <form method="POST" action="{{ route('admin.restrooms.destroy', $restroom) }}"
                onsubmit="return confirm('Tem certeza que deseja excluir?');">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-md shadow-md transition focus:outline-none focus:ring-2 focus:ring-red-400 opacity-100">
                  Excluir
                </button>
              </form>

              <a href="{{ route('restrooms.show', $restroom) }}"
                  class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-md shadow-md transition focus:outline-none focus:ring-2 focus:ring-blue-400 opacity-100">
                Visualizar
              </a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-500">Nenhum banheiro encontrado.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $restrooms->withQueryString()->links() }}
    </div>
  </div>
</x-app-layout>
