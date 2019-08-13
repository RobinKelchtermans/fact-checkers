{{-- Socialiser --}}
@if (session()->get('show_gamification') && session()->get('userType') == 'Socialiser')
    <span class="badge badge-secondary">
        @if (strtotime($user->created_at) > strtotime('-1 week'))
            Nieuw
        @elseif($user->reputation > 0.950)
            Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>
        @elseif($user->reputation > 0.900)
            Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>
        @elseif($user->reputation > 0.800)
            Pro <i class="fas fa-sm fa-star"></i>
        @elseif($user->reputation > 0.700)
            Top
        @else
            Normal
        @endif
    </span>
@endif