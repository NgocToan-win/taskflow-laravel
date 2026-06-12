<x-app-layout>
    <x-slot name="header">
        Thông báo của bạn
    </x-slot>

    <div class="container-fluid">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h5 class="mb-0 text-dark fw-bold">Tất cả thông báo</h5>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm fw-semibold">
                            <i class="fa-solid fa-envelope-open me-1"></i> Đánh dấu đã đọc tất cả
                        </button>
                    </form>
                @endif
            </div>
            
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($notifications as $notification)
                        <div class="list-group-item p-4 d-flex align-items-start {{ $notification->unread() ? 'bg-primary-subtle bg-opacity-25' : 'bg-white' }} border-0 border-bottom border-light">
                            <!-- Bell Icon Badge -->
                            <div class="rounded-circle bg-light border border-light-subtle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px; color: #4f46e5;">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            
                            <!-- Notification Body -->
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1 text-dark small {{ $notification->unread() ? 'fw-bold' : 'fw-medium' }}">
                                    {{ $notification->data['message'] }}
                                </p>
                                <span class="text-muted" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Unread Dot -->
                            @if($notification->unread())
                                <span class="rounded-circle bg-primary ms-3 mt-2 flex-shrink-0" style="width: 8px; height: 8px;"></span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-bell-slash d-block fs-1 mb-3 text-secondary opacity-50"></i>
                            Bạn không có thông báo nào.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card Footer Pagination -->
            @if($notifications->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>