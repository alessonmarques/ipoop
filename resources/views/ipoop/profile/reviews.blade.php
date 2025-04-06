<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">Minhas Avaliações</h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('profile') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
            ← Voltar
        </a>
    </div>
    <div class="space-y-4">

        @forelse ($reviews as $review)
        <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold text-lg text-purple-700">
                <a href="{{ route('restrooms.show', $review->restroom) }}" class="text-purple-600 font-semibold text-lg hover:underline">
                    {{ $review->restroom->name }}
                </a>
            </h4>
            <p class="text-sm text-gray-600">Nota: {{ $review->rating }} ★</p>
            <p class="mt-1">{{ $review->comment }}</p>
            <a href="{{ route('reviews.edit', $review) }}" class="text-sm text-blue-600 hover:underline">Editar Avaliação</a>
        </div>
        @empty
        <p class="text-gray-500">Você ainda não avaliou nenhum banheiro.</p>
        @endforelse
    </div>
  </div>
</x-app-layout>
