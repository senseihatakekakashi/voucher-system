<x-app-layout>
    <div class="pagetitle mb-5">
        <h1>{{ __('Groups') }}</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Update a Group') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <x-section-card title="{{ __('Modify a Group Name') }}">
                    <form method="POST" action="route" class="row g-3 needs-validation">
                        @csrf
                        <div class="col-6">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                    
                        <div class="col-3 d-flex align-items-end">
                            <x-button class="btn-secondary w-100">
                                {{ __('Cancel') }}
                            </x-button>
                        </div>
                        <div class="col-3 d-flex align-items-end">
                            <x-button class="btn-primary w-100">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </x-section-card>
            </div>
        </div>
    </section>
</x-app-layout>