@extends('public.template_layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="profile-container">
        <!-- رسائل النجاح -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- رسائل الأخطاء -->
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="profile-header">
            <h1>الملف الشخصي</h1>
            <p>{{ $volunteer->email }}</p>
        </div>

        <form method="PUT" action="{{ route('volunteer.profile.update') }}" class="profile-form">
            @method('PUT')
            @csrf

            <div class="form-section">
                <h2>المعلومات الأساسية</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">الاسم الكامل *</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ $volunteer->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني *</label>
                        <input type="email" id="email" class="form-control"
                            value="{{ $volunteer->email }}" disabled>
                        <small class="text-muted">لا يمكن تغيير البريد الإلكتروني</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">رقم الهاتف *</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                            value="{{ $volunteer->phone }}" required>
                    </div>

                    <div class="form-group">
                        <label for="age">العمر *</label>
                        <input type="number" id="age" name="age" class="form-control"
                            value="{{ $volunteer->age }}" min="16" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>معلومات شاملة</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">الجنس *</label>
                        <select id="gender" name="gender" class="form-control" disabled>
                            <option>{{ $volunteer->gender }}</option>
                        </select>
                        <small class="text-muted">لا يمكن تغيير الجنس</small>
                    </div>

                    <div class="form-group">
                        <label for="nationality">الجنسية *</label>
                        <input type="text" id="nationality" name="nationality" class="form-control"
                            value="{{ $volunteer->nationality }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">العنوان *</label>
                    <textarea id="address" name="address" class="form-control" rows="2" required>{{ $volunteer->address }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="education_level">المستوى التعليمي</label>
                        <input type="text" id="education_level" name="education_level" class="form-control"
                            value="{{ $volunteer->education_level }}">
                    </div>

                    <div class="form-group">
                        <label for="availability">التوفر</label>
                        <input type="text" id="availability" name="availability" class="form-control"
                            value="{{ $volunteer->availability }}" placeholder="مثال: أيام الأسبوع، نهاية الأسبوع">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>المهارات والخبرة</h2>

                <div class="form-group">
                    <label for="skills">المهارات</label>
                    <textarea id="skills" name="skills" class="form-control" rows="3"
                        placeholder="اذكر مهاراتك (إن وجدت)">{{ $volunteer->skills }}</textarea>
                </div>

                <div class="form-group">
                    <label for="experience">الخبرة السابقة</label>
                    <textarea id="experience" name="experience" class="form-control" rows="3"
                        placeholder="اذكر خبراتك السابقة (إن وجدت)">{{ $volunteer->experience }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="preferred_roles">الأدوار المفضلة</label>
                        <input type="text" id="preferred_roles" name="preferred_roles" class="form-control"
                            value="{{ $volunteer->preferred_roles }}" placeholder="مثال: تربوي، إداري">
                    </div>

                    <div class="form-group">
                        <label for="languages">اللغات</label>
                        <input type="text" id="languages" name="languages" class="form-control"
                            value="{{ $volunteer->languages }}" placeholder="مثال: العربية، الإنجليزية">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>معلومات الطوارئ</h2>

                <div class="form-group">
                    <label for="emergency_contact">جهة اتصال الطوارئ</label>
                    <textarea id="emergency_contact" name="emergency_contact" class="form-control" rows="2"
                        placeholder="رقم الهاتف والاسم">{{ $volunteer->emergency_contact }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">حفظ التغييرات</button>
                <a href="{{ route('volunteer.dashboard') }}" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>

    <style>
        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .profile-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }

        .profile-form {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .form-section h2 {
            font-size: 1.25rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control:disabled {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }

        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-cancel {
            background: #e9ecef;
            color: #2c3e50;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #dee2e6;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
@endsection
