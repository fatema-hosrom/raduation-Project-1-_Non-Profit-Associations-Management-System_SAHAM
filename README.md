# 🤝 نظام ساهم (SAHEM) -  نظام إدارة الجمعيات الأهلية

<p align="center">
  <strong>منصة متقدمة لربط المتطوعين والمنظمات الخيرية والمانحين</strong>
</p>

---

## 📖 نظرة عامة على النظام

**ساهم (SAHEM)** هو نظام ويب متكامل مبني على **Laravel 12** لإدارة العمل التطوعي والخيري. يوفر منصة شاملة تربط بين:
- 🏢 **المنظمات الخيرية** - التي تنظم الفعاليات والأنشطة
- 🙋 **المتطوعين** - الذين يساهمون بوقتهم وجهدهم
- 💰 **المانحين** - الذين يساهمون بالمبالغ المالية
- 👨‍💼 **المديرين والمشرفين** - الذين يدارون النظام

---

## 🎯 الفكرة الأساسية

النظام يقوم على **ثلاث ركائز أساسية:**

1. **📋 إدارة الفعاليات والأنشطة الخيرية**
   - فعاليات خاصة بالتبرعات المالية
   - فعاليات خاصة بالتطوع
   - فعاليات مختلطة (تبرع + تطوع)

2. **👥 إدارة المتطوعين ومتطلباتهم**
   - جمع بيانات المتطوعين الشاملة (المهارات، الخبرة، التوافر)
   - تحديد متطلبات المتطوعين لكل فعالية
   - معايير الاختيار (السن، الجنس، المهارات المطلوبة)

3. **💵 إدارة جمع التبرعات والمساهمات المالية**
   - تحديد الهدف المالي لكل فعالية
   - تتبع المبالغ المجمعة
   - إدارة حالة التبرع (مفتوح/مكتمل/مغلق)

---

## 👥 الأطراف المستخدمة (Roles)

| الدور | الصلاحيات |
|------|---------|
| **Manager (مدير)** | ✓ إنشاء الفعاليات ✓ إدارة الأنشطة ✓ معالجة التبرعات ✓ إدارة متطلبات المتطوعين |
| **Supervisor (مشرف)** | ✓ الإشراف على الفعاليات ✓ مراجعة الأنشطة ✓ إدارة الحالات |
| **Volunteer (متطوع)** | ✓ تسجيل البيانات الشخصية ✓ إدارة المهارات ✓ تحديد التوافر الزمني |
| **Organization (جمعية)** | ✓ إنشاء وإدارة الفعاليات ✓ عرض المعلومات الخاصة بها |
| **Public User (مستخدم عام)** | ✓ مشاهدة الفعاليات ✓ التسجيل كمتطوع ✓ الاطلاع على المنظمات |

---

## 🏗️ الهيكل التقني

### التقنيات المستخدمة:
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templates, Tailwind CSS 3.4.19, Vite 7.0.7
- **Database**: MySQL/PostgreSQL (مع دعم SQLite)
- **Authentication**: Laravel Guards مخصصة
- **Build Tool**: Vite مع Laravel Vite Plugin

### المعمارية:
- **4-Layer Architecture**: Presentation → Application → Domain → Infrastructure
- **8 Models** مع علاقات Eloquent منظمة
- **10 Controllers** منقسمة على 3 مجموعات
- **46 Blade Templates** للواجهات

---

## 🗄️ هيكل قاعدة البيانات

### الجداول الرئيسية:

#### 1️⃣ **Managers** - جدول المديرين
```
- id (PK), username (فريد), email (فريد), password (مشفرة)
- full_name, phone, manager_type (financial/activities)
- status (active/inactive), created_by (FK), timestamps
```

#### 2️⃣ **Organizations** - جدول المنظمات
```
- id (PK), name, description, type (local/external)
- contact info, logo, status, created_by (FK), timestamps
```

#### 3️⃣ **Organization Activities** - جدول أنشطة ساهم
```
- id (PK), title, description, activity_type (donation/volunteer/both)
- dates, location, status, manager_id (FK), timestamps
```

#### 4️⃣ **Activity Donation Settings** - إعدادات التبرعات
```
- activity_id (FK), target_amount, collected_amount
- donation_status (open/completed/closed), softDeletes
```

#### 5️⃣ **Activity Volunteer Requirements** - متطلبات المتطوعين
```
- activity_id (FK), required_volunteers, volunteers_count
- min_age, gender_requirement, skills_required, softDeletes
```

