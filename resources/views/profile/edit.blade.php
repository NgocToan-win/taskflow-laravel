<x-app-layout>
    <x-slot name="header">
        Cài đặt Hồ sơ cá nhân
    </x-slot>

    <div class="container-fluid">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <!-- Update Profile Info Card -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4 p-sm-5">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4 p-sm-5">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Card -->
                <div class="card shadow-sm border border-danger border-opacity-10 rounded-3">
                    <div class="card-body p-4 p-sm-5">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
