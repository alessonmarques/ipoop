@if (!$restroom->approved)
    <div class="bg-white p-6 rounded shadow mt-6">
        <p class="text-gray-600">Este banheiro ainda não foi aprovado.</p>
    </div>
@else

    <div class="mt-6">
        @include('ipoop.reviews._list', ['restroom' => $restroom])
    </div>

    <div class="mt-6">
        @include('ipoop.reviews._form', ['restroom' => $restroom])
    </div>

@endif