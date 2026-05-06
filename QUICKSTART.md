# KrishiSheba - দ্রুত শুরু গাইড

## 🚀 দ্রুত সেটআপ (৫ মিনিট)

### ধাপ ১: প্রয়োজনীয় ফোল্ডার তৈরি করুন

```bash
cd c:\xampp\htdocs\KrishiSheba

# নিম্নলিখিত ফোল্ডার তৈরি করুন:
# - app
# - app/Models
# - app/Http/Controllers
# - app/Http/Middleware
# - resources/views
# - resources/views/admin
# - resources/views/admin/users
# - resources/views/admin/reports
# - resources/views/farmer
# - resources/views/farmer/products
# - resources/views/buyer
# - resources/views/guest
# - resources/views/auth
# - resources/views/layouts
# - routes
# - database
# - database/migrations
# - database/seeders
# - storage/app/public
# - storage/logs
# - storage/framework/cache
# - storage/framework/sessions
# - storage/framework/views
# - bootstrap/cache
# - public
# - config
```

### ধাপ ২: Composer ডিপেন্ডেন্সি ইনস্টল করুন

```bash
composer install
```

### ধাপ ৩: এনভায়রনমেন্ট সেটআপ

```bash
php artisan key:generate
```

আপনার `.env` ফাইল কনফিগার করুন:

```
DB_DATABASE=krishisheba
DB_USERNAME=root
DB_PASSWORD=
```

### ধাপ ৪: ডাটাবেস সেটআপ

```bash
# MySQL এ ডাটাবেস তৈরি করুন
mysql -u root -p
CREATE DATABASE krishisheba;
EXIT;

# মাইগ্রেশন চালান
php artisan migrate

# সিড ডেটা যোগ করুন (ঐচ্ছিক)
php artisan db:seed
```

### ধাপ ৫: সার্ভার চালান

```bash
php artisan serve
```

এখন `http://localhost:8000` এ অ্যাক্সেস করুন

---

## 📝 পরীক্ষা অ্যাকাউন্ট

### প্রশাসক
- **ইমেইল:** admin@krishisheba.com
- **পাসওয়ার্ড:** admin123

### কৃষক
- **ইমেইল:** farmer@krishisheba.com
- **পাসওয়ার্ড:** farmer123

### ক্রেতা
- **ইমেইল:** buyer@krishisheba.com
- **পাসওয়ার্ড:** buyer123

### বিশেষজ্ঞ
- **ইমেইল:** expert@krishisheba.com
- **পাসওয়ার্ড:** expert123

---

## 🔑 মূল বৈশিষ্ট্য অ্যাক্সেস

### প্রশাসক ড্যাশবোর্ড
`/প্রশাসক/ড্যাশবোর্ড`

- মাসিক বিক্রয় চার্ট
- ব্যবহারকারী পরিসংখ্যান
- ব্যবহারকারী পরিচালনা
- পণ্য অনুমোদন
- বিক্রয় প্রতিবেদন

### কৃষক ড্যাশবোর্ড
`/কৃষক/ড্যাশবোর্ড`

- আমার পণ্য
- নতুন পণ্য যোগ করুন
- বিক্রয় ট্র্যাকিং
- রাজস্ব সারাংশ

### ক্রেতা ড্যাশবোর্ড
`/ক্রেতা/ড্যাশবোর্ড`

- পণ্য ব্রাউজ করুন
- অর্ডার ট্র্যাকিং
- অর্ডার ইতিহাস
- অর্ডার বাতিলকরণ

### অতিথি পৃষ্ঠা
`/` - হোম পেজ
`/পণ্য` - সব পণ্য দেখুন

---

## 🎨 মূল ফাইল অবস্থান

### কন্ট্রোলার
- `app/Http/Controllers/AdminController.php`
- `app/Http/Controllers/FarmerController.php`
- `app/Http/Controllers/BuyerController.php`
- `app/Http/Controllers/GuestController.php`
- `app/Http/Controllers/LoginController.php`
- `app/Http/Controllers/RegisterController.php`

### মডেল
- `app/Models/User.php`
- `app/Models/Product.php`
- `app/Models/Sale.php`

### ভিউ
- `resources/views/admin/` - প্রশাসক ভিউ
- `resources/views/farmer/` - কৃষক ভিউ
- `resources/views/buyer/` - ক্রেতা ভিউ
- `resources/views/guest/` - অতিথি ভিউ
- `resources/views/auth/` - লগইন/রেজিস্ট্রেশন

### রুট
- `routes/web.php` - সব রুট সংজ্ঞায়িত

---

## 🛠️ সাধারণ কাজ

### নতুন ব্যবহারকারী যোগ করুন
1. লগইন করুন (প্রশাসক হিসেবে)
2. প্রশাসক → ব্যবহারকারী
3. "নতুন ব্যবহারকারী যোগ করুন" ক্লিক করুন

### পণ্য অনুমোদন করুন
1. প্রশাসক ড্যাশবোর্ডে যান
2. অপেক্ষমান পণ্য দেখুন
3. অনুমোদন বা প্রত্যাখ্যান করুন

### বিক্রয় রিপোর্ট দেখুন
1. প্রশাসক → বিক্রয় প্রতিবেদন
2. তারিখ পরিসীমা নির্বাচন করুন
3. প্রিন্ট করুন (ঐচ্ছিক)

---

## 🔐 নিরাপত্তা টিপস

1. **পাসওয়ার্ড**: প্রোডাকশনে শক্তিশালী পাসওয়ার্ড ব্যবহার করুন
2. **ইমেইল**: সঠিক ইমেইল ঠিকানা ব্যবহার করুন
3. **ডাটাবেস**: নিয়মিত ব্যাকআপ নিন
4. **অনুমতি**: ফোল্ডার অনুমতি যথাযথভাবে সেট করুন

---

## 📱 ব্রাউজার সামঞ্জস্যতা

- Chrome (সুপারিশকৃত)
- Firefox
- Safari
- Edge

---

## 🐛 সমস্যা সমাধান

### Q: "Class not found" ত্রুটি?
**A:** চালান `composer dump-autoload`

### Q: "SQLSTATE" ত্রুটি?
**A:** `.env` এ ডাটাবেস নাম পরীক্ষা করুন এবং মাইগ্রেশন চালান

### Q: ছবি আপলোড কাজ করছে না?
**A:** চালান `php artisan storage:link`

### Q: লগ আউট করতে পারছেন না?
**A:** ব্রাউজার ক্যাশ সাফ করুন বা ইনকগনিটো মোড ব্যবহার করুন

---

## 📞 সহায়তা

কোনো সমস্যার জন্য:
1. README.md পড়ুন
2. Laravel ডকুমেন্টেশন চেক করুন
3. ডাটাবেস লগ দেখুন (`storage/logs/`)

---

**সংস্করণ:** ১.০  
**ভাষা:** বাংলা (Bengali)  
**সর্বশেষ আপডেট:** এপ্রিল ২০২৪
