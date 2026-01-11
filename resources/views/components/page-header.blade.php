<div class="flex items-center justify-between w-full">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $title ?? $slot }}</h1>
    </div>
    <div class="flex items-center space-x-2">
        @isset($actions)
            {{ $actions }}
        @endisset
    </div>
</div>
