<x-layout menu="8" titulo="Inicio">
    <div class="display">
        <h2 style="font-weight: 500; font-size: 5vh;position: relative; top: 45vh; text-align: center; color: white; text-shadow: 0px 0px 5px rgba(255,255,255,0.5);">{{ __('Bienvenido') }} {{auth()->user()->user}}</h2>
    </div>
</x-layout>
