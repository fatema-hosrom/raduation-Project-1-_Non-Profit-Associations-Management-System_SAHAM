@extends('templates.financial_app')

@section('title', 'لوحة التحكم المالية')

@push('styles')
    <style>
        body {
            background: #f4f6fb !important;
            font-family: 'Tajawal', sans-serif;
        }

        :root {
            --blue: #1d4ed8;
            --blue-lt: #eff6ff;
            --blue-md: #bfdbfe;
            --green: #059669;
            --green-lt: #ecfdf5;
            --red: #dc2626;
            --red-lt: #fff1f2;
            --amber: #d97706;
            --amber-lt: #fffbeb;
            --slate: #475569;
            --border: #e2e8f0;
            --white: #ffffff;
            --shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .dash {
            max-width: 100%;
            padding: 28px 28px 60px;
        }

        .dash-header {
            margin-bottom: 24px;
        }

        .dash-header__title {
            font-size: 1.6rem;
            font-weight: 900;
            color: #0f172a;
            margin: 0 0 4px;
            letter-spacing: -0.5px;
        }

        .dash-header__sub {
            font-size: 0.86rem;
            color: var(--slate);
            margin: 0;
        }

        .dash-header__sub strong {
            color: #0f172a;
            font-weight: 700;
        }

        /* NET BANNER */
        .net-banner {
            background: linear-gradient(130deg, #1e3a8a 0%, #1d4ed8 55%, #2563eb 100%);
            border-radius: 16px;
            padding: 26px 32px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(29, 78, 216, 0.3);
        }

        .net-banner::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        .net-banner__eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.6;
            margin-bottom: 6px;
        }

        .net-banner__amount {
            font-size: 2.6rem;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 12px;
        }

        .net-banner__amount sup {
            font-size: 1.1rem;
            font-weight: 600;
            opacity: 0.7;
            vertical-align: super;
        }

        .net-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
        }

        .net-badge.positive {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }

        .net-badge.negative {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .net-banner__right {
            display: flex;
            gap: 0;
        }

        .net-stat {
            padding: 0 28px;
            border-right: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
        }

        .net-stat:first-child {
            padding-right: 0;
        }

        .net-stat:last-child {
            border-right: none;
        }

        .net-stat__label {
            font-size: 0.7rem;
            opacity: 0.6;
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
        }

        .net-stat__val {
            font-size: 1.2rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .net-stat__val.g {
            color: #86efac;
        }

        .net-stat__val.r {
            color: #fca5a5;
        }

        /* STAT CARDS */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .scard {
            background: var(--white);
            border-radius: 14px;
            padding: 20px 20px 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .scard:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .scard::after {
            content: '';
            position: absolute;
            top: 14px;
            bottom: 14px;
            right: 0;
            width: 3px;
            border-radius: 0 3px 3px 0;
        }

        .scard.blue::after {
            background: var(--blue);
        }

        .scard.green::after {
            background: var(--green);
        }

        .scard.red::after {
            background: var(--red);
        }

        .scard.amber::after {
            background: var(--amber);
        }

        .scard__icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            margin-bottom: 12px;
        }

        .scard.blue .scard__icon {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .scard.green .scard__icon {
            background: var(--green-lt);
            color: var(--green);
        }

        .scard.red .scard__icon {
            background: var(--red-lt);
            color: var(--red);
        }

        .scard.amber .scard__icon {
            background: var(--amber-lt);
            color: var(--amber);
        }

        .scard__label {
            font-size: 0.74rem;
            color: var(--slate);
            font-weight: 500;
            margin-bottom: 4px;
        }

        .scard__val {
            font-size: 1.45rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .scard__sub {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .scard__sub b {
            color: var(--slate);
            font-weight: 600;
        }

        /* QUICK ACTIONS */
        .section-card {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 22px 24px;
            margin-bottom: 22px;
        }

        .section-head {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 18px;
        }

        .section-head__bar {
            width: 4px;
            height: 18px;
            background: linear-gradient(to bottom, var(--blue), #60a5fa);
            border-radius: 2px;
            flex-shrink: 0;
        }

        .section-head h2 {
            font-size: 0.93rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .action-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 18px 10px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            border: 1.5px solid;
            transition: all 0.18s;
            text-align: center;
            line-height: 1.3;
        }

        .action-tile__ico {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: transform 0.18s;
        }

        .action-tile:hover .action-tile__ico {
            transform: scale(1.12) rotate(-4deg);
        }

        .action-tile.blue {
            background: var(--blue-lt);
            border-color: var(--blue-md);
            color: var(--blue);
        }

        .action-tile.blue .action-tile__ico {
            background: #dbeafe;
        }

        .action-tile.blue:hover {
            background: #dbeafe;
            border-color: #93c5fd;
        }

        .action-tile.red {
            background: #fff1f2;
            border-color: #fecdd3;
            color: var(--red);
        }

        .action-tile.red .action-tile__ico {
            background: #ffe4e6;
        }

        .action-tile.red:hover {
            background: #ffe4e6;
            border-color: #fca5a5;
        }

        .action-tile.green {
            background: var(--green-lt);
            border-color: #a7f3d0;
            color: var(--green);
        }

        .action-tile.green .action-tile__ico {
            background: #d1fae5;
        }

        .action-tile.green:hover {
            background: #d1fae5;
            border-color: #6ee7b7;
        }

        .action-tile.amber {
            background: var(--amber-lt);
            border-color: #fde68a;
            color: var(--amber);
        }

        .action-tile.amber .action-tile__ico {
            background: #fef3c7;
        }

        .action-tile.amber:hover {
            background: #fef3c7;
            border-color: #fcd34d;
        }

        /* TABLES */
        .tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .tcard {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            min-width: 0;
        }

        .tcard__head {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tcard__head h3 {
            margin: 0;
            font-size: 0.88rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .tcard__dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .tcard__dot.g {
            background: var(--green);
            box-shadow: 0 0 0 3px #d1fae5;
        }

        .tcard__dot.r {
            background: var(--red);
            box-shadow: 0 0 0 3px #ffe4e6;
        }

        .tcard__all {
            font-size: 0.73rem;
            color: #94a3b8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 3px;
            font-weight: 600;
            transition: color 0.15s;
            white-space: nowrap;
        }

        .tcard__all:hover {
            color: var(--blue);
        }

        table.dtable {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.dtable thead th {
            padding: 10px 12px;
            text-align: right;
            font-size: 0.67rem;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            background: #fafafa;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
            overflow: hidden;
        }

        table.dtable tbody td {
            padding: 11px 12px;
            font-size: 0.79rem;
            color: var(--slate);
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        table.dtable tbody tr:last-child td {
            border-bottom: none;
        }

        table.dtable tbody tr:hover td {
            background: #f8fafc;
        }

        .dtable th:nth-child(1),
        .dtable td:nth-child(1) {
            width: 26%;
        }

        .dtable th:nth-child(2),
        .dtable td:nth-child(2) {
            width: 36%;
        }

        .dtable th:nth-child(3),
        .dtable td:nth-child(3) {
            width: 20%;
        }

        .dtable th:nth-child(4),
        .dtable td:nth-child(4) {
            width: 18%;
        }

        .cell-name {
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: 700;
            color: #0f172a;
            overflow: hidden;
        }

        .cell-name span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ava {
            width: 26px;
            height: 26px;
            border-radius: 7px;
            background: var(--blue-lt);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .ava.r {
            background: #fff1f2;
            color: var(--red);
        }

        .tag {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 5px;
            font-size: 0.66rem;
            font-weight: 600;
            background: var(--blue-lt);
            color: var(--blue);
            border: 1px solid var(--blue-md);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .tag.r {
            background: #fff1f2;
            color: var(--red);
            border-color: #fecdd3;
        }

        .amt {
            font-weight: 800;
            font-size: 0.82rem;
        }

        .amt.g {
            color: var(--green);
        }

        .amt.r {
            color: var(--red);
        }

        .dt {
            font-size: 0.72rem;
            color: #94a3b8;
            white-space: nowrap;
        }

        .empty-row td {
            text-align: center;
            padding: 36px !important;
            color: #94a3b8;
            font-size: 0.83rem;
        }

        .empty-row td i {
            display: block;
            font-size: 1.6rem;
            margin-bottom: 7px;
            opacity: 0.3;
        }

        @media (max-width: 1100px) {

            .stats-row,
            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .net-banner__right {
                flex-wrap: wrap;
                gap: 12px;
            }

            .net-stat {
                border-right: none;
                padding: 0 14px;
            }
        }

        @media (max-width: 820px) {
            .tables-grid {
                grid-template-columns: 1fr;
            }

            .net-banner {
                padding: 20px 18px;
            }

            .net-banner__amount {
                font-size: 2rem;
            }

            .dash {
                padding: 16px 14px 40px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash">

        <div class="dash-header">
            <h1 class="dash-header__title">لوحة التحكم المالية</h1>
            <p class="dash-header__sub">مرحباً، <strong>{{ $manager->full_name }}</strong> — نظرة عامة على الأداء المالي</p>
        </div>

        @php
            $net = $totalDonationsAmount - $totalExpensesAmount;
            $total = $totalDonationsAmount + $totalExpensesAmount;
            $pct = $total > 0 ? abs($net / $total) * 100 : 0;
        @endphp

        <div class="net-banner">
            <div class="net-banner__left">
                <div class="net-banner__eyebrow">صافي الرصيد الكلي</div>
                <div class="net-banner__amount"><sup>$</sup>{{ number_format(abs($net), 2) }}</div>
                <span class="net-badge {{ $net >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $net >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format($pct, 1) }}% {{ $net >= 0 ? 'فائض' : 'عجز' }}
                </span>
            </div>
            <div class="net-banner__right">
                <div class="net-stat">
                    <div class="net-stat__label">إجمالي التبرعات</div>
                    <div class="net-stat__val g">${{ number_format($totalDonationsAmount, 2) }}</div>
                </div>
                <div class="net-stat">
                    <div class="net-stat__label">إجمالي المصاريف</div>
                    <div class="net-stat__val r">${{ number_format($totalExpensesAmount, 2) }}</div>
                </div>
                <div class="net-stat">
                    <div class="net-stat__label">الأنشطة النشطة</div>
                    <div class="net-stat__val">{{ $activeActivities }}</div>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="scard blue">
                <div class="scard__icon"><i class="fas fa-hand-holding-dollar"></i></div>
                <div class="scard__label">إجمالي التبرعات</div>
                <div class="scard__val">${{ number_format($totalDonationsAmount, 2) }}</div>
                <div class="scard__sub">{{ $totalDonationsCount }} معاملة · متوسط
                    <b>${{ number_format($totalDonationsAmount / max($totalDonationsCount, 1), 2) }}</b></div>
            </div>
            <div class="scard red">
                <div class="scard__icon"><i class="fas fa-receipt"></i></div>
                <div class="scard__label">إجمالي المصاريف</div>
                <div class="scard__val">${{ number_format($totalExpensesAmount, 2) }}</div>
                <div class="scard__sub">{{ $totalExpensesCount }} إيصال · متوسط
                    <b>${{ number_format($totalExpensesAmount / max($totalExpensesCount, 1), 2) }}</b></div>
            </div>
            <div class="scard green">
                <div class="scard__icon"><i class="fas fa-calendar-check"></i></div>
                <div class="scard__label">الأنشطة النشطة</div>
                <div class="scard__val">{{ $activeActivities }}</div>
                <div class="scard__sub">نشاط جارٍ حالياً</div>
            </div>
            <div class="scard amber">
                <div class="scard__icon"><i class="fas fa-users"></i></div>
                <div class="scard__label">عدد المانحين</div>
                <div class="scard__val">{{ $donorsCount }}</div>
                <div class="scard__sub">مانح مسجّل</div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-head">
                <span class="section-head__bar"></span>
                <h2>الوصول السريع</h2>
            </div>
            <div class="actions-grid">
                <a href="{{ route('financial.donations.index') }}" class="action-tile blue">
                    <div class="action-tile__ico"><i class="fas fa-hand-holding-dollar"></i></div>إدارة التبرعات
                </a>
                <a href="{{ route('financial.expenses.index') }}" class="action-tile red">
                    <div class="action-tile__ico"><i class="fas fa-receipt"></i></div>إدارة المصاريف
                </a>
                <a href="{{ route('financial.donations.index') }}" class="action-tile green">
                    <div class="action-tile__ico"><i class="fas fa-list-check"></i></div>جميع التبرعات
                </a>
                <a href="{{ route('financial.reports.index') }}" class="action-tile amber">
                    <div class="action-tile__ico"><i class="fas fa-chart-bar"></i></div>التقارير
                </a>
            </div>
        </div>

        <div class="tables-grid">
            <div class="tcard">
                <div class="tcard__head">
                    <h3><span class="tcard__dot g"></span> آخر التبرعات</h3>
                    <a href="{{ route('financial.donations.index') }}" class="tcard__all">عرض الكل <i
                            class="fas fa-chevron-left" style="font-size:0.55rem"></i></a>
                </div>
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>المانح</th>
                            <th>الفعالية</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDonations as $donation)
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <div class="ava">{{ mb_substr($donation->donor->name ?? 'غ', 0, 1) }}</div>
                                        <span>{{ $donation->donor->name ?? 'غير معروف' }}</span>
                                    </div>
                                </td>
                                <td><span
                                        class="tag">{{ Str::limit($donation->activity->title ?? 'غير محدد', 20) }}</span>
                                </td>
                                <td><span class="amt g">${{ number_format($donation->amount, 2) }}</span></td>
                                <td><span class="dt">{{ $donation->created_at->format('d/m/Y') }}</span></td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="4"><i class="fas fa-inbox"></i> لا توجد تبرعات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tcard">
                <div class="tcard__head">
                    <h3><span class="tcard__dot r"></span> آخر المصاريف</h3>
                    <a href="{{ route('financial.expenses.index') }}" class="tcard__all">عرض الكل <i
                            class="fas fa-chevron-left" style="font-size:0.55rem"></i></a>
                </div>
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>الوصف</th>
                            <th>الفعالية</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentExpenses as $expense)
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <div class="ava r"><i class="fas fa-receipt" style="font-size:0.62rem"></i></div>
                                        <span>{{ Str::limit($expense->description, 20) }}</span>
                                    </div>
                                </td>
                                <td><span class="tag r">{{ Str::limit($expense->activity->title ?? 'عام', 18) }}</span>
                                </td>
                                <td><span class="amt r">${{ number_format($expense->amount, 2) }}</span></td>
                                <td><span
                                        class="dt">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="4"><i class="fas fa-inbox"></i> لا توجد مصاريف</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
