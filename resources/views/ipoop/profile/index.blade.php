<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">Meu Perfil</h2>
  </x-slot>

  <div class="px-4 py-6 max-w-7xl mx-auto space-y-6">

    <div class="mb-4">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-800">
            ← Voltar
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow">
      <h3 class="text-lg font-semibold mb-4">Olá, {{ $user->name }}</h3>
      <a href="{{ route('profile.edit') }}" class="text-purple-600 hover:underline">Editar Perfil</a>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
      <a href="{{ route('profile.restrooms') }}" class="bg-purple-50 hover:bg-purple-100 p-6 rounded shadow text-center">
        <h4 class="text-lg font-semibold text-purple-700">Meus Banheiros</h4>
        <p class="text-gray-600 mt-2">Veja os banheiros que você cadastrou</p>
      </a>

      <a href="{{ route('profile.reviews') }}" class="bg-purple-50 hover:bg-purple-100 p-6 rounded shadow text-center">
        <h4 class="text-lg font-semibold text-purple-700">Minhas Avaliações</h4>
        <p class="text-gray-600 mt-2">Gerencie suas avaliações</p>
      </a>
    </div>
  </div>
</x-app-layout>
