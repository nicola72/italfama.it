<form id="form_filtro" method="get" action="" style="margin-top:10px;" class="pl-15">
    <input type="hidden" id="filter" name="filter">
    <b>@lang('msg.stile')</b>

    <!-- STILI -->
    @foreach($styles as $style)
        <div class="cursor pl-15 {{ ($filtro == 'style|'.$style->id) ? 'underline' : '' }}" onclick="filtra('{{ 'style|'.$style->id }}')">
            {{ $style->{'nome_'.app()->getLocale()} }}
        </div>
    @endforeach
    <!-- -->

    <!-- Filtri materiali solo per la categoria SCACCHI E SCACCHIERA -->
    @if($category && $category->id != '89')
        <b>@lang('msg.materiale_scacchi')</b>

        <!-- MATERIALE SCACCHI -->
        @foreach($chess_materials as $material)
            <div class="cursor pl-15 {{ ($filtro == 'material_chess|'.$material->id) ? 'underline' : '' }}" onclick="filtra('{{ 'material_chess|'.$material->id }}')">
                {{ $material->{'nome_'.app()->getLocale()} }}
            </div>
        @endforeach
        <!-- -->

        <!-- MATERIALE SCACCHIERA -->
        <b>@lang('msg.materiale_scacchiera')</b>
        @foreach($board_materials as $material)
            <div class="cursor pl-15 {{ ($filtro == 'material_board|'.$material->id) ? 'underline' : '' }}" onclick="filtra('{{ 'material_board|'.$material->id }}')">
                {{ $material->{'nome_'.app()->getLocale()} }}
            </div>
        @endforeach
        <!-- -->
    @endif
</form>
<style type="text/css">
    #form_filtro .cursor:hover, #form_ordinamento .cursor:hover{ color: #840025; }
</style>