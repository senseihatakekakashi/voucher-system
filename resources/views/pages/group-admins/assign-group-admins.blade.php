<x-app-layout>
    <div class="pagetitle mb-5">
        <x-button class="btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#add-new-group">
            <i class="bi bi-plus me-1"></i>
            {{ __('Assign a Group') }}
        </x-button>
        <h1>{{ __('Group Admins') }}</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Assign Group Admin to Groups') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12 mb-3">
                <x-section-card title="Selected Group Admin:">
                    <h5>
                        <span class="badge rounded-pill bg-primary">{{ Auth::user()->name }}</span>
                    </h5>
                </x-section-card>
            </div>
            <div class="col-12">
                <x-section-card title="{{ __('Assigned Group List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Group Name</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Group 1</td>
                                <td>
                                    <form id="deleteForm1" method="POST" action="delete.route/1" class="d-inline">
                                        @csrf
                                        @method('delete')
                                    
                                        <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="1">
                                            {{ __('Remove From the Group') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>Group 2</td>
                                <td>
                                    <form id="deleteForm2" method="POST" action="delete.route/2" class="d-inline">
                                        @csrf
                                        @method('delete')
                                    
                                        <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="2">
                                            {{ __('Remove From the Group') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>                                        
                </x-section-card>
            </div>
        </div>
    </section>
    <x-modal id="add-new-group" title="Assign [Group Admin] to a Group" size="modal-md">
        <div class="card p-4 m-4">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation">
                    @csrf
                    <div class="col-12 border rounded-2 p-3 switch-list-box-card">
                        <x-switch-input id="group-1" name="groups[]" value="Group 1">
                            {{ __('Group 1') }}
                        </x-switch-input>
                        <x-switch-input id="group-2" name="groups[]" value="Group 2">
                            {{ __('Group 2') }}
                        </x-switch-input>
                        <x-switch-input id="group-3" name="groups[]" value="Group 3">
                            {{ __('Group 3') }}
                        </x-switch-input>
                        <x-switch-input id="group-4" name="groups[]" value="Group 4">
                            {{ __('Group 4') }}
                        </x-switch-input>
                        <x-switch-input id="group-5" name="groups[]" value="Group 5">
                            {{ __('Group 5') }}
                        </x-switch-input>
                    </div>
                
                    <div class="col-12">
                        <x-button class="btn-primary w-100">
                            {{ __('Assign') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
    <x-delete-alert />
</x-app-layout>