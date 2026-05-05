<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gray-100 flex flex-col items-center py-10">

    <h1 class="text-3xl font-bold mb-6">URL Preview Tool</h1>

    <form method="POST" action="/parse" class="flex gap-2" onsubmit="showLoader()">
        @csrf
<div id="loader" class="hidden mt-4 text-gray-500">
    Cargando...
</div>

<script>
function showLoader() {
    document.getElementById('loader').classList.remove('hidden');
}
</script>

<div id="result">
    @if(isset($data))
        
    @endif
</div>
        <input 
            name="url" 
            placeholder="https://example.com"
            class="px-4 py-2 border rounded-lg w-80 focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

      <button 
    type="submit"
    class="bg-blue-500 hover:bg-blue-600 active:scale-95 transition-all text-white px-4 py-2 rounded-lg"
>
    Extraer
</button>
    </form>

    @if(isset($error))
        <p class="text-red-500 mt-4">{{ $error }}</p>
    @endif

    @if(isset($data))
    <div class="mt-8 w-[420px] bg-white rounded-xl shadow-md overflow-hidden">

        {{-- YouTube embed --}}
        @if(!empty($data['youtube']))
        <iframe 
            class="w-full h-56"
            src="https://www.youtube.com/embed/{{ $data['youtube'] }}"
            frameborder="0"
            allowfullscreen>
        </iframe>
        @elseif(!empty($data['image']))
        <img src="{{ $data['image'] }}" class="w-full h-56 object-cover">
        @endif

        <div class="p-4">

            <h2 class="text-lg font-semibold mb-2">
                {{ $data['title'] ?? 'Sin título' }}
            </h2>

            <p class="text-gray-600 text-sm">
                {{ $data['description'] ?? 'Sin descripción' }}
            </p>

            <div class="flex items-center gap-2 mt-4 text-xs text-gray-400">
                @if(!empty($data['favicon']))
                    <img src="{{ $data['favicon'] }}" class="w-4 h-4">
                @endif

                {{ parse_url(request()->input('url'), PHP_URL_HOST) }}
            </div>

        </div>
    </div>
    @endif

</div>