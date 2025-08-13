@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">📊 Analytics Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Analytics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Berita</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_news'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="fas fa-arrow-up"></i> {{ $stats['published_news'] ?? 0 }}
                                </span>
                                Published
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-newspaper avatar-title font-20 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Pengumuman</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_announcements'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="fas fa-arrow-up"></i> {{ $stats['active_announcements'] ?? 0 }}
                                </span>
                                Active
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-bullhorn avatar-title font-20 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Galeri</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_galleries'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="fas fa-star"></i> {{ $stats['featured_galleries'] ?? 0 }}
                                </span>
                                Featured
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-images avatar-title font-20 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Mahasiswa</h5>
                            <h3 class="my-2 py-1">{{ $stats['total_students'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">
                                    <i class="fas fa-check"></i> {{ $stats['active_students'] ?? 0 }}
                                </span>
                                Active
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="fas fa-users avatar-title font-20 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">📈 Content Creation Trends (Last 12 Months)</h4>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">🏫 Students by Faculty</h4>
                </div>
                <div class="card-body">
                    <canvas id="facultyChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Statistics -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">📰 Popular News</h4>
                </div>
                <div class="card-body">
                    @if(isset($popularContent['popular_news']) && $popularContent['popular_news']->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($popularContent['popular_news'] as $news)
                            <div class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-1">
                                        <h6 class="mb-1">{{ Str::limit($news->title, 50) }}</h6>
                                        <p class="mb-0 text-muted small">
                                            <i class="fas fa-eye me-1"></i> {{ $news->views ?? 0 }} views
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-calendar me-1"></i> {{ $news->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('admin.news.show', $news->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-newspaper text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No news data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">⚡ Recent Activities</h4>
                </div>
                <div class="card-body">
                    @if(isset($recentActivities) && $recentActivities->count() > 0)
                        <div class="timeline-alt pb-0">
                            @foreach($recentActivities->take(8) as $activity)
                            <div class="timeline-item">
                                <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }} timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="{{ $activity['url'] }}" class="text-{{ $activity['color'] }} fw-bold">{{ Str::limit($activity['title'], 40) }}</a>
                                    <small class="d-block text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clock text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent activities</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Faculty & Program Statistics -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">🎓 Academic Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $stats['total_faculties'] ?? 0 }}</h3>
                                <p class="text-muted">Total Faculties</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-success">{{ $stats['total_programs'] ?? 0 }}</h3>
                                <p class="text-muted">Study Programs</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-info">{{ $stats['total_lecturers'] ?? 0 }}</h3>
                                <p class="text-muted">Lecturers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="text-warning">{{ $stats['total_users'] ?? 0 }}</h3>
                                <p class="text-muted">System Users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-sm {
    height: 3rem;
    width: 3rem;
}

.avatar-title {
    align-items: center;
    background-color: transparent;
    color: #6c757d;
    display: flex;
    font-weight: 500;
    height: 100%;
    justify-content: center;
    width: 100%;
}

.timeline-alt {
    position: relative;
}

.timeline-item {
    margin-bottom: 1.5rem;
    padding-left: 3rem;
    position: relative;
}

.timeline-icon {
    position: absolute;
    left: 0;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--bs-light);
}

.timeline-item-info {
    padding-top: 0.125rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly content creation chart
    @if(isset($monthlyStats))
    const monthlyData = @json($monthlyStats);
    const ctx1 = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [{
                label: 'News',
                data: monthlyData.map(item => item.news),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4
            }, {
                label: 'Announcements',
                data: monthlyData.map(item => item.announcements),
                borderColor: '#f093fb',
                backgroundColor: 'rgba(240, 147, 251, 0.1)',
                tension: 0.4
            }, {
                label: 'Galleries',
                data: monthlyData.map(item => item.galleries),
                borderColor: '#4facfe',
                backgroundColor: 'rgba(79, 172, 254, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif

    // Faculty distribution chart
    @if(isset($contentStats['students_by_faculty']))
    const facultyData = @json($contentStats['students_by_faculty']);
    const ctx2 = document.getElementById('facultyChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: facultyData.map(item => item.faculty ? item.faculty.name : 'No Faculty'),
            datasets: [{
                data: facultyData.map(item => item.total),
                backgroundColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#43e97b',
                    '#ffa726',
                    '#ef5350'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
    @endif
});
</script>
@endpush
