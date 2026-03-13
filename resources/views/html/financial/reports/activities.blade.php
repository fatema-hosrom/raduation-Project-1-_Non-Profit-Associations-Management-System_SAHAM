@extends('templates.financial_app')

@section('title', 'تقرير الفعاليات')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">تقرير الفعاليات</h1>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">العنوان</th>
                    <th class="border px-4 py-2">تاريخ الإنشاء</th>
                    <th class="border px-4 py-2">عدد التبرعات</th>
                    <th class="border px-4 py-2">إجمالي التبرعات</th>
                    <th class="border px-4 py-2">عدد المصاريف</th>
                    <th class="border px-4 py-2">إجمالي المصاريف</th>
                    <th class="border px-4 py-2">الصافي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $act)
                    <tr>
                        <td class="border px-4 py-2">{{ $act['title'] }}</td>
                        <td class="border px-4 py-2">{{ $act['created_at'] }}</td>
                        <td class="border px-4 py-2">{{ $act['donations_count'] }}</td>
                        <td class="border px-4 py-2">{{ number_format($act['donations_total'], 2) }}</td>
                        <td class="border px-4 py-2">{{ $act['expenses_count'] }}</td>
                        <td class="border px-4 py-2">{{ number_format($act['expenses_total'], 2) }}</td>
                        <td class="border px-4 py-2">{{ number_format($act['net_amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
