<x-app-layout>
    <!-- Page Title -->
    <div class="pagetitle mb-5">
        <!-- Assign a Group Button -->
        <x-button class="btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#add-new-group">
            <i class="bi bi-plus me-1"></i>
            {{ __('Assign a Group') }}
        </x-button>
        <h1>{{ __('Group Admins') }}</h1>
        <!-- Breadcrumb Navigation -->
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('group-admins.index') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Assign Group Admin to Groups') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Section for Displaying Group Admins and Assigned Groups -->
    <section class="section dashboard">
        <div class="row">
            <!-- Display Selected Group Admin -->
            <div class="col-12 mb-3">
                <x-section-card title="Selected Group Admin:">
                    <h5>
                        <!-- Badge with Group Admin's Name -->
                        <span class="badge rounded-pill bg-primary">{{ $group_admin->name }}</span>
                    </h5>
                </x-section-card>
            </div>
            <!-- Display Assigned Group List -->
            <div class="col-12">
                <x-section-card title="{{ __('Assigned Group List') }}">
                    <!-- Table for Assigned Group List -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <!-- Column Header: Group Name -->
                                <th scope="col">{{ __('Group Name') }}</th>
                                <!-- Column Header: Options -->
                                <th scope="col">{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if Group Admin has assigned groups -->
                            @if ($group_admin_groups->groups->isNotEmpty())
                                <!-- Loop through each assigned group -->
                                @foreach ($group_admin_groups->groups as $key => $group)
                                    <tr>
                                        <!-- Display Group Name -->
                                        <td>{{ $group->name }}</td>
                                        <td>
                                            <!-- Form for removing Group Admin from the group -->
                                            <form id="deleteForm{{$key}}" method="POST" action="{{ route('group-admins.destroy', Crypt::encryptString($group->id)) }}" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <!-- Hidden input for user ID -->
                                                <input type="hidden" name="user" value="{{ Crypt::encryptString($group_admin->id) }}">
                                                <!-- Button to remove from the group -->
                                                <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{$key}}">
                                                    {{ __('Remove From the Group') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- Display message if no groups are assigned -->
                                <tr>
                                    <td colspan="2">{{ __('No Groups Assigned to this Group Admin.') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-section-card>
            </div>
        </div>
    </section>

    <!-- Modal for Assigning Group to Group Admin -->
    <x-modal id="add-new-group" title="Assign [{{$group_admin->name}}] to a Group" size="modal-md">
        <div class="card p-4 m-4">
            <div class="card-body">
                <!-- Form for Assigning Groups to Group Admin -->
                <form method="POST" action="{{ route('group-admins.update', Crypt::encryptString($group_admin->id)) }}" class="row g-3 needs-validation">
                    @csrf
                    @method('put')

                    <!-- Switch input cards for each group -->
                    <div class="col-12 border rounded-2 p-3 switch-list-box-card">
                        <!-- Check if groups are available -->
                        @if ($groups->isNotEmpty())
                            <!-- Loop through each group -->
                            @foreach ($groups as $group)
                                <!-- Check if the group is already assigned to the Group Admin -->
                                @if ($group_admin_groups->groups->contains('id', $group->id))
                                    <!-- Switch input for assigned group -->
                                    <x-switch-input id="group-{{ $group->id }}" name="groups[]" value="{{ Crypt::encryptString($group->id) }}" checked>
                                        {{ __($group->name) }}
                                    </x-switch-input>
                                @else
                                    <!-- Switch input for unassigned group -->
                                    <x-switch-input id="group-{{ $group->id }}" name="groups[]" value="{{ Crypt::encryptString($group->id) }}">
                                        {{ __($group->name) }}
                                    </x-switch-input>
                                @endif
                            @endforeach
                        @endif
                    </div>
                
                    <!-- Submit button for assigning groups -->
                    <div class="col-12">
                        <x-button class="btn-primary w-100">
                            {{ __('Assign') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
    
    <!-- Delete alert component -->
    <x-delete-alert />
</x-app-layout>