@extends('templates.financial_app')

@section('title', 'تقرير المصاريف')

@push('styles')
    <style>
        .page-shell {
            min-height: 100vh;
            padding: 2rem 0;
        }

        .soft-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        }

        .hero-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e5e7eb;
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.05);
        }

        .hero-title {
            color: #0f172a;
            text-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .muted-text {
            color: #64748b;
        }

        .metric-card {
            transition: all 0.25s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
        }

        .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .report-table {
            width: 100%;
            min-width: 760px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .report-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 1rem 1.25rem;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .report-table tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .report-table tbody tr:hover {
            background: #fafafa;
        }

        .form-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 1rem;
            padding: 0.9rem 1rem;
            background: white;
            transition: 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12);
        }

        .btn {
            border-radius: 1rem;
            padding: 0.9rem 1.2rem;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div class="page-shell rtl">
        <div class="container mx-auto px-4 md:px-6">

            <div class="hero-card rounded-3xl p-8 md:p-10 mb-8 text-center">
                <h1 class="hero-title text-4xl md:text-5xl font-extrabold mb-4">تقرير المصاريف</h1>
                <p class="text-lg muted-text max-w-3xl mx-auto leading-8">
                    مراجعة منظمة وهادئة لكل المصروفات مع تفاصيل السجلات والفلاتر الأساسية
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <div class="soft-card metric-card rounded-3xl p-6">
                    <p class="text-sm text-slate-500 mb-2">إجمالي المبلغ</p>
                    <div class="text-3xl font-bold text-rose-600 mb-1">{{ number_format($totalAmount, 2) }}</div>
                    <p class="text-sm muted-text">$</p>
                </div>

                <div class="soft-card metric-card rounded-3xl p-6">
                    <p class="text-sm text-slate-500 mb-2">عدد المصاريف</p>
                    <div class="text-3xl font-bold text-amber-600 mb-1">{{ number_format($expensesCount) }}</div>
                    <p class="text-sm muted-text">سجل مصروف</p>
                </div>

                <div class="soft-card metric-card rounded-3xl p-6">
                    <p class="text-sm text-slate-500 mb-2">متوسط المصروف</p>
                    <div class="text-3xl font-bold text-violet-700 mb-1">
                        {{ $expensesCount > 0 ? number_format($totalAmount / $expensesCount, 2) : '0' }}
                    </div>
                    <p class="text-sm muted-text">$</p>
                </div>

                <div class="soft-card metric-card rounded-3xl p-6 flex items-center justify-center">
                    <button onclick="exportToCSV()" class="btn w-full bg-slate-900 text-white hover:bg-slate-800">
                        تصدير البيانات
                    </button>
                </div>
            </div>

            <div class="soft-card rounded-3xl p-6 mb-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-5">فلترة التقرير</h3>
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-input">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-input">
                    <button type="submit" class="btn bg-rose-600 text-white hover:bg-rose-700">
                        البحث المتقدم
                    </button>
                </form>
            </div>

            <div class="soft-card rounded-3xl overflow-hidden">
                <div class="p-8 border-b border-slate-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <h3 class="text-3xl font-bold text-slate-800">جدول المصاريف الكامل</h3>
                        <div class="text-sm text-slate-500">
                            عرض {{ $expenses->firstItem() ?? 0 }} - {{ $expenses->lastItem() ?? 0 }} من أصل {{ $expenses->total() }}
                        </div>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>الوصف</th>
                                <th>المبلغ</th>
                                <th>رقم الإيصال</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $exp)
                                <tr>
                                    <td>
                                        <div class="font-semibold text-slate-900 truncate max-w-xs">
                                            {{ $exp->activity->title ?? 'غير محدد' }}
                                        </div>
                                    </td>
                                    <td class="text-slate-700">
                                        <div class="max-w-md whitespace-normal">{{ $exp->description }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-rose-100 text-rose-700">
                                            {{ number_format($exp->amount, 2) }} $
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-slate-100 text-slate-700">
                                            {{ $exp->receipt_number ?? '---' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm font-medium text-slate-800">{{ $exp->expense_date }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16 text-slate-500">
                                        لا توجد مصاريف في الفترة المحددة
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-slate-50">
                    {{ $expenses->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function exportToCSV() {
            const headers = ['العنوان', 'الوصف', 'المبلغ', 'رقم الإيصال', 'التاريخ'];
            const csv = [headers.join(',')];

            document.querySelectorAll('.report-table tbody tr').forEach(row => {
                const cells = Array.from(row.querySelectorAll('td')).map(cell =>
                    '"' + cell.textContent.replace(/"/g, '""').trim() + '"'
                );
                if (cells.length) csv.push(cells.join(','));
            });

            const blob = new Blob([new Uint8Array([0xEF, 0xBB, 0xBF]), csv.join('\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'expenses-report-' + new Date().toISOString().slice(0, 10) + '.csv';
            link.click();
        }
    </script>
@endpush
