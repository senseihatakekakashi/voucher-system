<x-app-layout>
    <div class="pagetitle mb-5">
        <h1>{{ __('Group Admins') }}</h1>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <x-section-card title="{{ __('Group Admins List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Group Admin 1</td>
                                <td>
                                    <a href="view-assigned-groups.route/1" class="mx-2">{{ __('View Assigned Groups') }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Group Admin 2</td>
                                <td>
                                    <a href="view-assigned-groups.route/2" class="mx-2">{{ __('View Assigned Groups') }}</a>
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