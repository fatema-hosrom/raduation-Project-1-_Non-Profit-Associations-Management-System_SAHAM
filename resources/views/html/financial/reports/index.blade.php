@extends('templates.financial_app')

@section('title', 'تقارير مالية')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">لوحة التقارير المالية</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold">إجمالي التبرعات</h2>
                <p class="text-2xl">{{ number_format($totalDonations, 2) }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold">إجمالي المصاريف</h2>
                <p class="text-2xl">{{ number_format($totalExpenses, 2) }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold">الصافي</h2>
                <p class="text-2xl">{{ number_format($netAmount, 2) }}</p>
            </div>
        </div>
        <!-- diagrams & charts can be loaded here if JS available -->
        <div class="mt-8">
            <a href="{{ route('financial.reports.activities') }}" class="text-blue-600 hover:underline">تقرير الفعاليات</a>
            |
            <a href="{{ route('financial.reports.donations') }}" class="text-blue-600 hover:underline">تقرير التبرعات</a> |
            <a href="{{ route('financial.reports.expenses') }}" class="text-blue-600 hover:underline">تقرير المصاريف</a>
        </div>
    </div>
@endsection
