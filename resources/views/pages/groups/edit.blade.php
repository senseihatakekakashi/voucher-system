<x-app-layout>
    <!-- Page Title and Breadcrumbs -->
    <div class="pagetitle mb-5">
        <h1>{{ __('Groups') }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Update a Group') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Section for Modifying a Group Name -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <!-- Section Card for Modifying a Group Name -->
                <x-section-card title="{{ __('Modify a Group Name') }}">
                    <!-- Form for Updating a Group -->
                    <form method="POST" action="{{ route('groups.update', $group) }}" class="row g-3 needs-validation">
                        @csrf
                        @method('PUT')
                        
                        <!-- Input Field for Group Name -->
                        <div class="col-6">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="$group->name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        
                        <!-- Cancel Button -->
                        <div class="col-3 d-flex align-items-end">
                            <x-button class="btn-secondary w-100" type="button" onclick="location.href = '{{ route('groups.index') }}';">
                                {{ __('Cancel') }}
                            </x-button>
                        </div>
                        
                        <!-- Save Button -->
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