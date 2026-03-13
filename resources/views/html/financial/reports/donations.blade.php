@extends('templates.financial_app')

@section('title', 'تقرير التبرعات')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">تقرير التبرعات</h1>

        <form method="GET" class="mb-4 flex gap-2">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border p-2 rounded">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border p-2 rounded">
            <select name="type" class="border p-2 rounded">
                <option value="">كل الأنواع</option>
                <option value="cash" {{ request('type') == 'cash' ? 'selected' : '' }}>نقدي</option>
                <option value="online" {{ request('type') == 'online' ? 'selected' : '' }}>أونلاين</option>
                <option value="check" {{ request('type') == 'check' ? 'selected' : '' }}>شيك</option>
                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>أخرى</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">فلترة</button>
        </form>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">العنوان</th>
                    <th class="border px-4 py-2">المتبرع</th>
                    <th class="border px-4 py-2">المبلغ</th>
                    <th class="border px-4 py-2">النوع</th>
                    <th class="border px-4 py-2">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donations as $don)
                    <tr>
                        <td class="border px-4 py-2">{{ $don->activity->title ?? '' }}</td>
                        <td class="border px-4 py-2">{{ $don->donor->name ?? '' }}</td>
                        <td class="border px-4 py-2">{{ number_format($don->amount, 2) }}</td>
                        <td class="border px-4 py-2">{{ $don->donation_type }}</td>
                        <td class="border px-4 py-2">{{ $don->date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $donations->links() }}</div>
        <div class="mt-2">إجمالي المبلغ: <strong>{{ number_format($totalAmount, 2) }}</strong> ({{ $donationsCount }}
            تبرع)</div>
    </div>
@endsection