#### 6️⃣ **Volunteers** - جدول المتطوعين
```
- id (PK), personal info, skills, experience
- availability, preferred_roles, languages, status
```

#### 7️⃣ **Organization Events** - فعاليات الجمعيات
```
- organization_id (FK), title, dates, location, status
```

#### 8️⃣ **Supervisor** - جدول المشرفين
```
- id (PK), username, email, password, full_name, phone, status
```

---

## 🚀 التثبيت والتشغيل

### المتطلبات:
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL/PostgreSQL

### خطوات التثبيت:

```bash
# 1. تحميل المشروع
git clone <repository-url>
cd SAHAM-System

# 2. تثبيت تبعيات PHP
composer install

# 3. إعداد متغيرات البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات
php artisan migrate
php artisan db:seed

# 5. تثبيت تبعيات Node.js
npm install

# 6. بناء الأصول
npm run build

# 7. تشغيل الخادم
php artisan serve
```

### أوامر مفيدة:
```bash
# تشغيل في وضع التطوير
composer run dev

# تشغيل الاختبارات
php artisan test

# إنشاء نسخة احتياطية
php artisan backup:run
```

---

## 📊 الإحصائيات

- **النماذج**: 8 models
- **المتحكمات**: 10 controllers
- **العروض**: 46 blade templates
- **الهجرات**: 9 migrations
- **العلاقات**: 12 relationships
- **المسارات**: 3 route files

---

## 🎨 الميزات الرئيسية

### للمديرين:
- ✅ إنشاء وإدارة الجمعيات والفعاليات
- ✅ إدارة أنشطة ساهم (تبرعات + تطوع)
- ✅ متابعة التبرعات والمتطوعين
- ✅ إدارة الملف الشخصي

### للمشرفين:
- ✅ مراقبة جميع الأنشطة
- ✅ إدارة المديرين والصلاحيات
- ✅ مراجعة طلبات المتطوعين
- ✅ إحصائيات شاملة

### للمتطوعين:
- ✅ تسجيل بيانات شاملة
- ✅ تحديد المهارات والخبرات
- ✅ اختيار الأدوار المفضلة
- ✅ متابعة الأنشطة

### للزوار:
- ✅ تصفح الجمعيات والفعاليات
- ✅ التسجيل كمتطوع
- ✅ الاطلاع على التفاصيل

---

## 🔧 التطوير والمساهمة

### إعداد بيئة التطوير:
```bash
# تثبيت تبعيات التطوير
composer install --dev
npm install

# تشغيل الخادم مع إعادة التحميل التلقائي
npm run dev
php artisan serve
```

### هيكل المشروع:
```
SAHAM-System/
├── app/                    # Laravel Application
│   ├── Models/            # Eloquent Models (8)
│   ├── Http/Controllers/  # Controllers (10)
│   └── Http/Middleware/   # Custom Middleware
├── database/              # Migrations & Seeders
├── resources/             # Views & Assets
│   ├── views/            # Blade Templates (46)
│   └── css/js/           # Frontend Assets
├── routes/                # Route Definitions
├── docs/                  # Documentation & Diagrams
└── public/                # Public Assets
```

---

## 📈 خطة التطوير المستقبلية

### المرحلة القادمة:
- 🔄 **API Layer**: RESTful API للتطبيقات المحمولة
- 📱 **Mobile App**: تطبيق محمول للمتطوعين
- 🤖 **AI Matching**: مطابقة ذكية بين المتطوعين والأنشطة
- 📊 **Advanced Analytics**: تحليلات متقدمة وتقارير
- 🌐 **Multi-language**: دعم لغات إضافية
- 🔐 **Two-Factor Auth**: مصادقة ثنائية العامل

### التحسينات المخططة:
- ⚡ **Performance**: تحسين الأداء والذاكرة المؤقتة
- 🧪 **Testing**: زيادة تغطية الاختبارات
- 📧 **Notifications**: نظام إشعارات متقدم
- 📁 **File Management**: نظام أفضل للملفات
- 🔍 **Search**: بحث متقدم وفلترة

---

## 📞 الدعم والتواصل

