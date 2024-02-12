<x-app-layout>
    <!-- Page Title -->
    <div class="pagetitle mb-5">
        <h1>{{ __('Group Admins') }}</h1>
    </div>

    <!-- Section for Displaying Group Admins List -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <!-- Section Card for Displaying Group Admins List -->
                <x-section-card title="{{ __('Group Admins List') }}">
                    <!-- Table for Group Admins List -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <!-- Column Header: Name -->
                                <th scope="col">{{ __('Name') }}</th>
                                <!-- Column Header: Options -->
                                <th scope="col">{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if Group Admins List is not empty -->
                            @if ($group_admins->isNotEmpty())
                                <!-- Loop through each Group Admin -->
                                @foreach ($group_admins as $group_admin)
                                    <tr>
                                        <!-- Display Group Admin's Name -->
                                        <td>{{ $group_admin->name }}</td>
                                        <td>
                                            <!-- View Assigned Groups Link -->
                                            <a href="{{ route('group-admins.show', Crypt::encryptString($group_admin->id)) }}" class="mx-2">{{ __('View Assigned Groups') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- Display message if no Group Admin found -->
                                <tr>
                                    <td colspan="2">{{ __('No Group Admin Found!') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </x-section-card>
            </div>
        </div>
    </section>
</x-app-layout>