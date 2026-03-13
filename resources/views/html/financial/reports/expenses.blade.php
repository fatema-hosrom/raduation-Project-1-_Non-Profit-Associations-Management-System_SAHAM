@extends('templates.financial_app')

@section('title', 'تقرير المصاريف')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">تقرير المصاريف</h1>

        <form method="GET" class="mb-4 flex gap-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border p-2 rounded">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border p-2 rounded">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">فلترة</button>
        </form>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">العنوان</th>
                    <th class="border px-4 py-2">الوصف</th>
                    <th class="border px-4 py-2">المبلغ</th>
                    <th class="border px-4 py-2">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $exp)
                    <tr>
                        <td class="border px-4 py-2">{{ $exp->activity->title ?? '' }}</td>
                        <td class="border px-4 py-2">{{ $exp->description }}</td>
                        <td class="border px-4 py-2">{{ number_format($exp->amount, 2) }}</td>
                        <td class="border px-4 py-2">{{ $exp->expense_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $expenses->links() }}</div>
        <div class="mt-2">إجمالي المبلغ: <strong>{{ number_format($totalAmount, 2) }}</strong> ({{ $expensesCount }}
            مصاريف)</div>
    </div>
@endsection
