<!-- Botão flutuante de Filtros -->
<button id="toggleFilters"
  class="absolute top-4 right-6 z-[10000] bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow">
  Filtros
</button>

<!-- Painel de filtros oculto -->
<div id="filterPanel"
  class="fixed top-4 right-0 h-[90vh] w-64 bg-white shadow-lg z-[10000] transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between">

  <!-- Cabeçalho -->
  <div class="p-4 border-b flex justify-between items-center">
    <h2 class="font-bold text-lg">Filtros</h2>
    <button id="closeFilters" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
  </div>

  <!-- Formulário com área de scroll -->
  <form id="filterForm" class="flex-1 overflow-y-auto p-4 space-y-2">
    <label class="block">
      <input type="checkbox" name="accessible" class="mr-1"> Acessível
    </label>
    <label class="block">
      <input type="checkbox" name="public" class="mr-1"> Público
    </label>
    <label class="block">
      <input type="checkbox" name="private" class="mr-1"> Privado
    </label>
  </form>

  <!-- Rodapé fixo com botão -->
  <div class="p-4 border-t bg-white">
    <button type="submit" form="filterForm"
      class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded font-semibold">
      Aplicar Filtros
    </button>
  </div>
</div>


@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('toggleFilters');
    const closeBtn = document.getElementById('closeFilters');
    const filterPanel = document.getElementById('filterPanel');
    const filterForm = document.getElementById('filterForm');

    if (toggleBtn && filterPanel) {
      toggleBtn.addEventListener('click', () => {
        filterPanel.classList.remove('translate-x-full');
        filterPanel.classList.add('translate-x-0');
      });
    }

    if (closeBtn && filterPanel) {
      closeBtn.addEventListener('click', () => {
        filterPanel.classList.remove('translate-x-0');
        filterPanel.classList.add('translate-x-full');
      });
    }

    if (filterForm) {
      filterForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const filters = {
          accessible: filterForm.accessible.checked,
          public: filterForm.public.checked,
          private: filterForm.private.checked
        };

        console.log('Filtros aplicados:', filters);

        filterPanel.classList.remove('translate-x-0');
        filterPanel.classList.add('translate-x-full');
      });
    }
  });
</script>
@endpush
