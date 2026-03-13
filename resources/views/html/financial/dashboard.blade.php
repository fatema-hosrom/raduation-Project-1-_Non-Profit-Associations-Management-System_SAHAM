@extends('templates.financial_app')

@section('title', 'لوحة المدير المالي')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">مرحباً، {{ $manager->full_name }}</h1>
        <p>هذه اللوحة الرئيسية فارغة حالياً.</p>
    </div>
@endsection
