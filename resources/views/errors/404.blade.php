<x-app-layout>
  <div class="flex flex-col items-center justify-center min-h-[70vh] text-center px-4 py-16">
    <h1 class="text-6xl font-bold text-purple-700 mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Página não encontrada</h2>
    <p class="text-gray-600 mb-6">
      A página que você está tentando acessar não existe ou foi removida.
    </p>
    <a href="{{ route('home') }}"
       class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded shadow-md transition">
      ← Voltar para a página inicial
    </a>
  </div>
</x-app-layout>