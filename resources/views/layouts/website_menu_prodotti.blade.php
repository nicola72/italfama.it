<div class="panel panel-default">
    <div class="panel-heading fjalla" style="font-weight: 100;">
        <a href="{{ url(app()->getLocale().'/tutti_prodotti') }}" style="color: white;">
            @lang('msg.tutti_i_prodotti')
        </a>
    </div>
    <div class="panel-body">
        <div class="collapse navbar-collapse navbar-ex2-collapse navbar-side-collapse">
            <ul class="nav navbar-nav side-nav fjalla">


                <!-- Accrocchio per far passare le categorie della macro set completi come macro -->
                @foreach($macrocategorie as $macro)
                    @if($macro->id == 22)
                        @if($macro->categories)
                            @foreach($macro->categories as $category)
                                <li class="categoria_li">
                                    <a href="{{ url(app()->getLocale().'/categoria',['id'=>$category->id]) }}">
                                        {{$category->{'nome_'.app()->getLocale()} }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endif
                @endforeach
                <!-- -->

                <!-- Le altre macrocategorie -->
                @php $count = 1 @endphp
                @foreach($macrocategorie as $macro)

                    @if($macro->id != 22)
                        <li class="{{ ($count > 5) ? 'categoria_li_1':'categoria_li' }}" >
                            <a href="{{ url(app()->getLocale().'/macrocategoria',['id'=>$macro->id]) }}" data-toggle="collapse" data-target="#sez_{{$count}}" class="categoria text-uppercase" >
                                {{$macro->{'nome_'.app()->getLocale()} }}
                                <i class="fa fa-plus"></i>
                            </a>
                            <ul id="sez_{{$count}}" class="{{ ($macro_request == $macro->id) ? '':'collapse' }} collapseItem">
                                @foreach($macro->categories as $category)
                                    <li>
                                        <a href="{{ url(app()->getLocale().'/categoria',['id'=>$category->id]) }}" class="text-uppercase">
                                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            {{$category->{'nome_'.app()->getLocale()} }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @php $count++ @endphp
                @endforeach
            </ul>
        </div>
    </div>
</div>