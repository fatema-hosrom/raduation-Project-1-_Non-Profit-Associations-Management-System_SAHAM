@extends('templates.financial_app')

@section('title', 'إضافة مصروف')

@push('styles')
    <style>
        .form-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .form-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            text-align: center;
            color: white;
        }

        .form-body {
            background: white;
            padding: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            margin-top: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            background: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
            grid-column: span 2;
        }

        .file-upload:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload-label {
            color: #6b7280;
            font-weight: 500;
        }

        .full-width {
            grid-column: span 2;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-4xl">

        @if (isset($activity))
            <div class="form-card mb-6">
                <div class="form-header">
                    <h1 class="text-2xl font-bold mb-2 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-3-3v6m-9 3h18a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        إضافة مصروف لفعالية
                    </h1>
                    <p class="text-lg opacity-90">{{ $activity->title }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('financial.expenses.activity.store', $activity->id) }}"
                enctype="multipart/form-data">
            @else
                <div class="form-card mb-6">
                    <div class="form-header">
                        <h1 class="text-2xl font-bold flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            إضافة مصروف جديد
                        </h1>
                    </div>
                </div>

                <form method="POST" action="{{ route('financial.expenses.store') }}" enctype="multipart/form-data">
                    <div class="form-card mb-6">
                        <div class="form-body">
                            <div class="form-group full-width">
                                <label>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    الفعالية
                                </label>
                                <select name="activity_id" class="form-control" required>
                                    <option value="" disabled selected>-- اختر فعالية --</option>
                                    @foreach ($activities as $act)
                                        <option value="{{ $act->id }}">{{ $act->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
        @endif

        @csrf

        <div class="form-card">
            <div class="form-body">
                <div class="form-grid">
                    @php
                        $receiptNumber = old(
                            'receipt_number',
                            'EXP-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                        );
                    @endphp
                    <div class="form-group">
                        <label>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            رقم الإيصال (مولّد تلقائياً)
                        </label>
                        <input type="text" value="{{ $receiptNumber }}" class="form-control" readonly>
                        <input type="hidden" name="receipt_number" value="{{ $receiptNumber }}">
                    </div>

                    <div class="form-group">
                        <label>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            الوصف
                        </label>
                        <input type="text" name="description" value="{{ old('description') }}" class="form-control"
                            required placeholder="وصف المصروف">
                    </div>

                    <div class="form-group">
                        <label>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            المبلغ ($)
                        </label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="form-control"
                            required placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            تاريخ المصروف
                        </label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                            class="form-control" required>
                    </div>

                    <div class="form-group file-upload">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <div class="file-upload-label">انقر لاختيار ملف الإيصال</div>
                        <div class="text-xs text-gray-500 mt-1">يدعم الصور والملفات (JPG, PNG, PDF)</div>
                        <input type="file" id="receipt" name="receipt" accept="image/*,.pdf">
                        <div id="file-name" class="text-sm text-blue-600 mt-2 font-medium"></div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-submit mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        إضافة
                    </button>
                </div>
            </div>
        </div>

        </form>
    </div>

    <script>
        // فتح حقل الملف عند النقر على الـ div
        document.querySelector('.file-upload').addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                document.getElementById('receipt').click();
            }
        });

        // عرض اسم الملف المختار
        document.getElementById('receipt').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '';
            document.getElementById('file-name').textContent = fileName ? 'تم اختيار: ' + fileName : '';
        });
    </script>
@endsection
