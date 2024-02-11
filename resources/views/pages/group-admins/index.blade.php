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
                            @if ($group_admins->isNotEmpty())
                                @foreach ($group_admins as $group_admin)
                                    <tr>
                                        <td>{{ $group_admin->name }}</td>
                                        <td>
                                            <a href="{{ route('group-admins.show', Crypt::encryptString($group_admin->id)) }}" class="mx-2">{{ __('View Assigned Groups') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">No Group Admin Found!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-section-card>
            </div>
        </div>
    </section>
</x-app-layout>