- 📧 **Email**: support@sahem-system.com
- 📱 **Phone**: +966-XX-XXXXXXX
- 🐛 **Issues**: [GitHub Issues](https://github.com/username/SAHAM-System/issues)
- 📖 **Documentation**: [Wiki](https://github.com/username/SAHAM-System/wiki)

---

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة **MIT License**. راجع ملف `LICENSE` للمزيد من التفاصيل.

---

<p align="center">
  <strong>نظام ساهم - منصة الخير والتطوع الرقمية</strong>
</p>
- title
- description
- start_date
- end_date
- location
- status: [upcoming, ongoing, completed, cancelled]
- image
- external_url
- created_by: [FK من managers]
- timestamps
```

#### 5️⃣ **Organization Activities** - جدول الأنشطة والفعاليات
```
- id (PK)
- title
- description
- activity_type: [donation, volunteer, both]
- location
- start_date
- end_date
- image
- status: [active, closed, draft]
- is_published: boolean
- manager_id: [FK]
- approved_by: [FK من managers]
- timestamps
```

#### 6️⃣ **Activity Donation Settings** - جدول إعدادات التبرعات
```
- id (PK)
- activity_id: [FK]
- target_amount: قيمة عددية
- collected_amount: قيمة عددية
- donation_status: [open, completed, closed]
- timestamps
- soft_deletes
```

#### 7️⃣ **Activity Volunteer Requirements** - جدول متطلبات المتطوعين
```
- id (PK)
- activity_id: [FK]
- required_volunteers: العدد المطلوب
- volunteers_count: العدد الحالي
- volunteer_mode: [manual, auto]
- min_age: الحد الأدنى للسن
- gender_requirement: النوع المطلوب
- skills_required: المهارات المطلوبة
- min_hours: الحد الأدنى للساعات
- timestamps
- soft_deletes
```

#### 8️⃣ **Volunteers** - جدول المتطوعين
```
- id (PK)
- name
- email (فريد)
- phone
- gender
- age
- nationality
- address
- skills: مهارات المتطوع
- experience: خبرة المتطوع
- education_level: المستوى التعليمي
- availability: التوافر الزمني
- preferred_roles: الأدوار المفضلة
- languages: اللغات
- emergency_contact: جهة الاتصال في الطوارئ
- status: [pending, active, inactive]
- timestamps
```

### 🔗 العلاقات بين الجداول:

```
┌─────────────────────────────────────────────────────────┐
│                    MANAGERS (1)                         │
│          يدير/ينشئ منظمات وأنشطة                      │
└────────────────┬────────────────────────────────────────┘
                 │ (1:N) Creates
                 ▼
┌──────────────────────────────────────────────────────┐
│         ORGANIZATION_ACTIVITIES (N)                  │
│    نشاط واحد له إعدادات تبرعات ومتطلبات متطوعين   │
└──────────────────────────────────────────────────────┘
         │ (1:1)           │ (1:1)
         ▼                 ▼
    ┌──────────────────┐  ┌─────────────────────┐
    │DONATION_SETTINGS │  │VOLUNTEER_REQUIREMENT│
    │  (N:1)          │  │  (N:1)              │
    └──────────────────┘  └─────────────────────┘

┌──────────────────────────────────────────────────────┐
│        ORGANIZATIONS (N من Manager)                 │
│     منظمة واحدة لها عدة أحداث                       │
└──────────────────────────────────────────────────────┘
         │ (1:N)
         ▼
┌──────────────────────────────────────────────────────┐
│     ORGANIZATION_EVENTS (N)                          │
│        أحداث المنظمات                               │
└──────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────┐
│          VOLUNTEERS (N)                              │
│      المتطوعون المسجلون في النظام                   │
└──────────────────────────────────────────────────────┘
```

---

## 🎨 المكونات الرئيسية

### Models (النماذج)
- `Manager` - مدير الأنشطة والفعاليات
- `Supervisor` - مشرف النظام
- `Organization` - المنظمات الخيرية
- `OrganizationEvent` - أحداث المنظمات
- `OrganizationActivity` - الأنشطة والفعاليات
- `Volunteer` - المتطوعون
- `ActivityDonationSettings` - إعدادات التبرعات
- `ActivityVolunteerRequirements` - متطلبات المتطوعين

### Controllers (متحكمات)
- `PublicController` - الصفحات والمعلومات العامة
- `VolunteerController` - إدارة المتطوعين
- `ManagerController` - لوحة تحكم المدير
- `OrganizationController` - إدارة المنظمات
- `ActivityController` - إدارة الأنشطة

### Routes (المسارات)
- **Public Routes** (`/sahem`) - للمستخدمين العامين
- **Manager Routes** - للمديرين
- **Supervisor Routes** - للمشرفين

---

## ✨ الميزات الرئيسية

### 🎯 نظام الفعاليات المرن
- ✅ فعاليات تبرعات فقط
- ✅ فعاليات تطوع فقط
- ✅ فعاليات مختلطة (تبرع + تطوع)
- ✅ حالات متعددة (نشط، مغلق، مسودة)

### 🧑‍💼 إدارة متطلبات المتطوعين
- ✅ الحد الأدنى للسن
- ✅ تصنيف حسب النوع (ذكر/أنثى)
- ✅ المهارات المطلوبة
- ✅ الحد الأدنى للساعات المطلوبة
- ✅ عدد المتطوعين المطلوبين

### 💵 نظام إدارة التبرعات
- ✅ تحديد الهدف المالي
- ✅ تتبع المبلغ المجمع
- ✅ حالات التبرع (مفتوح/مكتمل/مغلق)

### 👥 إدارة شاملة للمتطوعين
- ✅ جمع بيانات شاملة
- ✅ تسجيل المهارات والخبرة
- ✅ تحديد التوافر الزمني
- ✅ تتبع حالة المتطوع

### 🔐 نظام متعدد الأدوار
- ✅ نظام authentication مدمج
- ✅ صلاحيات مختلفة لكل دور
- ✅ إدارة آمنة للبيانات

---

## 💪 نقاط القوة

| النقطة | التفاصيل |
|-------|---------|
| 🏗️ **هيكل منطقي** | قاعدة بيانات منطية وقابلة للتوسع |
| 🚀 **تقنيات حديثة** | استخدام Laravel 12 (أحدث إصدار) |
| 🛡️ **حماية البيانات** | Soft Deletes للحفاظ على البيانات التاريخية |
| ⏰ **تتبع التغييرات** | Timestamps لجميع العمليات |
| 🔗 **تكامل البيانات** | Foreign Keys لضمان الارتباط الصحيح |
| 🎛️ **مرونة الأدوار** | نظام roles قابل للتطوير |

---

## ⚠️ نقاط قيد التطوير

| المشكلة | الحل المقترح | الحالة |
|--------|------------|--------|
| ❌ لا توجد علاقة مباشرة بين Volunteers و Activities | ✅ إضافة جدول وسيط `volunteer_activity` (pivot table) | قيد التطوير |
| ❌ نظام التبرعات غير كامل | ✅ إضافة جدول `Donations` | قيد التطوير |
| ❌ نقص بعض العلاقات في النماذج | ✅ إكمال جميع Eloquent Relationships | قيد التطوير |
| ❌ لا توجد نظام تقييم | ✅ إضافة نظام ratings و reviews | قيد التطوير |
| ❌ لا يوجد نظام تقارير | ✅ إضافة إحصائيات وتقارير شاملة | قيد التطوير |


---

## 🛠️ التثبيت والإعداد

### المتطلبات:
- PHP 8.2 أو أعلى
- Composer
- Node.js و npm
- قاعدة بيانات (MySQL/PostgreSQL)

### خطوات التثبيت:

```bash
# 1. استنساخ المستودع
git clone <repository-url>
cd SAHAM-System
# 2. تثبيت المكتبات
composer install

# 3. إنشاء ملف البيئة
cp .env.example .env

# 4. توليد مفتاح التطبيق
php artisan key:generate

# 5. تثبيت مكتبات npm
npm install

# 6. إنشاء الهجرات
php artisan migrate

# 7. تشغيل الخادم
php artisan serve

# 8. تشغيل وحدة المراقبة (في terminal منفصل)
npm run dev
```

---

## 📝 ملفات البيئة

قم بتعديل `.env` بقيمك الخاصة:

```env
APP_NAME="SAHEM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sahem_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## 🧪 الاختبار

```bash
# تشغيل جميع الاختبارات
php artisan test

# اختبار ملف محدد
php artisan test tests/Feature/VolunteerTest.php
```

---

## 📚 الموارد الإضافية

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel API Documentation](https://laravel.com/api)
- [Eloquent ORM](https://laravel.com/docs/eloquent)


---

**آخر تحديث:** 3 يناير 2026
**النسخة:** 1.0.0 (قيد التطوير)
