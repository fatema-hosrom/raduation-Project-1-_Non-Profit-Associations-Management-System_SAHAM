@extends('templates.manager_app')

@section('title', 'قائمة فعاليات المؤسسة')

@push('styles')
    <link rel="stylesheet" href="/assets/css/activities/activities.css">
    <style>
        .card-list {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }

        .info-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #b0c4de22;
            padding: 24px;
            width: 320px;
            margin-bottom: 18px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-draft {
            background-color: #e2e8f0;
            color: #64748b;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-closed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .results-badge {
            background-color: #10b981;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-left: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h6 class="page-title mb-0">قائمة فعاليات المؤسسة</h6>
                    <button class="btn add-btn" onclick="window.location.href='{{ route('manager.activities.add') }}'">
                        <i class="fas fa-plus"></i>
                        إضافة فعالية
                    </button>
                </div>
            </div>

            <!-- حقل البحث -->
            <div class="row mb-4">
                <div class="col-12">
                    <form method="GET" action="{{ route('manager.activities.index') }}" class="d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                            placeholder="البحث في الفعاليات...">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </form>
                </div>
            </div>

            @forelse ($activities ?? collect() as $activity)
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="activity-card">
                            <div class="activity-header">
                                <h4 class="activity-title">
                                    <span class="activity-img">
                                        @if (!empty($activity->image ?? ($activity['image'] ?? null)))
                                            <img src="{{ asset('assets/images/activities/' . ($activity->image ?? $activity['image'])) }}"
                                                alt="{{ $activity->title ?? $activity['title'] }}"
                                                style="width:100%;height:100%;border-radius:8px;object-fit:cover;">
                                        @else
                                            <span class="text-muted" style="font-size:1.5rem;">لا يوجد</span>
                                        @endif
                                    </span>
                                    {{ $activity->title ?? $activity['title'] }}
                                    @php
                                        $hasResults = \App\Models\ActivityResult::where(
                                            'activity_id',
                                            $activity->id ?? $activity['id'],
                                        )->exists();
                                    @endphp
                                    @if ($hasResults)
                                        <span class="results-badge">
                                            <i class="fas fa-chart-line"></i> لها نتائج
                                        </span>
                                    @endif
                                    @php
                                        $status = $activity->status ?? ($activity['status'] ?? 'draft');
                                        $statusText = match ($status) {
                                            'draft' => 'مسودة',
                                            'active' => 'نشطة',
                                            'closed' => 'مغلقة',
                                            default => 'مسودة',
                                        };
                                        $statusClass = match ($status) {
                                            'draft' => 'status-draft',
                                            'active' => 'status-active',
                                            'closed' => 'status-closed',
                                            default => 'status-draft',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}" style="margin-right: 10px;">
                                        <i class="fas fa-circle"></i> {{ $statusText }}
                                    </span>
                                </h4>
                                <span class="activity-type">
                                    <i class="fas fa-tag"></i>
                                    @php $type = $activity->activity_type ?? $activity['activity_type']; @endphp
                                    {{ $type === 'donation' ? 'تبرع' : ($type === 'volunteer' ? 'تطوع' : ($type === 'both' ? 'شاملة' : 'عادية')) }}
                                </span>
                            </div>
                            <div class="activity-info">
                                <i class="fas fa-calendar-day"></i>
                                <span>تاريخ البداية: {{ $activity->start_date ?? $activity['start_date'] }}</span>
                            </div>
                            <div class="activity-info">
                                <i class="fas fa-calendar-check"></i>
                                <span>تاريخ النهاية: {{ $activity->end_date ?? $activity['end_date'] }}</span>
                            </div>


                            <div class="action-buttons">
                                <button class="btn action-btn view-btn"
                                    onclick="window.location.href='{{ route('manager.activities.view', $activity->id ?? $activity['id']) }}'">
                                    <i class="fas fa-eye"></i> عرض التفاصيل
                                </button>
                                <button class="btn action-btn"
                                    style="background-color: #0d6efd; color: white; border: none;"
                                    onclick="window.location.href='{{ route('manager.activities.results.view', $activity->id ?? $activity['id']) }}'">
                                    <i class="fas fa-chart-line"></i> {{ $hasResults ? 'عرض النتائج' : 'إضافة نتائج' }}
                                </button>
                                <button class="btn action-btn edit-btn"
                                    onclick="window.location.href='{{ route('manager.activities.edit', $activity->id ?? $activity['id']) }}'">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <button class="btn action-btn delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $activity['id'] }}">
                                    <i class="fas fa-trash"></i> حذف
                                </button>

                                {{-- زر تغيير حالة الفعالية --}}
                                <form method="POST"
                                    action="{{ route('manager.activities.toggleStatus', $activity->id ?? $activity['id']) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn action-btn status-btn"
                                        style="background-color: #f5cf27; color: white; border: none;">
                                        <i class="fas fa-exchange-alt"></i> تغيير الحالة
                                    </button>
                                </form>

                                <form method="POST"
                                    action="{{ route('manager.activities.togglePublish', $activity->id ?? $activity['id']) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $activity->is_published ?? false ? 'btn-danger' : 'btn-success' }}"
                                        style="margin-right:10px;">
                                        <i class="fas fa-bullhorn"></i>
                                        {{ $activity->is_published ? 'إيقاف الإعلان' : 'إعلان عن الفعالية' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal حذف الفعالية --}}
                <div class="modal fade" id="deleteModal{{ $activity['id'] }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    style="margin:0;"></button>
                                <h5 class="modal-title" style="margin: auto;">تأكيد الحذف</h5>
                            </div>
                            <div class="modal-body">هل أنت متأكد من حذف الفعالية "{{ $activity['title'] }}"؟</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                <form method="POST"
                                    action="{{ route('manager.activities.destroy', $activity->id ?? $activity['id']) }}"
                                    style="display:inline;margin:0;padding:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    <i class="fas fa-info-circle mb-2" style="font-size: 2rem;"></i>
                    <p>لا توجد فعاليات حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/assets/js/bootstrap.js"></script>
@endpush
