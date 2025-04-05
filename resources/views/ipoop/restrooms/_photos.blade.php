@if ($restroom->photos->count())
  <div class="mt-6 flex justify-center">
    <div class="w-full max-w-xl overflow-hidden relative rounded shadow">

      <div class="swiper-container">
        <div class="swiper-wrapper">
          @foreach ($restroom->photos as $photo)
            <div class="swiper-slide">
              <img src="{{ asset('storage/' . $photo->path) }}"
                   alt="Foto do banheiro"
                   class="w-full h-[500px] object-contain rounded">
            </div>
          @endforeach
        </div>

        <!-- Paginação -->
        <div class="swiper-pagination absolute bottom-2 left-0 right-0 text-center z-10"></div>

        <!-- Botões de navegação -->
        <div class="swiper-button-prev absolute top-1/2 -translate-y-1/2 left-2 z-10 text-white"></div>
        <div class="swiper-button-next absolute top-1/2 -translate-y-1/2 right-2 z-10 text-white"></div>
      </div>

    </div>
  </div>

  @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.swiper-container', {
          loop: true,
          slidesPerView: 1,
          centeredSlides: true,
          pagination: { el: '.swiper-pagination', clickable: true },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
        });
      });
    </script>
  @endpush
@else
    <div class="rounded">
        <p class="text-gray-500 text-center">Nenhuma foto disponível.</p>
    </div>
@endif
