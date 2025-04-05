<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Painel Administrativo - Denúncias
    </h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto">

    <div class="mb-4 flex gap-4">
      <a href="{{ route('admin.reports.index') }}"
         class="px-4 py-2 rounded {{ request()->has('resolved') ? 'bg-gray-100 text-gray-700' : 'bg-purple-600 text-white font-semibold shadow' }}">
        Todas
      </a>
      <a href="{{ route('admin.reports.index', ['resolved' => 0]) }}"
         class="px-4 py-2 rounded {{ request('resolved') == '0' ? 'bg-purple-600 text-white font-semibold shadow' : 'bg-gray-100 text-gray-700' }}">
        Pendentes
      </a>
      <a href="{{ route('admin.reports.index', ['resolved' => 1]) }}"
         class="px-4 py-2 rounded {{ request('resolved') == '1' ? 'bg-purple-600 text-white font-semibold shadow' : 'bg-gray-100 text-gray-700' }}">
        Resolvidas
      </a>
    </div>

    <table class="w-full table-auto border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border">Usuário</th>
          <th class="px-4 py-2 border">Banheiro</th>
          <th class="px-4 py-2 border">Motivo</th>
          <th class="px-4 py-2 border">Data</th>
          <th class="px-4 py-2 border">Status</th>
          <th class="px-4 py-2 border">Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($reports as $report)
          <tr>
            <td class="px-4 py-2 border text-sm">
              {{ $report->user->name }}<br>
              <small class="text-gray-500">{{ $report->user->email }}</small>
            </td>
            <td class="px-4 py-2 border">
              <a href="{{ route('restrooms.show', $report->restroom->id) }}"
                 class="text-blue-600 hover:underline" target="_blank">
                {{ $report->restroom->name }}
              </a>
            </td>
            <td class="px-4 py-2 border text-sm">
              {{ $report->reason ?: '—' }}
            </td>
            <td class="px-4 py-2 border text-sm text-gray-600">
              {{ $report->created_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-4 py-2 border">
              @if ($report->resolved)
                <span class="text-green-600 font-semibold">Resolvida</span>
              @else
                <span class="text-red-600 font-semibold">Pendente</span>
              @endif
            </td>
            <td class="px-4 py-2 border">
              @if (! $report->resolved)
              <form method="POST" action="{{ route('admin.reports.resolve', $report) }}">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                  Marcar como resolvida
                </button>
              </form>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">Nenhuma denúncia encontrada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $reports->withQueryString()->links() }}
    </div>
  </div>
</x-app-layout>