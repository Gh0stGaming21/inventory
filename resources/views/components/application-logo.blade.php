<div class="logo-container" {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <img src="{{ asset('images/shelfiq_logo_nav.jpg') }}" alt="ShelfIQ Logo" class="max-h-16 object-contain" />
</div>

<style>
    .logo-container img {
        max-width: 100%;
        height: auto;
    }
    
    /* Adjust logo size based on context */
    .navbar-logo img {
        height: 4rem; /* Increased from 2.5rem */
        padding: 0.5rem 0; /* Added padding for better vertical alignment */
    }
    
    .auth-logo img {
        height: 6rem; /* Increased from 3.5rem */
        margin-bottom: 1rem; /* Added margin for better spacing */
    }
</style>
