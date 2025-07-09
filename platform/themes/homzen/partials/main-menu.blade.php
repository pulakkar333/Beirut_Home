<ul{!! BaseHelper::clean($options) !!}>
    @foreach ($menu_nodes as $key => $row)
        @php
            $title = Str::lower($row->title);

            /* ----------------------------------------------------
             | 1. Skip (“disable”) unwanted top-level items
             ---------------------------------------------------- */
            // Skip "Projects"
            if ($title === 'projects') continue;

            // Skip "Home" if it has children
            if ($title === 'home' && $row->has_child) continue;

            /* ----------------------------------------------------
             | 2. Filter “Pages” → keep only five sub-items
             ---------------------------------------------------- */
            $limitedChildren = null;
            if ($title === 'pages' && $row->has_child) {
                $allowedSubmenus = ['Our Services', 'Contact Us', 'FAQs', 'Privacy Policy', 'About Us'];
                $limitedChildren = $row->child->filter(
                    fn($child) => in_array($child->title, $allowedSubmenus)
                );
            }

            /* ----------------------------------------------------
             | 3. Special handling for “Blog”
             |    – Hide its submenu
             |    – Force link to Blog-list page
             ---------------------------------------------------- */
            $isBlog = $title === 'blog';
            $blogListUrl = url('blog');                    // adjust if your blog list route is different
            $rowUrl      = $isBlog ? $blogListUrl : $row->url;
        @endphp

        <li
            @class([
                'dropdown2' => $row->has_child && ! $isBlog,   // no dropdown class for Blog
                'current'   => $row->active,
                $row->css_class,
            ])>
            <a href="{{ $rowUrl }}" target="{{ $row->target }}">
                {!! BaseHelper::clean($row->icon_html) !!}
                {{ $row->title }}
            </a>

            {{-- Render submenu only when it exists
                 AND the item is not Blog (Blog submenu is disabled) --}}
            @if ($row->has_child && ! $isBlog)
                {!! Menu::generateMenu([
                    'menu'        => $menu,
                    'menu_nodes'  => $limitedChildren ?: $row->child,
                    'view'        => 'main-menu',
                ]) !!}
            @endif
        </li>
    @endforeach
</ul>
