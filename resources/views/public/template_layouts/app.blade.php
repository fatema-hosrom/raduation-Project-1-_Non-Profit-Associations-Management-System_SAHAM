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
                <nav class="hidden md:flex space-x-6 rtl:space-x-reverse">
                    <a href="{{ route('public.activities.index') }}"
                        class="font-semibold hover:text-yellow-300 transition">فعاليات ساهم</a>
                    <a href="{{ route('public.volunteer.register') }}"
                        class="font-semibold hover:text-yellow-300 transition">كن متطوع</a>
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
                <a href="{{ route('public.volunteer.register') }}" class="block hover:text-yellow-300 transition">كن
                    متطوع</a>
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
