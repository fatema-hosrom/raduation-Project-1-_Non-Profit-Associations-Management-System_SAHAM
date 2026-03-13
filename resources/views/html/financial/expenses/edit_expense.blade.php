@extends('templates.financial_app')

@section('title', 'تعديل مصروف')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-blue-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            تعديل مصروف في الفعالية: {{ $activity->title }}
        </h1>

        <form method="POST" action="{{ route('financial.expenses.activity.update', [$activity->id, $expense->id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">الوصف</label>
                <input type="text" name="description" value="{{ old('description', $expense->description) }}"
                    class="border p-2 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">المبلغ</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}"
                    class="border p-2 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">التاريخ</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date) }}"
                    class="border p-2 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">الإيصال</label>
                <input type="text" name="receipt" value="{{ old('receipt', $expense->receipt) }}"
                    class="border p-2 rounded w-full">
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                تحديث
            </button>

        </form>
    </div>
@endsection
