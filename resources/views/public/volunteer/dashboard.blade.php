@extends('public.template_layouts.app')

@section('title', 'لوحة تحكم المتطوع')

@section('content')
    <div class="volunteer-dashboard">
        <!-- رسائل النجاح -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- الرأس -->
        <div class="dashboard-header">
            <div class="header-content">
                <h1>مرحباً {{ $volunteer->name }}</h1>
                <p>لوحة تحكم المتطوع</p>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="statistics-grid">
            <div class="stat-card">
                <div class="stat-icon pending">▼</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['pending_requests'] }}</span>
                    <span class="stat-label">طلبات قيد الانتظار</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon approved">✓</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['approved_activities'] }}</span>
                    <span class="stat-label">فعاليات مقبولة</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon completed">★</div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['completed_activities'] }}</span>
                    <span class="stat-label">فعاليات منجزة</span>
                </div>
            </div>
        </div>

        <!-- الخيارات الرئيسية -->
        <div class="dashboard-menu">
            <a href="{{ route('volunteer.profile') }}" class="menu-card">
                <div class="menu-icon">👤</div>
                <div class="menu-title">الملف الشخصي</div>
                <div class="menu-desc">عرض وتعديل بياناتك الشخصية</div>
            </a>

            <a href="{{ route('volunteer.available-activities') }}" class="menu-card">
                <div class="menu-icon">🎯</div>
                <div class="menu-title">فعاليات متاحة</div>
                <div class="menu-desc">استعرض الفعاليات وقدم طلب تطوع</div>
            </a>

            <a href="{{ route('volunteer.my-requests') }}" class="menu-card">
                <div class="menu-icon">📋</div>
                <div class="menu-title">طلباتي</div>
                <div class="menu-desc">عرض جميع طلبات التطوع الخاصة بك</div>
            </a>

            <a href="{{ route('volunteer.past-activities') }}" class="menu-card">
                <div class="menu-icon">🏆</div>
                <div class="menu-title">المشاركات السابقة</div>
                <div class="menu-desc">عرض الفعاليات التي شاركت فيها</div>
            </a>
        </div>
    </div>

    <style>
        .volunteer-dashboard {
            padding: 2rem 0;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .header-content h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .header-content p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.pending {
            background-color: #fff3cd;
            color: #ff9800;
        }

        .stat-icon.approved {
            background-color: #d4edda;
            color: #28a745;
        }

        .stat-icon.completed {
            background-color: #d1ecf1;
            color: #17a2b8;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .dashboard-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .menu-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .menu-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .menu-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .menu-desc {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0.5;
        }

        .btn-close:hover {
            opacity: 0.8;
        }
    </style>
@endsection
