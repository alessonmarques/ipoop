<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Painel Administrativo - Denúncias
    </h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto">
    <table class="w-full table-auto border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 border">Usuário</th>
          <th class="px-4 py-2 border">Banheiro</th>
          <th class="px-4 py-2 border">Motivo</th>
          <th class="px-4 py-2 border">Data</th>
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
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center py-4 text-gray-500">Nenhuma denúncia encontrada.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $reports->links() }}
    </div>
  </div>
</x-app-layout>