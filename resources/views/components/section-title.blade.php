@props(['title', 'subtitle' => null, 'centered' => true])

<div class="section-title {{ $centered ? 'text-center' : '' }}">
    <h2 class="section-title-main">{{ $title }}</h2>
    @if($subtitle)
        <p class="section-title-subtitle">{{ $subtitle }}</p>
    @endif
</div>
