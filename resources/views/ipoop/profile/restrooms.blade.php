<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">Meus Banheiros</h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('profile') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
            ← Voltar
        </a>
    </div>
    <ul class="space-y-4">
      @forelse ($restrooms as $restroom)
        <li class="bg-white p-4 rounded shadow">
          <a href="{{ route('restrooms.show', $restroom) }}" class="text-purple-600 font-semibold text-lg hover:underline">
            {{ $restroom->name }}
          </a>
          <p>Status: {{ $restroom->approved ? 'Aprovado' : 'Pendente' }}</p>
        </li>
      @empty
        <li class="text-gray-500">Você ainda não cadastrou banheiros.</li>
      @endforelse
    </ul>
  </div>
</x-app-layout>