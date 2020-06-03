<!-- SE ABBINAMENTI -->
@if($pairings)
    <!-- PAGINATORE -->
    {{$pairings->links('website.pagination.default')}}
    <!-- -->

    @foreach($pairings as $pairing)
        @include('website.page.partials.box_abbinamento')
    @endforeach

    <!-- PAGINATORE -->
    {{$pairings->links('website.pagination.default')}}
    <!-- -->
@endif
<!-- -->

<!-- SE PRODOTTI SINGOLI -->
@if($products)
    <!-- PAGINATORE -->
    {{$products->links('website.pagination.default')}}
    <!-- -->

    @foreach($products as $product)
        @include('website.page.partials.box_prodotto')
    @endforeach

    <!-- PAGINATORE -->
    {{$products->links('website.pagination.default')}}
    <!-- -->
@endif
<!-- -->