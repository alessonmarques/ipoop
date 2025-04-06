<x-app-layout>
  <div>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Avaliação</h2>
  </x-slot>

  <div class="px-4 py-6 max-w-xl mx-auto">

    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-purple-600 hover:underline">
            ← Voltar
        </a>
    </div>

    <div class="px-4 py-6 max-w-xl mx-auto bg-white rounded shadow">

      <form action="{{ route('reviews.update', $review) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="block font-medium mb-1">Nota</label>
          <div id="starRating" class="flex gap-1 text-2xl text-yellow-400 cursor-pointer">
              @for ($i = 1; $i <= 5; $i++)
              <span data-value="{{ $i }}" class="star {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
              @endfor
          </div>
          <input type="hidden" name="rating" id="ratingInput" value="{{ $review->rating }}">
      </div>


        <div class="mb-4">
          <label class="block font-medium mb-1">Comentário</label>
          <textarea name="comment" class="w-full border rounded px-3 py-2">{{ old('comment', $review->comment) }}</textarea>
        </div>

        <div class="text-right">
          <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
            Atualizar Avaliação
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('#starRating .star');
            const input = document.getElementById('ratingInput');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                input.value = value;

                stars.forEach(s => {
                    s.classList.toggle('text-yellow-400', s.getAttribute('data-value') <= value);
                    s.classList.toggle('text-gray-300', s.getAttribute('data-value') > value);
                });
                });
            });
        });
</script>
@endpush


</x-app-layout>
