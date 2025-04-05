<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="fixed bottom-6 right-6 z-50 max-w-sm w-full"
>
    @if (session('success'))
        <div class="relative p-4 pr-10 bg-green-100 text-green-800 border border-green-300 rounded-lg shadow-lg text-sm font-medium">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="relative p-4 pr-10 bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-lg text-sm font-medium">
            <ul class="list-disc list-inside text-left pr-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>