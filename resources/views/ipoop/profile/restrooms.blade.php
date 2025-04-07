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

    <div class="space-y-6">
      @forelse ($restrooms as $restroom)
        <div class="bg-white rounded shadow p-4 flex flex-col md:flex-row gap-6 items-stretch md:h-[160px] overflow-hidden">

          {{-- Informações --}}
          <div class="md:w-1/3 space-y-2 flex flex-col justify-center">
            <h3 class="text-lg font-semibold text-purple-700">{{ $restroom->name }}</h3>
            <p class="text-sm text-gray-600">
              <strong>Tipo:</strong> {{ ucfirst($restroom->type) }}<br>
              <strong>Acessível:</strong> {{ $restroom->accessible ? 'Sim' : 'Não' }}<br>
              <strong>Custo:</strong> R$ {{ number_format($restroom->cost, 2, ',', '.') }}<br>
              <strong>Status:</strong>
              <span class="px-2 py-1 rounded text-white text-xs font-semibold
                          {{ $restroom->approved ? 'bg-green-500' : 'bg-yellow-500' }}">
                {{ $restroom->approved ? 'Aprovado' : 'Pendente' }}
              </span>
            </p>
            <a href="{{ route('restrooms.show', $restroom) }}"
               class="text-sm text-purple-600 hover:underline inline-block mt-2">
              Ver detalhes →
            </a>
          </div>

          {{-- Avaliações --}}
          <div class="md:w-1/3 space-y-2 flex flex-col justify-center overflow-hidden">
            @if ($restroom->reviews->count())
              <div class="swiper review-swiper w-full">
                <div class="swiper-wrapper">
                  @foreach ($restroom->reviews as $review)
                    <div class="swiper-slide bg-gray-100 p-3 rounded shadow text-sm overflow-hidden min-w-0">
                      <p class="italic text-gray-700 mb-2">
                        "{{ $review->comment ?: 'Sem comentário' }}"
                      </p>
                      <div class="flex justify-between text-xs text-gray-500">
                        <span>Nota: {{ $review->rating }} ★</span>
                        <span>{{ strtoupper(substr($review->user->name, 0, 2)) }}**</span>
                      </div>
                    </div>
                  @endforeach
                </div>
                <div class="swiper-pagination mt-2"></div>
              </div>
            @else
              <p class="text-sm text-gray-400">Nenhuma avaliação.</p>
            @endif
          </div>

          {{-- Fotos --}}
          <div class="md:w-1/3 space-y-2 flex flex-col justify-center">
            @include('ipoop.restrooms._photos', ['restroom' => $restroom])
          </div>
        </div>
      @empty
        <p class="text-gray-500">Você ainda não cadastrou banheiros.</p>
      @endforelse
    </div>
  </div>

  @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
      window.addEventListener('load', () => {
        setTimeout(() => {
          document.querySelectorAll('.review-swiper').forEach(container => {
            new Swiper(container, {
              slidesPerView: 1,
              spaceBetween: 10,
              pagination: {
                el: container.querySelector('.swiper-pagination'),
                clickable: true,
              },
            });
          });
        }, 100);
      });
    </script>
  @endpush
</x-app-layout>
