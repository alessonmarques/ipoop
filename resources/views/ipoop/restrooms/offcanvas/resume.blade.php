@push('styles')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

<!-- Backdrop -->
<div id="bottomSheetBackdrop"
    onclick="window.iPoop.map.closeBottomSheet()"
    class="fixed inset-0 bg-black bg-opacity-50 z-[10098] hidden"></div>

<!-- Bottom Offcanvas (Mobile Style) -->
<div id="bathroomBottomSheet"
     class="fixed bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full z-[10099]
            w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-3xl
            bg-white shadow-2xl rounded-t-2xl transition-transform duration-300 ease-in-out overflow-y-auto border-t border-gray-200">

    <!-- Header -->
    <div id="bottomSheetHeader"
        class="flex justify-between items-center px-4 py-3 border-b bg-purple-700 bg-blue-700 text-white rounded-t-2xl">
        <h2 id="bottomSheetTitle" class="text-lg font-semibold">Carregando banheiro...</h2>
        <button onclick="window.iPoop.map.closeBottomSheet()" class="text-2xl leading-none hover:text-gray-300">&times;</button>
    </div>

    <!-- Content -->
    <div class="p-4 space-y-4">
        <!-- Image -->
        <!-- <div id="imageCarousel" class="w-full h-48 rounded bg-gray-100 flex items-center justify-center text-gray-400">
            Carregando imagens...
        </div> -->
        <div id="imageCarousel" class="swiper w-full h-48 rounded overflow-hidden">
            <div class="swiper-wrapper" id="swiperWrapper">
                <!-- Slides injetados via JS -->
            </div>
            <!-- Navegação -->
            <div class="swiper-pagination"></div>
        </div>

        <!-- Accessibility -->
        <div id="accessibilityInfo" class="text-sm text-gray-700">
            ♿ Verificando acessibilidade...
        </div>

        <!-- Rating, Cost, Visibility -->
        <div class="text-sm text-gray-600" id="restroomMeta">
            <!-- preenchido via JS -->
        </div>

        <!-- Link para mais detalhes -->
        <div id="detailsLink" class="mt-2">
            <!-- preenchido via JS -->
        </div>


        <!-- Comentários -->
        <div id="commentsContainer" class="mt-4">
            <h3 class="text-md font-bold text-purple-700 mb-2">Comentários:</h3>
            <div id="commentList" class="space-y-3">
                <p class="text-sm text-gray-500">Carregando comentários...</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush
