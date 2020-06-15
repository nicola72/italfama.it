<div class="panel panel-default">
    <div class="panel-heading fjalla" style="font-weight: 100;text-transform: uppercase;">
        @lang('msg.prodotti')
    </div>
    <div class="panel-body">
        <div class="collapse navbar-collapse navbar-ex2-collapse navbar-side-collapse">
            <ul class="nav navbar-nav side-nav fjalla">

                @php $count = 1 @endphp
                @foreach($macrocategorie as $macro)
                    <li class="categoria_li">
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#m_sez_{{$count}}" class="categoria text-uppercase">
                            {{$macro->{'nome_'.app()->getLocale()} }}<i class="fa fa-plus"></i>
                        </a>
                        <ul id="m_sez_{{$count}}" class="collapse collapseItem">
                            @foreach($macro->categories as $category)
                                <li>
                                    <a href="{{ url(app()->getLocale().'/categoria',['id'=>$category->id]) }}">
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                        {{ $category->{'nome_'.app()->getLocale()} }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @php $count++ @endphp
                @endforeach
            </ul>

        </div>
    </div>
</div>