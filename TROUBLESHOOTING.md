# KrishiSheba - সমস্যা সমাধান গাইড

## সাধারণ সমস্যা এবং সমাধান

### 🔴 ডাটাবেস সংযোগ ত্রুটি

**সমস্যা:** `SQLSTATE[HY000]: General error`

**সমাধান:**
```bash
# ১. .env ফাইল পরীক্ষা করুন
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=krishisheba
DB_USERNAME=root
DB_PASSWORD=

# ২. MySQL সেবা চালু আছে কিনা যাচাই করুন
# Control Panel > Services > MySQL80

# ৩. ডাটাবেস পুনরায় তৈরি করুন
mysql -u root -p
DROP DATABASE krishisheba;
CREATE DATABASE krishisheba;
EXIT;

# ৪. মাইগ্রেশন পুনরায় চালান
php artisan migrate
```

---

### 🔴 কম্পোজার প্যাকেজ ত্রুটি

**সমস্যা:** `Class Not Found` ত্রুটি

**সমাধান:**
```bash
# ১. Autoloader রিসেট করুন
composer dump-autoload

# ২. ক্যাশ সাফ করুন
php artisan cache:clear

# ৩. পুনরায় ইনস্টল করুন
composer install
```

---

### 🔴 ফাইল অনুমতি সমস্যা

**সমস্যা:** ছবি আপলোড কাজ করছে না

**সমাধান:**
```bash
# স্টোরেজ লিঙ্ক তৈরি করুন
php artisan storage:link

# ফোল্ডার অনুমতি সেট করুন
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

**উইন্ডোজে:**
```
ফোল্ডার ডান-ক্লিক > বৈশিষ্ট্য > নিরাপত্তা > সম্পাদনা করুন > পূর্ণ নিয়ন্ত্রণ চেক করুন
```

---

### 🔴 লগইন সমস্যা

**সমস্যা:** সঠিক শংসাপত্র পরে ও লগইন ব্যর্থ

**সমাধান:**
```bash
# ১. ব্রাউজার ক্যাশ সাফ করুন
# Ctrl + Shift + Delete চাপুন

# ২. গোপনীয় মোডে লগইন করুন

# ৩. ডাটাবেস ব্যবহারকারী পরীক্ষা করুন
mysql> SELECT * FROM users;

# ৪. সেশন পুনরায় চালু করুন
php artisan session:table
php artisan migrate
```

---

### 🔴 পেজ খুঁজে পাওয়া যায় না (404)

**সমস্যা:** `NotFoundHttpException`

**সমাধান:**
```bash
# ১. রুট ক্যাশ পরিষ্কার করুন
php artisan route:cache
php artisan route:clear

# ২. সঠিক ইউআরএল ব্যবহার করছেন কিনা যাচাই করুন
# সঠিক: /লগইন
# ভুল: /login

# ৩. সব রুট দেখুন
php artisan route:list
```

---

### 🔴 ব্লেড টেমপ্লেট ত্রুটি

**সমস্যা:** `Undefined variable` ত্রুটি

**সমাধান:**
```blade
// ❌ ভুল - ভেরিয়েবল পাস করা হয়নি
return view('admin.dashboard');

// ✅ সঠিক - ভেরিয়েবল পাস করা হয়েছে
return view('admin.dashboard', compact('totalUsers'));

// ভিউতে চেক করুন
@isset($variable)
    {{ $variable }}
@else
    কোনো ডেটা নেই
@endisset
```

---

### 🔴 ফর্ম জমা দেওয়ার ত্রুটি

**সমস্যা:** 419 Token Mismatch ত্রুটি

**সমাধান:**
```blade
<!-- CSRF টোকেন যোগ করুন -->
<form action="{{ route('submit') }}" method="POST">
    @csrf
    <!-- ফর্ম ফিল্ড -->
</form>

<!-- অথবা -->
{{ csrf_field() }}
```

---

### 🔴 পেজিনেশন সমস্যা

**সমস্যা:** পেজিনেশন লিঙ্ক ভুল

**সমাধান:**
```php
// সঠিক ব্যবহার
$users = User::paginate(15);

// ভিউতে
{{ $users->links('pagination::bootstrap-5') }}

// ফিল্টার সহ পেজিনেশন
$users = User::where('role', 'farmer')->paginate(15);
{{ $users->appends(request()->query())->links() }}
```

---

### 🔴 ছবি আপলোড সমস্যা

**সমস্যা:** ছবি সংরক্ষিত হচ্ছে না

**সমাধান:**
```php
// স্টোরেজ ডিস্ক ব্যবহার করুন
if ($request->hasFile('ছবি')) {
    $imagePath = $request->file('ছবি')->store('products', 'public');
    $product->ছবি = $imagePath;
}

