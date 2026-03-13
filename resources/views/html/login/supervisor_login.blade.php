@extends('templates.auth')

@section('title', 'تسجيل دخول المشرف - نظام إدارة الجمعيات')

@push('styles')
    <link rel="stylesheet" href="/assets/css/login2.css">
@endpush

@section('content')
    <div class="login-container">
        <div class="login-header">
            <img src="/assets/images/logos/logo.png" alt="شعار الجمعية">
            <h1>تسجيل دخول المشرف</h1>
            <p>مرحباً بك في لوحة تحكم المشرف</p>
        </div>

        @if ($errors && $errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('supervisor.login.post') }}">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>
                تسجيل الدخول
            </button>
        </form>

        <div class="login-footer">
            <p>هل أنت مدير فعاليات؟ <a href="{{ route('auth.login') }}">تسجيل الدخول كمدير فعاليات</a></p>
            <p><a href="{{ route('auth.logout') }}">تسجيل الخروج</a></p>
        </div>
    </div>
@endsection
