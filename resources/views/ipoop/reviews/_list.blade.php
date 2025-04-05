@if ($restroom->reviews->count())
  <div class="bg-white p-6 rounded shadow mt-8">
    <h3 class="text-lg font-semibold mb-4">Avaliações</h3>

    @php
      $average = number_format($restroom->reviews->avg('rating'), 1);
    @endphp

    <div class="mb-4">
      <p class="text-gray-800 text-sm">Nota média:</p>
      <div class="flex items-center text-yellow-400 text-xl">
        @for ($i = 1; $i <= 5; $i++)
          @if ($i <= floor($average))
            ★
          @else
            ☆
          @endif
        @endfor
        <span class="ml-2 text-gray-700 text-sm">({{ $average }} / 5 - {{ $restroom->reviews->count() }} avaliações)</span>
      </div>
    </div>

    <ul class="divide-y divide-gray-200">
      @foreach ($restroom->reviews->sortByDesc('created_at') as $review)
        <li class="py-3">
          <div class="flex items-center justify-between mb-1">
            <span class="font-semibold text-sm text-gray-800">{{ $review->user->name }}</span>
            <span class="text-xs text-gray-500">{{ $review->created_at->format('d/m/Y') }}</span>
          </div>
          <div class="text-yellow-400 text-sm">
            @for ($i = 1; $i <= 5; $i++)
              @if ($i <= $review->rating)
                ★
              @else
                ☆
              @endif
            @endfor
          </div>
          @if ($review->comment)
            <p class="text-gray-700 text-sm mt-1">{{ $review->comment }}</p>
          @endif
        </li>
      @endforeach
    </ul>
  </div>
@else
  <div class="bg-white p-6 rounded shadow mt-8 text-sm text-gray-600">
    Nenhuma avaliação ainda. Seja o primeiro a avaliar!
  </div>
@endif