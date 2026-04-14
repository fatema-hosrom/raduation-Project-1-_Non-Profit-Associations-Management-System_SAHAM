<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ساهم')</title>

    <!-- Tailwind CSS CDN -->
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #f4f7fb;
        }

        .hero-slide {
            background-size: cover;
            background-position: center;
        }
    </style>
    @stack('styles')
</head>

<body class="relative">

    <!-- Navbar -->
    <header class="bg-[#2c3e50] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <!-- القائمة اليمنى -->
                <nav class="hidden md:flex space-x-6 rtl:space-x-reverse">
                    <a href="{{ route('public.home') }}"
                        class="font-semibold hover:text-yellow-300 transition">الرئيسية</a>
                    <a href="{{ route('public.organizations.index') }}"
                        class="font-semibold hover:text-yellow-300 transition">الجمعيات</a>
                    <a href="{{ route('public.organization.events_index') }}"
                        class="font-semibold hover:text-yellow-300 transition">فعاليات الجمعيات</a>
                </nav>

                <!-- الشعار -->
                <div class="flex-shrink-0">
                    <img src="/assets/images/logos/logo.png" alt="شعار ساهم"
                        class="h-24 mx-auto transform hover:scale-110 transition duration-500">
                </div>

                <!-- القائمة اليسرى -->
                <nav class="hidden md:flex space-x-6 rtl:space-x-reverse items-center">
                    <a href="{{ route('public.activities.index') }}"
                        class="font-semibold hover:text-yellow-300 transition">فعاليات ساهم</a>

                    @if (session('volunteer_id'))
                        <div class="flex items-center gap-4">
                            <span class="font-semibold">{{ session('volunteer_name') }}</span>
                            <a href="{{ route('volunteer.dashboard') }}"
                                class="bg-yellow-400 text-gray-800 px-3 py-1 rounded font-semibold hover:bg-yellow-300 transition">
                                لوحتي
                            </a>
                            <a href="{{ route('volunteer.logout') }}"
                                class="text-red-400 hover:text-red-300 transition">تسجيل خروج</a>
                        </div>
                    @else
                        <button onclick="openLoginModal()"
                            class="bg-yellow-400 text-gray-800 px-4 py-2 rounded font-semibold hover:bg-yellow-300 transition">
                            تسجيل الدخول
                        </button>
                        <a href="{{ route('public.volunteer.register') }}"
                            class="font-semibold hover:text-yellow-300 transition">كن متطوع</a>
                    @endif
                </nav>

                <!-- زر الموبايل -->
                <div class="md:hidden">
                    <button id="mobile-toggle" class="text-white text-3xl focus:outline-none">☰</button>
                </div>
            </div>

            <!-- قائمة الموبايل -->
            <div id="mobile-menu"
                class="md:hidden hidden flex-col space-y-4 mt-4 text-center bg-[#2c3e50] rounded-lg p-4">
                <a href="{{ route('public.home') }}" class="block hover:text-yellow-300 transition">الرئيسية</a>
                <a href="{{ route('public.organizations.index') }}"
                    class="block hover:text-yellow-300 transition">الجمعيات</a>
                <a href="{{ route('public.organization.events_index') }}"
                    class="block hover:text-yellow-300 transition">فعاليات الجمعيات</a>
                <a href="{{ route('public.activities.index') }}" class="block hover:text-yellow-300 transition">فعاليات
                    ساهم</a>

                @if (session('volunteer_id'))
                    <a href="{{ route('volunteer.dashboard') }}"
                        class="block bg-yellow-400 text-gray-800 px-3 py-2 rounded font-semibold hover:bg-yellow-300 transition">
                        لوحتي
                    </a>
                    <a href="{{ route('volunteer.logout') }}"
                        class="block text-red-400 hover:text-red-300 transition">تسجيل خروج</a>
                @else
                    <button onclick="openLoginModal()"
                        class="block w-full bg-yellow-400 text-gray-800 px-3 py-2 rounded font-semibold hover:bg-yellow-300 transition">
                        تسجيل الدخول
                    </button>
                    <a href="{{ route('public.volunteer.register') }}" class="block hover:text-yellow-300 transition">كن
                        متطوع</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Slider (صورتين لكل شريحة) -->
    {{-- يظهر فقط بصفحة ال HOME  --}}
    @if (Request::routeIs('public.home'))

        <div class="relative mt-6 overflow-hidden rounded-xl h-128 md:h-[500px]">
            @php
                $allItems = array_merge($recentOrgEvents->toArray(), $sahemActivities->toArray());
                $slides = array_chunk($allItems, 2); // كل شريحة تحتوي على صورتين
            @endphp

            @foreach ($slides as $index => $slideItems)
                <div
                    class="hero-slide absolute w-full h-full flex gap-4 transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100' : 'opacity-0' }}">
                    @foreach ($slideItems as $item)
                        @php
                            $title = $item['title'] ?? '';
                            $imagePath = $item['image'] ?? null;

                            // تحقق من نوع الفعالية والمسار الصحيح
                            if (isset($item['organization_id'])) {
                                // نشاط جمعية
                                $fullPath =
                                    $imagePath &&
                                    file_exists(public_path('assets/images/organization_events/' . $imagePath))
                                        ? 'assets/images/organization_events/' . $imagePath
                                        : 'assets/images/default-event.png';
                            } else {
                                // نشاط ساهم
                                $fullPath =
                                    $imagePath && file_exists(public_path('assets/images/activities/' . $imagePath))
                                        ? 'assets/images/activities/' . $imagePath
                                        : 'assets/images/default-event.png';
                            }
                        @endphp

                        <div class="w-1/2 relative overflow-hidden rounded-lg">
                            <img src="{{ asset($fullPath) }}" alt="{{ $title }}"
                                class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-xl md:text-2xl font-bold text-center px-2">
                                {{ $title }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <!-- أزرار التحكم -->
            <button id="prev-slide"
                class="absolute top-1/2 left-2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/60 transition z-10">
                &#10094;
            </button>
            <button id="next-slide"
                class="absolute top-1/2 right-2 -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/60 transition z-10">
                &#10095;
            </button>
        </div>
    @endif

    <!-- Modal Login للمتطوعين -->
    <div id="loginModal" class="login-modal" style="display: none;">
        <div class="login-modal-backdrop"></div>
        <div class="login-modal-box">
            <div class="login-modal-header">
                <h2>تسجيل دخول المتطوع</h2>
                <button type="button" onclick="closeLoginModal()" class="close-btn">&times;</button>
            </div>

            <form method="POST" action="{{ route('volunteer.login.post') }}" class="login-form">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-control" required
                        value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-login-submit">دخول</button>
            </form>

            <div class="login-footer">
                <p>ليس لديك حساب؟
                    <a href="{{ route('public.volunteer.register') }}" onclick="closeLoginModal()">سجل كمتطوع</a>
                </p>
            </div>
        </div>
    </div>

    <style>
        .login-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-modal-backdrop {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .login-modal-box {
            position: relative;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            max-width: 400px;
            width: 90%;
        }

        .login-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 1rem;
        }

        .login-modal-header h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.5rem;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #6c757d;
            padding: 0;
            width: 32px;
            height: 32px;
        }

        .close-btn:hover {
            color: #2c3e50;
        }

        .login-form {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #ffc107;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
        }

        .btn-login-submit {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background-color: #ffc107;
            color: #2c3e50;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login-submit:hover {
            background-color: #ffb700;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        .login-footer {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #dee2e6;
        }

        .login-footer p {
            margin: 0;
            color: #6c757d;
        }

        .login-footer a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // إغلاق عند الضغط على الخلفية
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('login-modal-backdrop')) {
                closeLoginModal();
            }
        });

        // إغلاق بـ Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });
    </script>

    <!-- Main Content -->
    <main class="container mx-auto my-2 px-4">

        <!-- رسائل النجاح والخطأ -->
        @if (session('success'))
            <div id="successMessage"
                class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg"
                role="alert" style="z-index: 9999; min-width: 300px;">
                <i class="fas fa-check-circle ms-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div id="errorMessage"
                class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-4 shadow-lg"
                role="alert" style="z-index: 9999; min-width: 300px;">
                <i class="fas fa-exclamation-circle ms-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#2c3e50] text-white">
        <div
            class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-center">

            <!-- الشعار -->
            <div class="flex items-center justify-center">
                <img src="/assets/images/logos/logo.png" alt="شعار ساهم"
                    class="h-14 hover:scale-105 transition duration-300">
                <p class="max-w-xs text-sm leading-relaxed">
                    منصة ساهم لدعم الجمعيات والفعاليات الإنسانية وتسهيل المشاركة التطوعية
                </p>
            </div>

            <!-- الروابط -->
            <div class="flex flex-wrap justify-center gap-6 text-sm font-medium">
                <a href="#" class="hover:text-yellow-300 transition">عن المنصة</a>
                <a href="#" class="hover:text-yellow-300 transition">سياسة الخصوصية</a>
                <a href="#" class="hover:text-yellow-300 transition">الشروط</a>
                <a href="#" class="hover:text-yellow-300 transition">تواصل معنا</a>
                <a href="{{ route('auth.login') }}" class="hover:text-yellow-300 transition">تسجيل الدخول
                    الموظفين</a>
            </div>

            <!-- الحقوق -->
            <div class="text-xs text-gray-300">
                © {{ date('Y') }} ساهم
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const toggleBtn = document.getElementById('mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Hero Slider
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
                if (i === index) slide.classList.remove('opacity-0'), slide.classList.add('opacity-100');
            });
        }

    @stack('scripts')
</body>

</html>
