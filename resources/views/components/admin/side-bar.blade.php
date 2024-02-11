<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        {{-- Display a side-bar item for users with the 'super-admin' role --}}
        @hasrole('super-admin')
            <x-admin.side-bar-item state="collapsed" uri="{{ route('group-admins.index') }}" icon="bi bi-people-fill" item="Group Admins" />
        @endhasrole

        {{-- Display side-bar items for users with either 'super-admin' or 'group-admin' roles --}}
        @hasrole('super-admin|group-admin')
            <x-admin.side-bar-item state="collapsed" uri="{{ route('groups.index') }}" icon="bi bi-grid-fill" item="Groups" />
            <x-admin.side-bar-item state="collapsed" uri="#" icon="bi bi-file-earmark-excel-fill" item="Export" />
        @endhasrole

        {{-- Display a side-bar item for users with the 'users' role --}}
        @hasrole('users')
            <x-admin.side-bar-item state="collapsed" uri="{{ route('voucher-codes.index') }}" icon="bi bi-card-checklist" item="Voucher Codes" />
        @endhasrole
    </ul>
</aside>
