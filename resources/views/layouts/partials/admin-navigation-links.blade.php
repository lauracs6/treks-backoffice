@props(['component'])

@foreach ([
    ['route' => 'admin.treks.index', 'active' => 'admin.treks.*', 'label' => __('Treks')],
    ['route' => 'admin.meetings.index', 'active' => 'admin.meetings.*', 'label' => __('Meetings')],        
    ['route' => 'admin.municipalities.index', 'active' => 'admin.municipalities.*', 'label' => __('Municipalities')],
    ['route' => 'admin.places.index', 'active' => 'admin.places.*', 'label' => __('Places')],
    ['route' => 'admin.users.index', 'active' => 'admin.users.*', 'label' => __('Users')],
    ['route' => 'admin.comments.index', 'active' => 'admin.comments.*', 'label' => __('Comments')]
] as $item)
    <x-dynamic-component :component="$component" :href="route($item['route'])" :active="request()->routeIs($item['active'])">
        {{ $item['label'] }}
    </x-dynamic-component>
@endforeach
