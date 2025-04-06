<div class="mt-12">
  <div class="flex flex-wrap justify-center gap-6">
    @foreach ($testimonials as $review)
      <div class="bg-white rounded shadow p-4 flex flex-col justify-between w-full sm:w-[48%] md:w-[30%] max-w-[400px]">
        <div>
            @if ($review->comment)
                <div class="text-gray-600 text-sm mb-2 italic">
                    “{{ $review->comment }}”
                </div>
            @endif
          <div class="text-yellow-500 mb-2">
            @for ($i = 1; $i <= 5; $i++)
              @if ($i <= $review->rating)
                ★
              @else
                ☆
              @endif
            @endfor
          </div>
          <p class="text-xs text-gray-500 mb-2">Usuário: {{ substr($review->user->name ?? 'anon', 0, 2) . str_repeat('*', strlen($review->user->name ?? 'anon') - 2) }}</p>
          <p class="text-xs text-gray-500">Data: {{ $review->created_at->format('d/m/Y') }}</p>
        </div>

        @if ($review->restroom->photos->count())
          <div class="mt-4 relative overflow-hidden rounded h-40">
            <div class="swiper testimonial-swiper h-full">
              <div class="swiper-wrapper">
                @foreach ($review->restroom->photos as $photo)
                  <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto do banheiro"
                         class="w-full h-40 object-cover rounded">
                  </div>
                @endforeach
              </div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        @endif

        <div class="mt-4 text-right">
          <a href="{{ route('restrooms.show', $review->restroom) }}"
             class="text-sm text-purple-600 hover:underline font-medium">Ver detalhes do banheiro →</a>
        </div>
      </div>
    @endforeach
  </div>
</div>

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".testimonial-swiper").forEach((swiperEl) => {
        new Swiper(swiperEl, {
          slidesPerView: 1,
          spaceBetween: 10,
          loop: true,
          pagination: { el: swiperEl.querySelector(".swiper-pagination"), clickable: true },
          navigation: {
            nextEl: swiperEl.querySelector(".swiper-button-next"),
            prevEl: swiperEl.querySelector(".swiper-button-prev"),
          },
        });
      });
    });
  </script>
@endpush