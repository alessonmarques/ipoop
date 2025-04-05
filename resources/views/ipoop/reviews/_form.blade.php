@auth
  @if (!auth()->user()->reviews->contains('restroom_id', $restroom->id))
    <div class="bg-white p-6 rounded shadow mt-6">
      <form action="{{ route('reviews.store', $restroom) }}" method="POST">
        @csrf

        <div class="mb-4">
          <label class="block font-medium mb-1">Nota</label>
          <div x-data="{ rating: 0 }" class="flex items-center space-x-2">
            <template x-for="star in 5">
              <button type="button"
                :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'"
                @click="rating = star"
                class="text-2xl focus:outline-none transition-colors">
                ★
              </button>
            </template>
            <input type="hidden" name="rating" :value="rating">
          </div>
        </div>

        <div class="mb-4">
          <label class="block font-medium mb-1">Comentário (opcional)</label>
          <textarea name="comment" rows="4" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="text-right">
          <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
            Enviar Avaliação
          </button>
        </div>
      </form>
    </div>
  @else
    <div class="mt-4 text-sm text-gray-600">
      Você já avaliou este banheiro.
    </div>
  @endif
@endauth

@guest
  <div class="mt-4 text-sm text-gray-600">
    Faça <a href="{{ route('login') }}" class="text-purple-600 hover:underline">login</a> para avaliar este banheiro.
  </div>
@endguest