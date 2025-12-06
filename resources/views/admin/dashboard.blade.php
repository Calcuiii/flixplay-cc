@extends('admin.layout')

@section('page-title', 'Dashboard Admin')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
    <!-- Card: Total Users -->
    <div style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 212, 212, 0.1)); border: 1px solid rgba(0, 212, 212, 0.2); padding: 25px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #b0b0b0; margin-bottom: 10px;">Total Users</p>
                <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 32px;">{{ $totalUsers }}</h2>
            </div>
            <i class="bi bi-people-fill" style="font-size: 24px; color: #00d4d4;"></i>
        </div>
    </div>

    <!-- Card: Total Films -->
    <div style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 212, 212, 0.1)); border: 1px solid rgba(0, 212, 212, 0.2); padding: 25px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #b0b0b0; margin-bottom: 10px;">Total Film</p>
                <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 32px;">{{ $totalFilms }}</h2>
            </div>
            <i class="bi bi-film" style="font-size: 24px; color: #e94b3c;"></i>
        </div>
    </div>

    <!-- Card: Active Subscriptions -->
    <div style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 212, 212, 0.1)); border: 1px solid rgba(0, 212, 212, 0.2); padding: 25px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #b0b0b0; margin-bottom: 10px;">Active Subscriptions</p>
                <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 32px;">{{ $activeSubscriptions }}</h2>
            </div>
            <i class="bi bi-credit-card" style="font-size: 24px; color: #00d4d4;"></i>
        </div>
    </div>

    <!-- Card: Total Watches -->
    <div style="background: linear-gradient(135deg, rgba(233, 75, 60, 0.1), rgba(0, 212, 212, 0.1)); border: 1px solid rgba(0, 212, 212, 0.2); padding: 25px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <p style="color: #b0b0b0; margin-bottom: 10px;">Total Watches</p>
                <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 32px;">{{ $totalWatches }}</h2>
            </div>
            <i class="bi bi-eye" style="font-size: 24px; color: #e94b3c;"></i>
        </div>
    </div>
</div>

<!-- Recent Subscriptions -->
<div>
    <h2 style="background: linear-gradient(135deg, #e94b3c, #00d4d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 20px;">📊 Recent Subscriptions</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Started</th>
                <th>Expires</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentSubscriptions as $sub)
                <tr>
                    <td>{{ $sub->user->name }}</td>
                    <td>{{ $sub->plan->name }}</td>
                    <td>Rp {{ number_format($sub->amount, 0, ',', '.') }}</td>
                    <td>{{ $sub->started_at?->format('d M Y') }}</td>
                    <td>{{ $sub->expires_at?->format('d M Y') }}</td>
                    <td>
                        <span style="background: linear-gradient(135deg, rgba(0, 212, 212, 0.2), rgba(0, 212, 212, 0.1)); color: #00d4d4; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection