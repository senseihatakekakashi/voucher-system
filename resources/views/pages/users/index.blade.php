<x-app-layout>
    <div class="pagetitle mb-5">
        <h1>{{ __('Users') }}</h1>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <x-section-card title="{{ __('Grouped Users List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Group</th>
                                <th scope="col">Voucher Codes</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>User 1</td>
                                <td>Group 1</td>
                                <td>
                                    <span class="badge rounded-pill bg-secondary">123456</span>
                                    <span class="badge rounded-pill bg-secondary">789012</span>
                                    <span class="badge rounded-pill bg-secondary">345678</span>
                                    <span class="badge rounded-pill bg-secondary">901112</span>
                                    <span class="badge rounded-pill bg-secondary">131415</span>
                                    <span class="badge rounded-pill bg-secondary">161718</span>
                                    <span class="badge rounded-pill bg-secondary">192021</span>
                                    <span class="badge rounded-pill bg-secondary">222324</span>
                                    <span class="badge rounded-pill bg-secondary">252627</span>
                                    <span class="badge rounded-pill bg-secondary">282930</span>
                                </td>
                                <td>
                                    <form id="deleteForm1" method="POST" action="delete.route/1" class="d-inline">
                                        @csrf
                                        @method('delete')
                                    
                                        <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="1">
                                            {{ __('Remove User to this Group') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>User 2</td>
                                <td>Group 2</td>
                                <td>
                                    <span class="badge rounded-pill bg-secondary">161718</span>
                                    <span class="badge rounded-pill bg-secondary">192021</span>
                                    <span class="badge rounded-pill bg-secondary">222324</span>
                                    <span class="badge rounded-pill bg-secondary">252627</span>
                                    <span class="badge rounded-pill bg-secondary">282930</span>
                                    <span class="badge rounded-pill bg-secondary">123456</span>
                                    <span class="badge rounded-pill bg-secondary">789012</span>
                                    <span class="badge rounded-pill bg-secondary">345678</span>
                                    <span class="badge rounded-pill bg-secondary">901112</span>
                                    <span class="badge rounded-pill bg-secondary">131415</span>
                                </td>
                                <td>
                                    <form id="deleteForm1" method="POST" action="delete.route/2" class="d-inline">
                                        @csrf
                                        @method('delete')
                                    
                                        <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="2">
                                            {{ __('Remove User to this Group') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </x-section-card>
            </div>

            <div class="col-12">
                <x-section-card title="{{ __('Unallocated  Users List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Voucher Codes</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>User 1</td>
                                <td>
                                    <span class="badge rounded-pill bg-secondary">123456</span>
                                    <span class="badge rounded-pill bg-secondary">789012</span>
                                    <span class="badge rounded-pill bg-secondary">345678</span>
                                    <span class="badge rounded-pill bg-secondary">901112</span>
                                    <span class="badge rounded-pill bg-secondary">131415</span>
                                    <span class="badge rounded-pill bg-secondary">161718</span>
                                    <span class="badge rounded-pill bg-secondary">192021</span>
                                    <span class="badge rounded-pill bg-secondary">222324</span>
                                    <span class="badge rounded-pill bg-secondary">252627</span>
                                    <span class="badge rounded-pill bg-secondary">282930</span>
                                </td>
                                <td>
                                    <a href="assign-user.route/1" class="mx-2">{{ __('Assign User to a Group') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>User 2</td>
                                <td>
                                    <span class="badge rounded-pill bg-secondary">161718</span>
                                    <span class="badge rounded-pill bg-secondary">192021</span>
                                    <span class="badge rounded-pill bg-secondary">222324</span>
                                    <span class="badge rounded-pill bg-secondary">252627</span>
                                    <span class="badge rounded-pill bg-secondary">282930</span>
                                    <span class="badge rounded-pill bg-secondary">123456</span>
                                    <span class="badge rounded-pill bg-secondary">789012</span>
                                    <span class="badge rounded-pill bg-secondary">345678</span>
                                    <span class="badge rounded-pill bg-secondary">901112</span>
                                    <span class="badge rounded-pill bg-secondary">131415</span>
                                </td>
                                <td>
                                    <a href="assign-user.route/2" class="mx-2">{{ __('Assign User to a Group') }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </x-section-card>
            </div>
        </div>
    </section>
    <x-modal id="add-new-group" title="Add a New Group" size="modal-lg">
        <div class="card p-4 m-4">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation">
                    @csrf
                    <div class="col-12">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                
                    <div class="col-12">
                        <x-button class="btn-primary w-100">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
    <x-delete-alert />
</x-app-layout>