@auth
  <form action="{{ route('reports.store') }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="restroom_id" value="{{ $restroom->id }}">
    <label class="block mb-1 font-semibold">Denunciar:</label>
    <textarea name="reason" rows="2" class="w-full border rounded px-3 py-2 mb-2" placeholder="Motivo (opcional)"></textarea>
    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
      🚩 Enviar denúncia
    </button>
  </form>
@endauth