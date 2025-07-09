{!! apply_filters('real_estate_account_dashboard_sidebar_menu_before', null) !!}

@php
    $disabledMenus = ['buy credits', 'consults', 'invoices'];
@endphp

<ul class="menu">
    @foreach (DashboardMenu::getAll('account') as $item)
        @continue(! $item['name'])

        @php
            $name = strtolower(trim(__($item['name'])));
        @endphp

        @continue(in_array($name, $disabledMenus))
        
        <li>
            <a href="{{ $item['url'] }}" @class(['active' => $item['active']])>
                <x-core::icon :name="$item['icon']" />
                {{ __($item['name']) }}
            </a>
        </li>
    @endforeach
</ul>

{!! apply_filters('real_estate_account_dashboard_sidebar_menu_after', null) !!}
