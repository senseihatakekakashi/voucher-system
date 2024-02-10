<x-app-layout>
    <div class="pagetitle mb-5">
        <h1>{{ __('Users') }}</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Assign User to Group') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12 mb-3">
                <x-section-card title="Selected User:">
                    <h5>
                        <span class="badge rounded-pill bg-primary">{{ Auth::user()->name }}</span>
                    </h5>
                </x-section-card>
            </div>
            <div class="col-12">
                <x-section-card title="Select a Group:">
                    <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation">
                        @csrf
                        <div class="col-12 border rounded-2 p-3 switch-list-box-card">
                            <x-radio-input id="group-1" name="groups" value="Group 1">
                                {{ __('Group 1') }}
                            </x-radio-input>
                            <x-radio-input id="group-2" name="groups" value="Group 2">
                                {{ __('Group 2') }}
                            </x-radio-input>
                            <x-radio-input id="group-3" name="groups" value="Group 3">
                                {{ __('Group 3') }}
                            </x-radio-input>
                            <x-radio-input id="group-4" name="groups" value="Group 4">
                                {{ __('Group 4') }}
                            </x-radio-input>
                            <x-radio-input id="group-5" name="groups" value="Group 5">
                                {{ __('Group 5') }}
                            </x-radio-input>
                        </div>
                    
                        <div class="col-12">
                            <x-button class="btn-primary w-100">
                                {{ __('Assign') }}
                            </x-button>
                        </div>
                    </form>
                </x-section-card>
            </div>
        </div>
    </section>
</x-app-layout>