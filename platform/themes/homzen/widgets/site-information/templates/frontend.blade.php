<div class="col-lg-4 col-md-6">
    <div class="footer-cl-1">
        <p class="text-variant-2">{!! BaseHelper::clean($config['about']) !!}</p>
        @if($items->isNotEmpty())
            <ul class="mt-12">
                @foreach($items as $item)
                    @php
                        $text = trim($item['text']);
                    @endphp
                    @if($text !== '101 E 129th St, East Chicago, IN 46312, US')
                        <li class="mt-12 d-flex align-items-center gap-8">
                            <x-core::icon :name="$item['icon']"
                                class="text-variant-2"
                                style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;" />
                            <p class="text-white">{!! BaseHelper::clean(nl2br($text)) !!}</p>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
</div>
