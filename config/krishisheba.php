<?php

return [

    /*
    |--------------------------------------------------------------------------
    | KrishiSheba Configuration
    |--------------------------------------------------------------------------
    |
    | কৃষি শেবা অ্যাপ্লিকেশনের জন্য কনফিগারেশন সেটিংস
    |
    */

    'app_name' => 'KrishiSheba',
    'app_name_bn' => 'কৃষি শেবা',

    // Roles (ভূমিকা)
    'roles' => [
        'admin' => 'প্রশাসক',
        'farmer' => 'কৃষক',
        'buyer' => 'ক্রেতা',
        'expert' => 'বিশেষজ্ঞ',
    ],

    // Product Categories (পণ্য বিভাগ)
    'categories' => [
        'vegetables' => 'শাকসবজি',
        'fruits' => 'ফল',
        'grains' => 'শস্য',
        'dairy' => 'দুগ্ধ',
        'fish' => 'মাছ',
        'others' => 'অন্যান্য',
    ],

    // Product Status (পণ্য অবস্থা)
    'product_status' => [
        'pending' => 'অপেক্ষমান',
        'approved' => 'অনুমোদিত',
        'rejected' => 'নিরস্ত করা',
    ],

    // Sale Status (বিক্রয় অবস্থা)
    'sale_status' => [
        'pending' => 'অর্ডার_রাখা',
        'confirmed' => 'নিশ্চিত',
        'delivered' => 'ডেলিভার_করা',
        'cancelled' => 'বাতিল',
    ],

    // Units (এককরণ)
    'units' => [
        'kg' => 'কেজি',
        'piece' => 'পিস',
        'liter' => 'লিটার',
        'dozen' => 'ডজন',
        'bundle' => 'বান্ডিল',
        'bag' => 'ব্যাগ',
    ],

    // Pagination
    'pagination_count' => 15,

    // File Upload
    'max_upload_size' => 2048, // in KB
    'allowed_extensions' => ['jpeg', 'png', 'jpg'],

];
