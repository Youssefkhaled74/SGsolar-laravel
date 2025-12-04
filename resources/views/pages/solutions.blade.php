@extends('layouts.app')

@section('title', __('website.solutions.title'))

@section('content')
<!-- Solutions Hero -->
<section class="solutions-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.solutions.title') }}</h1>
        <p class="section-subtitle">{{ __('website.solutions.subtitle') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Main Solutions Tabs -->
<section class="solutions-tabs-section">
    <div class="container">
        <!-- Main Category Tabs -->
        <div class="main-tabs">
            <button class="main-tab-btn active" data-tab="solar-energy">
                <i class="fas fa-solar-panel"></i>
                <span>{{ __('website.solutions.solar_energy.title') }}</span>
            </button>
            <button class="main-tab-btn" data-tab="swh">
                <i class="fas fa-fire"></i>
                <span>{{ __('website.solutions.swh.title') }}</span>
            </button>
            <button class="main-tab-btn" data-tab="solar-lights">
                <i class="fas fa-lightbulb"></i>
                <span>{{ __('website.solutions.solar_lights.title') }}</span>
            </button>
        </div>

        <!-- Solar Energy Tab Content -->
        <div class="tab-content active" id="solar-energy">
            <div class="tab-header">
                <h2>{{ __('website.solutions.solar_energy.subtitle') }}</h2>
            </div>

            <!-- Solar Energy Sub-Tabs -->
            <div class="sub-tabs">
                <button class="sub-tab-btn active" data-subtab="on-grid">
                    {{ __('website.solutions.solar_energy.on_grid.title') }}
                </button>
                <button class="sub-tab-btn" data-subtab="off-grid">
                    {{ __('website.solutions.solar_energy.off_grid.title') }}
                </button>
                <button class="sub-tab-btn" data-subtab="hybrid">
                    {{ __('website.solutions.solar_energy.hybrid.title') }}
                </button>
                <button class="sub-tab-btn" data-subtab="pumping">
                    {{ __('website.solutions.solar_energy.pumping.title') }}
                </button>
            </div>

            <!-- On-Grid System -->
            <div class="sub-tab-content active" id="on-grid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h3 class="solution-title">{{ __('website.solutions.solar_energy.on_grid.name') }}</h3>
                    <p class="solution-subtitle">{{ __('website.solutions.solar_energy.on_grid.subtitle') }}</p>
                    <p class="solution-intro">{{ __('website.solutions.solar_energy.on_grid.intro') }}</p>

                    <h4 class="solution-section-title">
                        <i class="fas fa-cog"></i>
                        {{ __('website.solutions.solar_energy.on_grid.how_it_works') }}
                    </h4>
                    <ul class="solution-steps">
                        @foreach(__('website.solutions.solar_energy.on_grid.steps') as $step)
                        <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    <h4 class="solution-section-title">
                        <i class="fas fa-star"></i>
                        {{ __('website.solutions.solar_energy.on_grid.benefits_title') }}
                    </h4>
                    <ul class="solution-benefits">
                        @foreach(__('website.solutions.solar_energy.on_grid.benefits') as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Off-Grid System -->
            <div class="sub-tab-content" id="off-grid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-battery-full"></i>
                    </div>
                    <h3 class="solution-title">{{ __('website.solutions.solar_energy.off_grid.name') }}</h3>
                    <p class="solution-subtitle">{{ __('website.solutions.solar_energy.off_grid.subtitle') }}</p>
                    <p class="solution-intro">{{ __('website.solutions.solar_energy.off_grid.intro') }}</p>

                    <h4 class="solution-section-title">
                        <i class="fas fa-cog"></i>
                        {{ __('website.solutions.solar_energy.off_grid.how_it_works') }}
                    </h4>
                    <ul class="solution-steps">
                        @foreach(__('website.solutions.solar_energy.off_grid.steps') as $step)
                        <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    <h4 class="solution-section-title">
                        <i class="fas fa-star"></i>
                        {{ __('website.solutions.solar_energy.off_grid.benefits_title') }}
                    </h4>
                    <ul class="solution-benefits">
                        @foreach(__('website.solutions.solar_energy.off_grid.benefits') as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Hybrid System -->
            <div class="sub-tab-content" id="hybrid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3 class="solution-title">{{ __('website.solutions.solar_energy.hybrid.name') }}</h3>
                    <p class="solution-subtitle">{{ __('website.solutions.solar_energy.hybrid.subtitle') }}</p>
                    <p class="solution-intro">{{ __('website.solutions.solar_energy.hybrid.intro') }}</p>

                    <h4 class="solution-section-title">
                        <i class="fas fa-cog"></i>
                        {{ __('website.solutions.solar_energy.hybrid.how_it_works') }}
                    </h4>
                    <ul class="solution-steps">
                        @foreach(__('website.solutions.solar_energy.hybrid.steps') as $step)
                        <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    <h4 class="solution-section-title">
                        <i class="fas fa-star"></i>
                        {{ __('website.solutions.solar_energy.hybrid.benefits_title') }}
                    </h4>
                    <ul class="solution-benefits">
                        @foreach(__('website.solutions.solar_energy.hybrid.benefits') as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Pumping System -->
            <div class="sub-tab-content" id="pumping">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3 class="solution-title">{{ __('website.solutions.solar_energy.pumping.name') }}</h3>
                    <p class="solution-subtitle">{{ __('website.solutions.solar_energy.pumping.subtitle') }}</p>
                    <p class="solution-intro">{{ __('website.solutions.solar_energy.pumping.intro') }}</p>

                    <h4 class="solution-section-title">
                        <i class="fas fa-cog"></i>
                        {{ __('website.solutions.solar_energy.pumping.how_it_works') }}
                    </h4>
                    <ul class="solution-steps">
                        @foreach(__('website.solutions.solar_energy.pumping.steps') as $step)
                        <li>{{ $step }}</li>
                        @endforeach
                    </ul>

                    <h4 class="solution-section-title">
                        <i class="fas fa-star"></i>
                        {{ __('website.solutions.solar_energy.pumping.benefits_title') }}
                    </h4>
                    <ul class="solution-benefits">
                        @foreach(__('website.solutions.solar_energy.pumping.benefits') as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- SWH Tab Content -->
        <div class="tab-content" id="swh">
            <div class="tab-header">
                <h2>{{ __('website.solutions.swh.subtitle') }}</h2>
                <p>{{ __('website.solutions.swh.intro') }}</p>
            </div>

            <div class="swh-content">
                <!-- Components Section -->
                <div class="swh-section">
                    <h3 class="swh-section-title">
                        <i class="fas fa-tools"></i>
                        {{ __('website.solutions.swh.components_title') }}
                    </h3>
                    <ul class="swh-list">
                        @foreach(__('website.solutions.swh.components') as $component)
                        <li>{{ $component }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Types Section -->
                <div class="swh-section">
                    <h3 class="swh-section-title">
                        <i class="fas fa-layer-group"></i>
                        {{ __('website.solutions.swh.types_title') }}
                    </h3>

                    <div class="swh-types-grid">
                        <!-- Flat Plate -->
                        <div class="swh-type-card">
                            <div class="swh-type-icon">
                                <i class="fas fa-square"></i>
                            </div>
                            <h4>{{ __('website.solutions.swh.types.flat_plate.name') }}</h4>
                            <p class="swh-type-label">{{ __('website.solutions.swh.types.flat_plate.title') }}</p>
                            <div class="swh-type-detail">
                                <strong>البنية:</strong>
                                <p>{{ __('website.solutions.swh.types.flat_plate.structure') }}</p>
                            </div>
                            <div class="swh-type-detail">
                                <strong>الكفاءة:</strong>
                                <p>{{ __('website.solutions.swh.types.flat_plate.efficiency') }}</p>
                            </div>
                            <div class="swh-type-detail">
                                <strong>الميزة التقنية:</strong>
                                <p>{{ __('website.solutions.swh.types.flat_plate.advantage') }}</p>
                            </div>
                        </div>

                        <!-- Evacuated Tube -->
                        <div class="swh-type-card">
                            <div class="swh-type-icon">
                                <i class="fas fa-grip-lines-vertical"></i>
                            </div>
                            <h4>{{ __('website.solutions.swh.types.evacuated_tube.name') }}</h4>
                            <p class="swh-type-label">{{ __('website.solutions.swh.types.evacuated_tube.title') }}</p>
                            <div class="swh-type-detail">
                                <strong>البنية:</strong>
                                <p>{{ __('website.solutions.swh.types.evacuated_tube.structure') }}</p>
                            </div>
                            <div class="swh-type-detail">
                                <strong>الكفاءة:</strong>
                                <p>{{ __('website.solutions.swh.types.evacuated_tube.efficiency') }}</p>
                            </div>
                            <div class="swh-type-detail">
                                <strong>الميزة التقنية:</strong>
                                <p>{{ __('website.solutions.swh.types.evacuated_tube.advantage') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Working Principle -->
                <div class="swh-section">
                    <h3 class="swh-section-title">
                        <i class="fas fa-sync-alt"></i>
                        مبدأ العمل والدوران الحراري
                    </h3>
                    <p class="swh-principle">{{ __('website.solutions.swh.working_principle') }}</p>
                </div>
            </div>
        </div>

        <!-- Solar Lights Tab Content -->
        <div class="tab-content" id="solar-lights">
            <div class="tab-header">
                <h2>{{ __('website.solutions.solar_lights.subtitle') }}</h2>
                <p>{{ __('website.solutions.solar_lights.intro') }}</p>
            </div>

            <div class="solar-lights-content">
                <!-- Components Section -->
                <div class="lights-section">
                    <h3 class="lights-section-title">
                        <i class="fas fa-tools"></i>
                        {{ __('website.solutions.solar_lights.components_title') }}
                    </h3>
                    <ul class="lights-list">
                        @foreach(__('website.solutions.solar_lights.components') as $component)
                        <li>{{ $component }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Categories Section -->
                <div class="lights-section">
                    <h3 class="lights-section-title">
                        <i class="fas fa-th-large"></i>
                        {{ __('website.solutions.solar_lights.categories_title') }}
                    </h3>

                    <div class="lights-categories-grid">
                        @foreach(__('website.solutions.solar_lights.categories') as $key => $category)
                        <div class="light-category-card">
                            <div class="light-icon">
                                @if($key == 'residential')
                                    <i class="fas fa-home"></i>
                                @elseif($key == 'street')
                                    <i class="fas fa-road"></i>
                                @else
                                    <i class="fas fa-shield-alt"></i>
                                @endif
                            </div>
                            <h4>{{ $category['name'] }}</h4>
                            <p class="light-label">{{ $category['title'] }}</p>
                            <div class="light-detail">
                                <strong>الاستخدام:</strong>
                                <p>{{ $category['usage'] }}</p>
                            </div>
                            <div class="light-detail">
                                <strong>المميزات التقنية:</strong>
                                <p>{{ $category['features'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Advantages Section -->
                <div class="lights-section">
                    <h3 class="lights-section-title">
                        <i class="fas fa-check-circle"></i>
                        {{ __('website.solutions.solar_lights.advantages_title') }}
                    </h3>
                    <ul class="lights-advantages">
                        @foreach(__('website.solutions.solar_lights.advantages') as $advantage)
                        <li>{{ $advantage }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main Tabs
    const mainTabBtns = document.querySelectorAll('.main-tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    mainTabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');
            
            mainTabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            btn.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Sub Tabs (for Solar Energy)
    const subTabBtns = document.querySelectorAll('.sub-tab-btn');
    const subTabContents = document.querySelectorAll('.sub-tab-content');

    subTabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const subTabId = btn.getAttribute('data-subtab');
            
            subTabBtns.forEach(b => b.classList.remove('active'));
            subTabContents.forEach(c => c.classList.remove('active'));
            
            btn.classList.add('active');
            document.getElementById(subTabId).classList.add('active');
        });
    });
});
</script>
@endsection
