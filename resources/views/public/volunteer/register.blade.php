@extends('public.template_layouts.app')

@section('title', 'تسجيل متطوع - ساهم')

@push('styles')
<style>
    body { background: #f1f5f9 !important; font-family: 'Tajawal', sans-serif; }

    :root {
        --blue:    #1d4ed8;
        --blue-lt: #eff6ff;
        --blue-md: #bfdbfe;
        --border:  #e2e8f0;
        --slate:   #475569;
        --shadow:  0 1px 4px rgba(0,0,0,0.05), 0 4px 20px rgba(0,0,0,0.07);
    }

    /* PAGE */
    .vol-page {
        max-width: 860px;
        margin: 48px auto;
        padding: 0 20px 80px;
    }

    /* HERO HEADER */
    .vol-hero {
        background: linear-gradient(130deg, #1e3a8a 0%, #1d4ed8 60%, #3b82f6 100%);
        border-radius: 20px;
        padding: 40px 48px;
        color: white;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(29,78,216,0.3);
    }
    .vol-hero::before {
        content: '';
        position: absolute; top: -60px; left: -60px;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(255,255,255,0.06); pointer-events: none;
    }
    .vol-hero::after {
        content: '';
        position: absolute; bottom: -40px; right: 10%;
        width: 150px; height: 150px; border-radius: 50%;
        background: rgba(255,255,255,0.04); pointer-events: none;
    }
    .vol-hero__icon {
        width: 56px; height: 56px; border-radius: 14px;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin-bottom: 16px;
    }
    .vol-hero h1 { font-size: 1.9rem; font-weight: 900; margin: 0 0 8px; letter-spacing: -0.5px; }
    .vol-hero p  { font-size: 0.95rem; opacity: 0.75; margin: 0; }

    /* ALERTS */
    .alert {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 18px; border-radius: 12px;
        font-size: 0.88rem; font-weight: 600; margin-bottom: 24px;
    }
    .alert.success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
    .alert.error   { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }

    /* FORM CARD */
    .form-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    /* SECTION BLOCK */
    .fsection {
        padding: 28px 36px;
        border-bottom: 1px solid #f1f5f9;
    }
    .fsection:last-child { border-bottom: none; }

    .fsection__head {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 22px;
    }
    .fsection__head .bar {
        width: 4px; height: 20px;
        background: linear-gradient(to bottom, var(--blue), #60a5fa);
        border-radius: 2px; flex-shrink: 0;
    }
    .fsection__head h2 {
        font-size: 0.97rem; font-weight: 800; color: #0f172a; margin: 0;
    }

    /* GRID */
    .fgrid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .fgrid .full { grid-column: 1 / -1; }

    /* FIELD */
    .field label {
        display: block;
        font-size: 0.8rem; font-weight: 700; color: #374151;
        margin-bottom: 7px; letter-spacing: 0.2px;
    }

    .field label .opt {
        font-weight: 400; color: #94a3b8; font-size: 0.74rem; margin-right: 4px;
    }

    .finput {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 0.86rem;
        font-family: 'Tajawal', sans-serif;
        color: #1e293b;
        background: #fff;
        transition: border-color 0.18s, box-shadow 0.18s;
        outline: none;
        box-sizing: border-box;
    }
    .finput:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
    }
    .finput::placeholder { color: #94a3b8; }

    textarea.finput { resize: vertical; min-height: 90px; }

    select.finput { cursor: pointer; }

    .ferr {
        font-size: 0.74rem; color: #dc2626;
        margin-top: 5px; display: flex; align-items: center; gap: 4px;
    }

    /* CHECKBOX LIST */
    .check-list {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px;
        max-height: 160px;
        overflow-y: auto;
        display: flex; flex-direction: column; gap: 8px;
        background: #fafafa;
    }
    .check-list:focus-within {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(29,78,216,0.08);
    }
    .check-list::-webkit-scrollbar { width: 4px; }
    .check-list::-webkit-scrollbar-track { background: transparent; }
    .check-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    .check-item {
        display: flex; align-items: center; gap: 9px;
        cursor: pointer; padding: 4px 6px; border-radius: 7px;
        transition: background 0.15s;
    }
    .check-item:hover { background: var(--blue-lt); }

    .check-item input[type="checkbox"] {
        width: 16px; height: 16px;
        border: 1.5px solid #cbd5e1;
        border-radius: 4px; cursor: pointer;
        accent-color: var(--blue);
        flex-shrink: 0;
    }

    .check-item span { font-size: 0.82rem; color: #374151; font-weight: 500; }

    /* SUBMIT */
    .form-footer {
        padding: 24px 36px;
        background: #fafafa;
        border-top: 1px solid #f1f5f9;
    }

    .submit-btn {
        width: 100%;
        background: linear-gradient(130deg, #1e3a8a, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 15px 24px;
        font-size: 1rem; font-weight: 800;
        font-family: 'Tajawal', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        box-shadow: 0 4px 20px rgba(29,78,216,0.3);
        letter-spacing: 0.3px;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(29,78,216,0.4);
    }
    .submit-btn:active { transform: translateY(0); }

    @media (max-width: 640px) {
        .fgrid { grid-template-columns: 1fr; }
        .fsection { padding: 22px 20px; }
        .vol-hero { padding: 28px 24px; }
        .vol-hero h1 { font-size: 1.5rem; }
        .form-footer { padding: 20px; }
    }
</style>
@endpush

@section('content')
<div class="vol-page">

    {{-- HERO --}}
    <div class="vol-hero">
        <div class="vol-hero__icon"><i class="fas fa-hands-helping"></i></div>
        <h1>تسجيل متطوع جديد</h1>
        <p>ساهم معنا في دعم المبادرات الإنسانية والفعاليات التطوعية</p>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="alert success">
        <i class="fas fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert error">
        <i class="fas fa-circle-xmark"></i>
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('public.volunteer.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-card">

            {{-- SECTION 1: معلومات الحساب --}}
            <div class="fsection">
                <div class="fsection__head">
                    <span class="bar"></span>
                    <h2><i class="fas fa-lock" style="color:var(--blue);margin-left:6px;font-size:0.85rem"></i>معلومات الحساب</h2>
                </div>
                <div class="fgrid">
                    <div class="field">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="finput" placeholder="example@mail.com" value="{{ old('email') }}">
                        @error('email')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>كلمة المرور</label>
                        <input type="password" name="password" class="finput" placeholder="أدخل كلمة المرور">
                        @error('password')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="finput" placeholder="أعد إدخال كلمة المرور">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: المعلومات الشخصية --}}
            <div class="fsection">
                <div class="fsection__head">
                    <span class="bar"></span>
                    <h2><i class="fas fa-user" style="color:var(--blue);margin-left:6px;font-size:0.85rem"></i>المعلومات الشخصية</h2>
                </div>
                <div class="fgrid">
                    <div class="field">
                        <label>الاسم الكامل</label>
                        <input type="text" name="name" class="finput" placeholder="أدخل اسمك الكامل" value="{{ old('name') }}">
                        @error('name')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>رقم الهاتف</label>
                        <input type="text" name="phone" class="finput" placeholder="09xx xxx xxx" value="{{ old('phone') }}">
                        @error('phone')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>الجنس</label>
                        <select name="gender" class="finput">
                            <option value="">اختر الجنس</option>
                            <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>العمر</label>
                        <input type="number" name="age" class="finput" placeholder="أدخل عمرك" value="{{ old('age') }}">
                        @error('age')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>الجنسية</label>
                        <select name="nationality" class="finput">
                            <option value="">اختر الجنسية</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name_ar'] }}">{{ $country['name_ar'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>المستوى التعليمي</label>
                        <input type="text" name="education_level" class="finput" placeholder="مثل: بكالوريوس، ثانوي" value="{{ old('education_level') }}">
                        @error('education_level')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field full">
                        <label>العنوان <span class="opt">(اختياري)</span></label>
                        <input type="text" name="address" class="finput" placeholder="أدخل العنوان الكامل" value="{{ old('address') }}">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: معلومات التطوع --}}
            <div class="fsection">
                <div class="fsection__head">
                    <span class="bar"></span>
                    <h2><i class="fas fa-star" style="color:var(--blue);margin-left:6px;font-size:0.85rem"></i>معلومات التطوع</h2>
                </div>
                <div class="fgrid">
                    <div class="field">
                        <label>التوفر <span class="opt">(اختياري)</span></label>
                        <input type="text" name="availability" class="finput" placeholder="مثال: نهاية الأسبوع، صباحاً" value="{{ old('availability') }}">
                    </div>
                    <div class="field">
                        <label>الأدوار المفضلة <span class="opt">(اختياري)</span></label>
                        <input type="text" name="preferred_roles" class="finput" placeholder="مثال: منسق، مدرب" value="{{ old('preferred_roles') }}">
                    </div>
                    <div class="field">
                        <label>اللغات</label>
                        <div class="check-list">
                            @foreach($languages as $lang)
                            <label class="check-item">
                                <input type="checkbox" name="languages[]" value="{{ $lang['name_ar'] }}"
                                    {{ collect(old('languages'))->contains($lang['name_ar']) ? 'checked' : '' }}>
                                <span>{{ $lang['name_ar'] }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('languages')<p class="ferr"><i class="fas fa-circle-exclamation"></i>{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label>جهة الاتصال في الطوارئ <span class="opt">(اختياري)</span></label>
                        <input type="text" name="emergency_contact" class="finput" placeholder="الاسم ورقم الهاتف" value="{{ old('emergency_contact') }}">
                    </div>
                    <div class="field full">
                        <label>المهارات <span class="opt">(اختياري)</span></label>
                        <textarea name="skills" class="finput" placeholder="اذكر مهاراتك التي يمكن الاستفادة منها">{{ old('skills') }}</textarea>
                    </div>
                    <div class="field full">
                        <label>الخبرة <span class="opt">(اختياري)</span></label>
                        <textarea name="experience" class="finput" placeholder="اذكر خبراتك التطوعية السابقة">{{ old('experience') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="form-footer">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    إرسال طلب التسجيل
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
