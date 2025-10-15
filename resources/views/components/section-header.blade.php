@props([
    'badge' => null,
    'title',
    'description' => null,
    'align' => 'center'
])

<div class="text-{{ $align }} mb-8 sm:mb-12" data-aos="fade-down">
    @if($badge)
        <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
            {{ $badge }}
        </p>
    @endif
    
    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark mb-3">
        {{ $title }}
    </h2>
    
    @if($description)
        <p class="text-sm sm:text-base lg:text-lg text-gray-600 max-w-2xl {{ $align === 'center' ? 'mx-auto' : '' }}" 
           data-aos="fade-up" data-aos-delay="100">
            {{ $description }}
        </p>
    @endif
</div>
