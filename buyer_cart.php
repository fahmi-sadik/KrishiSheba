<?php
session_start();

// ডাটাবেজ কানেকশন
$host = 'localhost';
$dbname = 'krishisheba';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}

// সেশন থেকে ক্রেতার আইডি নেওয়া
if (!isset($_SESSION['buyer_id'])) {
    $_SESSION['buyer_id'] = 1;
}
$buyer_id = $_SESSION['buyer_id'];

// ইংরেজি সংখ্যাকে বাংলা সংখ্যায় রূপান্তর করার ফাংশন
function enToBn($number) {
    $en = array('0','1','2','3','4','5','6','7','8','9');
    $bn = array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
    return str_replace($en, $bn, $number);
}

// পরিমাণ পরিবর্তন ও মুছে ফেলার লজিক
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $item_id = $_GET['id'];
    if ($action == 'increase') {
        $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id = ? AND buyer_id = ?")->execute([$item_id, $buyer_id]);
    } elseif ($action == 'decrease') {
        $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE id = ? AND buyer_id = ?");
        $stmt->execute([$item_id, $buyer_id]);
        if ($stmt->fetchColumn() > 1) {
            $pdo->prepare("UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND buyer_id = ?")->execute([$item_id, $buyer_id]);
        }
    }
    header("Location: buyer_cart.php"); exit();
}

if (isset($_GET['remove_id'])) {
    $pdo->prepare("DELETE FROM cart WHERE id = ? AND buyer_id = ?")->execute([$_GET['remove_id'], $buyer_id]);
    header("Location: buyer_cart.php"); exit();
}

