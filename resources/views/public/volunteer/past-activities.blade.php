@extends('public.template_layouts.app')

@section('title', 'المشاركات السابقة')

@section('content')
    <div class="past-activities-container">
        <div class="page-header">
            <h1>المشاركات السابقة</h1>
            <p>عرض الفعاليات التي شاركت فيها سابقاً</p>
        </div>

        @if ($activities->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">🏆</div>
                <h2>لم تشارك في أي فعاليات حتى الآن</h2>
                <p>المشاركات المنتهية ستظهر هنا بعد انتهاء الفعالية</p>
            </div>
        @else
            <div class="activities-grid">
                @foreach ($activities as $participation)
                    <div class="activity-card">
                        <div class="activity-image">
                            @if ($participation->activity->image && file_exists(public_path('assets/images/activities/' . $participation->activity->image)))
                                <img src="{{ asset('assets/images/activities/' . $participation->activity->image) }}"
                                    alt="{{ $participation->activity->title }}">
                            @else
                                <img src="{{ asset('assets/images/default-event.png') }}"
                                    alt="{{ $participation->activity->title }}">
                            @endif
                            <div class="completion-badge">✓ مكتمل</div>
                        </div>

                        <div class="activity-content">
                            <h3>{{ $participation->activity->title }}</h3>
                            <p class="activity-desc">{{ Str::limit($participation->activity->description, 100) }}</p>

                            <div class="activity-meta">
                                <div class="meta-item">
                                    <span class="label">تاريخ البدء:</span>
                                    <span class="value">{{ $participation->activity->start_date->format('Y-m-d') }}</span>
                                </div>

                                <div class="meta-item">
                                    <span class="label">تاريخ الانتهاء:</span>
                                    <span class="value">{{ $participation->activity->end_date->format('Y-m-d') }}</span>
                                </div>

                                <div class="meta-item">
                                    <span class="label">انضممت في:</span>
                                    <span class="value">{{ $participation->joined_at->format('Y-m-d') }}</span>
                                </div>

                                <div class="meta-item">
                                    <span class="label">المكان:</span>
                                    <span class="value">{{ $participation->activity->location }}</span>
                                </div>
                            </div>

                            <div class="activity-action">
                                <a href="{{ route('public.activities.sahem.show', $participation->activity->id) }}"
                                    class="btn-view-details">عرض التفاصيل</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .past-activities-container {
            padding: 2rem 0;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .page-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h2 {
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            color: #6c757d;
            margin: 0;
        }

        .activities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .activity-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .activity-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .activity-image {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #e9ecef;
        }

        .activity-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .activity-card:hover .activity-image img {
            transform: scale(1.05);
        }

        .completion-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(40, 167, 69, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .activity-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .activity-content h3 {
            margin: 0 0 0.5rem 0;
            color: #2c3e50;
            font-size: 1.25rem;
        }

        .activity-desc {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0 0 1rem 0;
        }

        .activity-meta {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .meta-item:last-child {
            margin-bottom: 0;
        }

        .meta-item .label {
            color: #6c757d;
            font-weight: 600;
        }

        .meta-item .value {
            color: #2c3e50;
        }

        .activity-action {
            margin-top: auto;
        }

        .btn-view-details {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        @media (max-width: 768px) {
            .activities-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
