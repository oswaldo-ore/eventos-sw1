<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if (count(auth()->user()->unreadNotifications))
            <span class="badge badge-warning navbar-badge">
                {{ count(Auth::user()->unreadNotifications) }}
            </span>
        @endif

        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ count(Auth::user()->unreadNotifications) }}
            Notificaciones
        </span>
        @foreach (auth()->user()->unreadNotifications as $notification)
        @endforeach
        @forelse (auth()->user()->unreadNotifications as $notification)
            <div class="dropdown-divider"></div>
            <a href="{{ route('mark.notification', [$notification->data['evento'], $notification->id]) }}"
                class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{ $notification->data['title'] }}
                <span
                    class="ml-3 pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <div class="dropdown-divider"></div>
            <span class="dropdown-item dropdown-header">Sin notificaciones nuevas
            </span>
        @endforelse

        <div class="dropdown-divider"></div>
        <span class="dropdown-item dropdown-header">Notificaciones leidas
        </span>

        @forelse (auth()->user()->readNotifications  as $notification)
            <div class="dropdown-divider"></div>
            <a href="{{ route('mark.notification', [$notification->data['evento'], $notification->id]) }}"
                class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> {{ $notification->data['title'] }}
                <span
                    class="ml-3 pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <span class="dropdown-item dropdown-header">Sin Notificaciones leidas
            </span>
        @endforelse

        <!--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>-->
    </div>
</li>