// কার্ট আইটেম আনা
$stmt = $pdo->prepare("SELECT * FROM cart WHERE buyer_id = ?");
$stmt->execute([$buyer_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0; $total_items = 0;
foreach($cart_items as $item) {
    $subtotal += ($item['price'] * $item['quantity']);
    $total_items += $item['quantity'];
}
$delivery_fee = ($subtotal > 0) ? 50 : 0;
$total_amount = $subtotal + $delivery_fee;

// ক্রেতার তথ্য আনা
$stmt_user = $pdo->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt_user->execute([$buyer_id]);
$buyer_data = $stmt_user->fetch(PDO::FETCH_ASSOC);
$buyer_name = $buyer_data ? $buyer_data['name'] : "সাধারণ ক্রেতা";
$buyer_email = $buyer_data ? $buyer_data['email'] : "buyer@krishisheba.com";
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার কার্ট - কৃষিসেবা | KrishiSheba</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cart-wrapper { display: grid; grid-template-columns: 1.8fr 1fr; gap: 30px; margin-top: 20px; }
        
        .cart-card { 
            background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 15px; 
            display: flex; align-items: center; position: relative; border: 1px solid #eee; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.02); 
        }

        .item-img-box { width: 100px; height: 100px; border-radius: 12px; overflow: hidden; margin-right: 20px; border: 1px solid #f0f0f0; }
        .item-img-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .summary-box { 
            background: #ffffff; /* সাদা ব্যাকগ্রাউন্ড */
            border-radius: 24px; padding: 35px; 
            position: sticky; top: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* ভিজিবল শ্যাডো */
            border: 1px solid #e0e0e0; 
        }

        .summary-box h3 { 
            margin-top: 0; font-size: 22px; margin-bottom: 25px; color: #2c3e50; 
            border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;
        }

        .total-row { 
            border-top: 2px dashed #d4e4e1; 
            padding-top: 20px; margin-top: 20px; 
            font-size: 26px; font-weight: 700; color: #2e7d32; 
        }

        .checkout-btn { 
            width: 100%; background: #000; color: #fff; padding: 18px; 
            border-radius: 40px; border: none; font-weight: 700; cursor: pointer; 
            margin-top: 25px; font-family: 'Hind Siliguri'; font-size: 17px;
            transition: 0.3s;
        }
        
        .checkout-btn:hover { background: #333; transform: translateY(-2px); }

        .qty-box { display: flex; align-items: center; gap: 12px; margin-top: 10px; }
        .qty-btn { text-decoration: none; color: #666; border: 1px solid #ddd; padding: 2px 10px; border-radius: 5px; font-weight: bold; }
        .delete-icon { position: absolute; top: 15px; right: 15px; color: #ccc; text-decoration: none; font-size: 18px; }
    </style>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu">
            <a href="buyer_dashboard.php" class="menu-item"><i class="fa-solid fa-store"></i> তাজা বাজার</a>
            <a href="buyer_cart.php" class="menu-item active"><i class="fa-solid fa-basket-shopping"></i> আমার কার্ট <span class="badge" style="position: static; margin-left: auto;"><?php echo enToBn($total_items); ?></span></a>
            <a href="#" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> অর্ডার ইতিহাস</a>
            <a href="#" class="menu-item"><i class="fa-solid fa-heart"></i> পছন্দের তালিকা</a>
            <a href="buyer_settings.php" class="menu-item"><i class="fa-solid fa-gear"></i> সেটিংস</a>
        </div>
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <a href="index.php" class="menu-item" style="padding: 10px; color: #d32f2f;"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="সবজি, ফল বা বীজ খুঁজুন...">
            </div>
            <div class="topbar-right">
                <div class="profile-dropdown">
                    <div style="text-align: right;">
                        <p style="margin: 0; font-weight: 600; font-size: 0.9rem;"><?php echo htmlspecialchars($buyer_name); ?></p>
                        <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);"><?php echo htmlspecialchars($buyer_email); ?></p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($buyer_name); ?>&background=2e7d32&color=fff" style="width: 35px; border-radius: 50%; margin-left: 10px;">
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <h1 style="font-size: 28px; margin-bottom: 5px;">কেনাকাটার তালিকা</h1>
            <p style="color: #888; margin-bottom: 25px;">হোম > কার্ট</p>

            <div class="cart-wrapper">
                <div class="cart-items">
                    <?php if(count($cart_items) > 0): ?>
                        <?php foreach($cart_items as $item): ?>
                        <div class="cart-card">
                            <div class="item-img-box"><img src="<?php echo htmlspecialchars($item['image_url']); ?>"></div>
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                                <p>৳ <?php echo enToBn(number_format($item['price'], 2)); ?> / কেজি</p>
                                <div class="qty-box">
                                    <a href="buyer_cart.php?action=decrease&id=<?php echo $item['id']; ?>" class="qty-btn">-</a>
                                    <span style="font-weight: 600;"><?php echo enToBn($item['quantity']); ?> টি</span>
                                    <a href="buyer_cart.php?action=increase&id=<?php echo $item['id']; ?>" class="qty-btn">+</a>
                                </div>
                            </div>
                            <div style="font-size: 20px; font-weight: 700;">৳ <?php echo enToBn(number_format($item['price'] * $item['quantity'], 2)); ?></div>
                            <a href="buyer_cart.php?remove_id=<?php echo $item['id']; ?>" class="delete-icon"><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; padding: 50px;">আপনার কার্ট বর্তমানে খালি।</p>
                    <?php endif; ?>
                </div>

                <div class="summary-col">
                    <div class="summary-box">
                        <h3>অর্ডারের সারসংক্ষেপ</h3>
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <span>উপ-মোট</span>
                            <span>৳ <?php echo enToBn(number_format($subtotal, 2)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <span>ডেলিভারি চার্জ</span>
                            <span>৳ <?php echo enToBn(number_format($delivery_fee, 2)); ?></span>
                        </div>
                        <div class="total-row" style="display: flex; justify-content: space-between;">
                            <span>সর্বমোট</span>
                            <span>৳ <?php echo enToBn(number_format($total_amount, 2)); ?></span>
                        </div>
                        <button class="checkout-btn">অর্ডার সম্পন্ন করুন</button>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="buyer_dashboard.php" style="background: #000; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 600;">আরও কেনাকাটা করুন</a>
            </div>
        </div>
    </main>
</body>
</html>