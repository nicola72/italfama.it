<form action="" method="get" id="form_ordinamento" style="margin-top:10px;">

    <!-- se Pagina Abbinamenti -->
    @if($pairings)
        <input type="hidden" id="order" name="order">
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|ASC') ? 'underline' : '' }}" onclick="ordina('prezzo|ASC')">
            @lang('msg.prezzo_dal_piu_basso')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|DESC') ? 'underline' : '' }}" onclick="ordina('prezzo|DESC')">
            @lang('msg.prezzo_dal_piu_alto')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'codice|ASC') ? 'underline' : '' }}" onclick="ordina('codice|ASC')">
            @lang('msg.codice_dalla_a_alla_z')
        </div>
    @endif
    <!-- -->

    <!-- se Pagina Prodotti singoli -->
    @if($products)
        <input type="hidden" id="order" name="order">
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|ASC') ? 'underline' : '' }}" onclick="ordina('prezzo|ASC')">
            @lang('msg.prezzo_dal_piu_basso')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|DESC') ? 'underline' : '' }}" onclick="ordina('prezzo|DESC')">
            @lang('msg.prezzo_dal_piu_alto')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'nome|ASC') ? 'underline' : '' }}" onclick="ordina('nome|ASC')">
            @lang('msg.nome_dalla_a_alla_z')
        </div>
    @endif
    <!-- -->

    <!-- per la pagina Catalogo TUTTI I PRODOTTI -->
    @if(!$pairings && !$products)
        <input type="hidden" id="order" name="order">
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|ASC') ? 'underline' : '' }}" onclick="ordina('prezzo|ASC')">
            @lang('msg.prezzo_dal_piu_basso')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'prezzo|DESC') ? 'underline' : '' }}" onclick="ordina('prezzo|DESC')">
            @lang('msg.prezzo_dal_piu_alto')
        </div>
        <div class="cursor pl-15 {{ ($ordinamento == 'nome|ASC') ? 'underline' : '' }}" onclick="ordina('nome|ASC')">
            @lang('msg.nome_dalla_a_alla_z')
        </div>
    @endif
    <!-- -->
</form>
<style type="text/css">
    .cursor{cursor: pointer;}
    .pl-15{padding-left: 15px;}
    .underline{text-decoration: underline;}
</style>