// config/filesystems.php পরীক্ষা করুন
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
    ],
]
```

---

### 🔴 ভূমিকা অ্যাক্সেস সমস্যা

**সমস্যা:** 403 অননুমোদিত ত্রুটি

**সমাধান:**
```php
// মিডলওয়্যার পরীক্ষা করুন
Route::middleware(['auth', 'admin'])->group(function () {
    // শুধুমাত্র প্রশাসকদের জন্য
});

// ব্যবহারকারীর ভূমিকা যাচাই করুন
if (!auth()->user()->isAdmin()) {
    abort(403);
}
```

---

### 🔴 ডাটাবেস মাইগ্রেশন ত্রুটি

**সমস্যা:** `Integrity constraint violation`

**সমাধান:**
```bash
# ১. বর্তমান মাইগ্রেশন রোল করুন
php artisan migrate:rollback

# ২. সব মাইগ্রেশন রোল করুন
php artisan migrate:reset

# ৩. পুনরায় সব মাইগ্রেশন চালান
php artisan migrate
php artisan db:seed
```

---

### 🔴 চ্যার নাম সমস্যা

**সমস্যা:** বাংলা কলাম নামে `?` দেখা যাচ্ছে

**সমাধান:**
```bash
# MySQL এ UTF-8 এনকোডিং সেট করুন
mysql> ALTER DATABASE krishisheba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# .env এ যোগ করুন
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

---

### 🔴 পাসওয়ার্ড রিসেট

**সমস্যা:** পাসওয়ার্ড ভুলে গেছেন

**সমাধান:**
```bash
# Laravel Tinker ব্যবহার করুন
php artisan tinker

# টিংকারে
>>> $user = App\Models\User::where('ইমেইল', 'admin@krishisheba.com')->first();
>>> $user->update(['পাসওয়ার্ড' => bcrypt('নতুন_পাসওয়ার্ড')]);
>>> exit
```

---

### 🔴 মেমরি সীমা ত্রুটি

**সমস্যা:** `Allowed memory size exhausted`

**সমাধান:**
```bash
# php.ini সম্পাদনা করুন
memory_limit = 256M

# অথবা কমান্ডে
php -d memory_limit=256M artisan serve

# কমান্ডে অনুমতি বৃদ্ধি করুন
php -r "echo ini_get('memory_limit');"
```

---

### 🔴 আর্টিসান কমান্ড ত্রুটি

**সমস্যা:** `Command not found`

**সমাধান:**
```bash
# সম্পূর্ণ পথ ব্যবহার করুন
c:\xampp\php\php.exe artisan migrate

# অথবা প্রকল্পে cd করুন
cd c:\xampp\htdocs\KrishiSheba
php artisan migrate
```

---

### 🔴 নেভিগেশন ব্রেকপয়েন্ট সমস্যা

**সমস্যা:** মেনু লিঙ্ক কাজ করছে না

**সমাধান:**
```blade
<!-- route() ফাংশন ব্যবহার করুন -->
<a href="{{ route('admin.dashboard') }}">ড্যাশবোর্ড</a>

<!-- URL হার্ডকোড করবেন না -->
<!-- ❌ <a href="/প্রশাসক/ড্যাশবোর্ড"> -->

<!-- রুট নাম পরীক্ষা করুন -->
php artisan route:list | grep dashboard
```

---

## 🔍 ডিবাগিং টিপস

### লগ ফাইল পরীক্ষা করুন
```bash
# সর্বশেষ লগ দেখুন
tail -f storage/logs/laravel.log

# উইন্ডোজে
Get-Content storage/logs/laravel.log -Tail 50
```

### ডাম্প এবং ডাই ব্যবহার করুন
```php
// ডাটা দেখুন এবং থামিয়ে দিন
dd($data);

// শুধু ডাম্প করুন
dump($data);
```

### Laravel Debugbar ইনস্টল করুন
```bash
composer require barryvdh/laravel-debugbar --dev
```

---

## 📞 সাহায্য পান

কোনো সমস্যা থাকলে:

1. **লগ ফাইল পরীক্ষা করুন** - `storage/logs/laravel.log`
2. **ত্রুটি বার্তা পড়ুন** - বিস্তারিত তথ্য আছে
3. **ডাটাবেস সংযোগ যাচাই করুন** - সঠিক শংসাপত্র?
4. **অনুমতি পরীক্ষা করুন** - ফোল্ডার লিখনযোগ্য?
5. **PHP সংস্করণ** - PHP 8.1+ প্রয়োজন

---

## ⚡ পারফরম্যান্স টিপস

```bash
# অপ্টিমাইজেশন চালান
php artisan optimize

# ক্যাশ সাফ করুন
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# মাইগ্রেশন অপ্টিমাইজ করুন
php artisan migrate --seed
```

---

**সর্বশেষ আপডেট:** এপ্রিল ২০২৪
