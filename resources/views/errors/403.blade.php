<x-guest-layout>
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>403</h1>
            <h2>Unauthorized access detected. Access denied – try knocking next time.</h2>
            <button onclick="window.history.back()" class="btn">Go Back</button>
            <img src="{{ asset('img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
        </section>
    </div>
</x-guest-layout>
