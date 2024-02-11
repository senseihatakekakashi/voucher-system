<x-app-layout>
    <div class="pagetitle mb-5">
        <h1>{{ __('Users') }}</h1>
        <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('groups.index') }}">{{ __('Home') }}</a></li>
              <li class="breadcrumb-item active">{{ __('Users') }}</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <x-section-card title="{{ __('List of user under the group: ') . ' [' . $group->name .']' }}">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-2">Name</th>
                                <th scope="col" class="col-8">Voucher Codes</th>
                                <th scope="col" class="col-2">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($group->users->isNotEmpty())
                                @foreach ($group->users->sortBy('name') as $key => $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
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
                                            @if ($user->hasRole('users'))
                                                <form id="deleteForm{{$key}}" method="POST" action="{{ route('users.destroy', Crypt::encryptString($user->id)) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                
                                                    <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{$key}}">
                                                        {{ __('Remove User to this Group') }}
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-link text-decoration-none delete-button" disabled>
                                                    {{ __('Remove User to this Group') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No Users Assigned to this Group</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-section-card>
            </div>

            <div class="col-12">
                <x-section-card title="{{ __('Unallocated  Users List') }}">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-2">Name</th>
                                <th scope="col" class="col-8">Voucher Codes</th>
                                <th scope="col" class="col-2">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($unallocated_users->isNotEmpty())
                                @foreach ($unallocated_users as $key => $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
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
                                            <form id="groupUserAssignForm{{$key}}" method="POST" action="{{ route('users.update', Crypt::encryptString($user->id)) }}" class="d-inline">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="group" value="{{ Crypt::encryptString($group->id) }}">
                                                <button type="button" class="btn btn-link text-decoration-none group-user-assign-button" data-id="{{$key}}">
                                                    {{ __('Assign User to this Group') }}
                                                </button>
                                            </form>
                                            {{-- <a href="{{ route('users.edit', Crypt::encryptString($user->id)) }}" class="mx-2">{{ __('Assign User to this Group') }}</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No Unallocated User found!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-section-card>
            </div>
        </div>
    </section>
    <x-delete-alert />
    <x-group-user-assign-alert />
</x-app-layout>