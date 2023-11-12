<x-layout titulo='Inicio' menu='7' import1="../css/styleAsignarMenu.css">>
    <div class="display">
        <h2>Asignar</h2>
        <a href="{{ route('lleva.index') }}" class="submitBtn">Asignar Lleva</a>
        <a href="{{ route('reparte.index') }}" class="submitBtn">Asignar Reparte</a>
        <a href="{{ route('trae.index') }}" class="submitBtn">Asignar Trae</a>
        <a href="{{ route('lleva.desasignar') }}" class="submitBtn">Desasignar Lleva</a>
        <a href="{{ route('reparte.desasignar') }}" class="submitBtn">Desasignar Reparte</a>
        <a href="{{ route('trae.desasignar') }}" class="submitBtn">Desasignar Trae</a>
    </div>
</x-layout>
