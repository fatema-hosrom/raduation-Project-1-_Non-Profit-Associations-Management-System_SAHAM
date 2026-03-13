@extends('templates.financial_app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">تعديل الملف الشخصي</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('financial.profile.update') }}" class="max-w-lg">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">الاسم الكامل</label>
                <input type="text" name="full_name" value="{{ old('full_name', $manager->full_name) }}"
                    class="w-full border border-gray-300 px-3 py-2 rounded" required>
                @error('full_name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email', $manager->email) }}"
                    class="w-full border border-gray-300 px-3 py-2 rounded" required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $manager->phone) }}"
                    class="w-full border border-gray-300 px-3 py-2 rounded">
                @error('phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">كلمة المرور الجديدة (اختياري)</label>
                <input type="password" name="password" class="w-full border border-gray-300 px-3 py-2 rounded">
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 px-3 py-2 rounded">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">حفظ التغييرات</button>
        </form>
    </div>
@endsection
