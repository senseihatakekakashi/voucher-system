<form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation">
    @csrf
    
    <div class="col-12"> 
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')"/>
    </div>

    <div class="col-12">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" />
    </div>

    <div class="col-12">
        <x-button class="btn-primary w-100">
            {{ __('Log in') }}
        </x-button>
    </div>
    
    <div class="col-12">
        <p class="small mb-0">Don't have account? <a href="{{ route('register') }}">Create an account</a></p>
    </div>
</form>