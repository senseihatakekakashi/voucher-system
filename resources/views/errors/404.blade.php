<x-guest-layout>
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>404</h1>
            <h2>Page not found. Maybe it's on a coffee break?</h2>
            <button onclick="window.history.back()" class="btn">Go Back</button>
            <img src="{{ asset('img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
        </section>
    </div>
</x-guest-layout>
