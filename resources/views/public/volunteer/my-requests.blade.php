@extends('public.template_layouts.app')

@section('title', 'طلباتي')

@section('content')
    <div class="requests-container">
        <div class="page-header">
            <h1>طلبات التطوع الخاصة بي</h1>
            <p>عرض جميع طلبات التطوع والحالة الحالية</p>
        </div>

        @if ($requests->count() === 0)
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h2>لم تقدم أي طلبات حتى الآن</h2>
                <p>
                    <a href="{{ route('volunteer.available-activities') }}" class="link-primary">
                        استعرض الفعاليات المتاحة
                    </a>
                </p>
            </div>
        @else
            <div class="requests-table-responsive">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>الفعالية</th>
                            <th>التاريخ</th>
                            <th>حالة الطلب</th>
                            <th>تاريخ الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <td class="activity-cell">
                                    <strong>{{ $request->activity->title }}</strong>
                                    <small>{{ $request->activity->location }}</small>
                                </td>
                                <td class="date-cell">
                                    {{ $request->activity->start_date->format('Y-m-d') }}
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge status-{{ $request->status }}">
                                        @switch($request->status)
                                            @case('pending')
                                                قيد الانتظار
                                            @break

                                            @case('approved')
                                                مقبول
                                            @break

                                            @case('rejected')
                                                مرفوض
                                            @break

                                            @default
                                                معطل
                                        @endswitch
                                    </span>
                                </td>
                                <td class="date-cell">
                                    {{ $request->request_date->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <style>
        .requests-container {
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
            margin: 0 0 1rem 0;
        }

        .empty-state p {
            color: #6c757d;
            margin: 0;
        }

        .link-primary {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .link-primary:hover {
            text-decoration: underline;
        }

        .requests-table-responsive {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
        }

        .requests-table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .requests-table th {
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            color: #2c3e50;
        }

        .requests-table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .requests-table tbody tr {
            transition: background-color 0.2s;
        }

        .requests-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .activity-cell {
            min-width: 250px;
        }

        .activity-cell strong {
            display: block;
            color: #2c3e50;
        }

        .activity-cell small {
            display: block;
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .date-cell {
            min-width: 120px;
            color: #6c757d;
        }

        .status-cell {
            min-width: 120px;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-cancelled {
            background-color: #e2e3e5;
            color: #383d41;
        }

        @media (max-width: 768px) {
            .requests-table {
                font-size: 0.9rem;
            }

            .requests-table th,
            .requests-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
@endsection
