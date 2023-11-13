<x-layout titulo='Asignar' menu='7' import1="../css/styleAsignarMenu.css">>
    <div class="display">
        <h2 class="titleText">{{ __("Asignar") }}</h2>
        <div class="btnContainer">
            <a href="{{ route('lleva.index') }}" class="submitBtn">{{ __("Asignar Lleva") }}</a>
            <a href="{{ route('reparte.index') }}" class="submitBtn">{{ __("Asignar Reparte") }}</a>
            <a href="{{ route('trae.index') }}" class="submitBtn">{{ __("Asignar Trae") }}</a>
        </div>
        <div class="btnContainer">
            <a href="{{ route('lleva.desasignar') }}" class="submitBtn">{{ __("Desasignar Lleva") }}</a>
            <a href="{{ route('reparte.desasignar') }}" class="submitBtn">{{ __("Desasignar Reparte") }}</a>
            <a href="{{ route('trae.desasignar') }}" class="submitBtn">{{ __("Desasignar Trae") }}</a>
        </div>
    </div>
</x-layout>
