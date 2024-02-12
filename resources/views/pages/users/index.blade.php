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
                                    @if ($user->hasRole('users'))
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                @if ($user->voucherCodes->isNotEmpty())
                                                    @foreach ($user->voucherCodes as $item)
                                                        <span class="badge rounded-pill bg-secondary voucher-badge-width">{{ $item->voucher_code }}</span>        
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <form id="deleteForm{{$key}}" method="POST" action="{{ route('users.destroy', Crypt::encryptString($user->id)) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                
                                                    <button type="button" class="btn btn-link text-decoration-none delete-button" data-id="{{$key}}">
                                                        {{ __('Remove User to this Group') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
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
                                            @if ($user->voucherCodes->isNotEmpty())
                                                @foreach ($user->voucherCodes as $item)
                                                    <span class="badge rounded-pill bg-secondary voucher-badge-width">{{ $item->voucher_code }}</span>        
                                                @endforeach
                                            @endif
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