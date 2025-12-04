@extends('layouts.app')

@section('title', __('website.projects.title'))

@section('content')
<!-- Projects Hero -->
<section class="projects-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.projects.title') }}</h1>
        <p class="section-subtitle">{{ __('website.projects.subtitle') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Projects Gallery -->
<section class="projects-gallery-section">
    <div class="container">
        <div class="projects-grid">
            @foreach(__('website.projects.items') as $index => $project)
            <div class="project-card">
                <div class="project-image-wrapper">
                    <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}" class="project-image">
                    <div class="project-overlay">
                        <button class="btn-view-project" onclick="openProjectModal({{ $index }})">
                            <i class="fas fa-eye"></i>
                            {{ __('website.projects.view_details') }}
                        </button>
                    </div>
                </div>
                <div class="project-info">
                    <h3 class="project-title">{{ $project['title'] }}</h3>
                    <p class="project-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $project['location'] }}
                    </p>
                    <div class="project-meta">
                        <span class="project-type">
                            <i class="fas fa-tag"></i>
                            {{ $project['type'] }}
                        </span>
                        <span class="project-capacity">
                            <i class="fas fa-bolt"></i>
                            {{ $project['capacity'] }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Project Modal -->
<div class="project-modal" id="projectModal">
    <div class="modal-overlay" onclick="closeProjectModal()"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeProjectModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-body">
            <div class="modal-image">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-info">
                <h2 id="modalTitle" class="modal-project-title"></h2>
                <p id="modalLocation" class="modal-project-location"></p>
                
                <div class="modal-details">
                    <div class="detail-item">
                        <i class="fas fa-tag"></i>
                        <div>
                            <strong>{{ __('website.projects.project_type') }}:</strong>
                            <span id="modalType"></span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-bolt"></i>
                        <div>
                            <strong>{{ __('website.projects.capacity') }}:</strong>
                            <span id="modalCapacity"></span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <strong>{{ __('website.projects.completion_date') }}:</strong>
                            <span id="modalDate"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-description">
                    <h3>{{ __('website.projects.description') }}</h3>
                    <p id="modalDescription"></p>
                </div>

                <div class="modal-features" id="modalFeatures">
                    <h3>{{ __('website.projects.project_features') }}</h3>
                    <ul id="modalFeaturesList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const projects = @json(__('website.projects.items'));

function openProjectModal(index) {
    const project = projects[index];
    const modal = document.getElementById('projectModal');
    
    document.getElementById('modalImage').src = project.image;
    document.getElementById('modalTitle').textContent = project.title;
    document.getElementById('modalLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> ' + project.location;
    document.getElementById('modalType').textContent = project.type;
    document.getElementById('modalCapacity').textContent = project.capacity;
    document.getElementById('modalDate').textContent = project.date;
    document.getElementById('modalDescription').textContent = project.description;
    
    const featuresList = document.getElementById('modalFeaturesList');
    featuresList.innerHTML = '';
    project.features.forEach(feature => {
        const li = document.createElement('li');
        li.innerHTML = '<i class="fas fa-check-circle"></i> ' + feature;
        featuresList.appendChild(li);
    });
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProjectModal() {
    const modal = document.getElementById('projectModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProjectModal();
    }
});
</script>
@endsection
