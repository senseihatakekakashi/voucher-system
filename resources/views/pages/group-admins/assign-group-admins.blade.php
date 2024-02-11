<x-app-layout>
    <div class="pagetitle mb-5">
        <x-button class="btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#add-new-group">
            <i class="bi bi-plus me-1"></i>
            {{ __('Assign a Group') }}
        </x-button>
        <h1>{{ __('Group Admins') }}</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('group-admins.index') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Assign Group Admin to Groups') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12 mb-3">
                <x-section-card title="Selected Group Admin:">
                    <h5>
                        <span class="badge rounded-pill bg-primary">{{ $group_admin->name }}</span>
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
                            @if ($group_admin_groups->groups->isNotEmpty())
                                @foreach ($group_admin_groups->groups as $key => $group)
                                    <tr>
                                        <td>{{ $group->name }}</td>
                                        <td>
                                            <form id="deleteForm{{$key}}" method="POST" action="{{ route('group-admins.destroy', Crypt::encryptString($group->id)) }}" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="user" value="{{ Crypt::encryptString($group_admin->id) }}">
                                                <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{$key}}">
                                                    {{ __('Remove From the Group') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">No Groups Assigned to this Group Admin.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>                                        
                </x-section-card>
            </div>
        </div>
    </section>
    <x-modal id="add-new-group" title="Assign [{{$group_admin->name}}] to a Group" size="modal-md">
        <div class="card p-4 m-4">
            <div class="card-body">
                <form method="POST" action="{{ route('group-admins.update', Crypt::encryptString($group_admin->id)) }}" class="row g-3 needs-validation">
                    @csrf
                    @method('put')

                    <div class="col-12 border rounded-2 p-3 switch-list-box-card">
                        @if ($groups->isNotEmpty())
                            @foreach ($groups as $group)
                                @if ($group_admin_groups->groups->contains('id', $group->id))
                                    <x-switch-input id="group-{{ $group->id }}" name="groups[]" value="{{ Crypt::encryptString($group->id) }}" checked>
                                        {{ __($group->name) }}
                                    </x-switch-input>
                                @else
                                    <x-switch-input id="group-{{ $group->id }}" name="groups[]" value="{{ Crypt::encryptString($group->id) }}">
                                        {{ __($group->name) }}
                                    </x-switch-input>
                                @endif
                            @endforeach
                        @endif
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