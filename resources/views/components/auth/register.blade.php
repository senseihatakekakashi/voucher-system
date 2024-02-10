<form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation">
    @csrf
    <div class="col-12">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div class="col-12">    
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" />
    </div>

    <div class="col-12">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" />
    </div>

    <div class="col-12">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" />
    </div>

    <div class="col-12">
        <x-button class="btn-primary w-100">
            {{ __('Create Account') }}
        </x-button>
    </div>

    <div class="col-12">
        <p class="small mb-0">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    </div>
</form>