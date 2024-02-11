<x-app-layout>
    <div class="pagetitle mb-5">
        {{-- Display Add a New Group Button if the user has the 'super-admin' role --}}
        @hasrole('super-admin')
            <x-button class="btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#add-new-group">
                <i class="bi bi-plus me-1"></i>
                {{ __('Add a New Group') }}
            </x-button>
        @endhasrole
        <h1>{{ __('Groups') }}</h1>
        @if(session('status'))
            <x-save-alert />
        @endif
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <x-section-card title="{{ __('Group List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Group Name</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($groups->isNotEmpty())
                                @foreach ($groups as $key => $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>
                                        {{-- Display Edit and Delete Options if the user has the 'super-admin' role --}}
                                        @hasrole('super-admin')
                                            <a href="{{ route('groups.edit', Crypt::encryptString($group->id)) }}" class="mx-2">{{ __('Edit') }}</a>
                            
                                            <form id="deleteForm{{$key}}" method="POST" action="{{ route('groups.destroy', Crypt::encryptString($group->id)) }}" class="d-inline">
                                                @csrf
                                                @method('delete')
                                            
                                                <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{$key}}">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endhasrole
                        
                                        <a href="view-users.route/1" class="mx-2">{{ __('View Users') }}</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>                                        
                </x-section-card>
            </div>
        </div>
    </section>
    <x-modal id="add-new-group" title="Add a New Group" size="modal-lg">
        <div class="card p-4 m-4">
            <div class="card-body">
                <form method="POST" action="{{ route('groups.store') }}" class="row g-3 needs-validation">
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