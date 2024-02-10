<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <x-auth.header />
                <x-auth.card>
                    <x-auth.sub-header title="Login to Your Account" subTitle="Enter your username & password to login" />
                    <x-auth.login />
                </x-auth.card>
            </div>
        </div>
    </div>
</x-guest-layout>
