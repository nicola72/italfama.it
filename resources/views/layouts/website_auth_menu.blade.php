<li>
	<span>
        <span style="color:#fff;">Benvenuto {{Auth::user()->name}}&nbsp;</span>
		<a href='{{route('website.logout',['locale' => app()->getLocale()])}}'>
			<i class="fa fa-sign-out"></i>
			&nbsp;&nbsp;
            <span class="hidden-xs text-capitalize">@lang('msg.logout')</span>
		</a>
        <small class="hidden-xs"> | </small>

        <a href='{{url(app()->getLocale().'/order')}}' title="@lang('msg.miei_ordini')">
            <i class="fa fa-book"></i>
            <span class="hidden-xs text-capitalize">
                &nbsp;&nbsp;
                @lang('msg.miei_ordini')
            </span>
        </a>
    </span>
</li>
