@extends('templates.financial_app')

@section('title', 'إضافة مصروف')

@section('content')
    <div class="container mx-auto px-4 py-6">

        @if (isset($activity))
            <h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-blue-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-3-3v6m-9 3h18a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                إضافة مصروف لفعالية: {{ $activity->title }}
            </h1>

            <form method="POST" action="{{ route('financial.expenses.activity.store', $activity->id) }}">
            @else
                <h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-blue-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    إضافة مصروف
                </h1>

                <form method="POST" action="{{ route('financial.expenses.store') }}">
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">الفعالية</label>
                        <select name="activity_id" class="border p-2 rounded w-full" required>
                            <option value="" disabled selected>-- اختر فعالية --</option>
                            @foreach ($activities as $act)
                                <option value="{{ $act->id }}">{{ $act->title }}</option>
                            @endforeach
                        </select>
                    </div>
        @endif

        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">الوصف</label>
            <input type="text" name="description" value="{{ old('description') }}" class="border p-2 rounded w-full"
                required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">المبلغ</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                class="border p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">التاريخ</label>
            <input type="date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                class="border p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">الإيصال (رابط/مسار)</label>
            <input type="text" name="receipt" value="{{ old('receipt') }}" class="border p-2 rounded w-full">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            حفظ
        </button>

        </form>
    </div>
@endsection
