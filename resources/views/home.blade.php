<x-app-layout>

    <div class="flex flex-col h-[80vh] relative" style="z-index: 1;">
        <div class="absolute top-4 right-6 bg-white shadow rounded p-4 w-64" style="z-index:10000">
            <h2 class="font-bold text-lg mb-2">Filtros</h2>
            <form>
                <label class="block mb-1">
                <input type="checkbox" name="accessible" class="mr-1"> Acessível
                </label>
                <label class="block mb-1">
                <input type="checkbox" name="public" class="mr-1"> Público
                </label>
                <label class="block mb-1">
                <input type="checkbox" name="private" class="mr-1"> Privado
                </label>
            </form>
        </div>

        <a  href="/restrooms/create"
            class="absolute bottom-6 right-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-5 rounded shadow-lg"
            style="z-index:10000">
            + Adicionar Banheiro
        </a>

        <x-map />
    </div>


</x-app-layout>