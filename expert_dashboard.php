<?php
// DB Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "krishisheba";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Article Upload
if (isset($_POST['upload_article'])) {
    $title = mysqli_real_escape_with_string($conn, $_POST['title']);
    $content = mysqli_real_escape_with_string($conn, $_POST['content']);
    mysqli_query($conn, "INSERT INTO articles (title, content) VALUES ('$title', '$content')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert Dashboard | KrishiSheba</title>
    <style>
        :root { --primary: #2c3e50; --secondary: #27ae60; --light: #f4f7f6; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--light); margin: 0; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 250px; background: var(--primary); color: white; height: 100vh; padding: 20px; position: fixed; }
        .sidebar h2 { color: var(--secondary); font-size: 20px; }
        .sidebar nav a { display: block; color: white; text-decoration: none; padding: 10px 0; border-bottom: 1px solid #34495e; }

        /* Main Content */
        .main { margin-left: 280px; padding: 40px; width: 100%; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        
        h3 { border-left: 5px solid var(--secondary); padding-left: 10px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { background: var(--secondary); color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; }
        
        .complain-item { border-bottom: 1px solid #eee; padding: 10px 0; }
        .status { font-size: 12px; font-weight: bold; color: orange; }
        
        .chat-box { height: 200px; background: #eee; overflow-y: scroll; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>KrishiSheba Expert</h2>
    <nav>
        <a href="#articles">Write Article</a>
        <a href="#complains">User Complaints</a>
        <a href="#messages">Messages</a>
    </nav>
</div>

<div class="main">
    <h1>Welcome, Expert</h1>

    <div id="articles" class="card">
        <h3>Publish New Article</h3>
        <form method="POST">
            <input type="text" name="title" placeholder="Article Title" required>
            <textarea name="content" rows="5" placeholder="Write your agricultural insights here..." required></textarea>
            <button type="submit" name="upload_article">Publish Article</button>
        </form>
    </div>

    <div id="complains" class="card">
        <h3>User Complaints & Reviews</h3>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM complains ORDER BY id DESC");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='complain-item'>
                    <strong>{$row['user_name']}:</strong> {$row['message']} 
                    <br><span class='status'>Status: {$row['status']}</span>
                    <br><button style='background:#2980b9; font-size:11px; margin-top:5px;'>Suggest Review</button>
                  </div>";
        }
        ?>
    </div>

    <div id="messages" class="card">
        <h3>Messaging Center</h3>
        <div class="chat-box">
            <p><strong>System:</strong> Welcome to the expert chat. Select a user to start texting.</p>
            </div>
        <form>
            <input type="text" placeholder="Type a message to user...">
            <button type="button" onclick="alert('Message Sent!')">Send Message</button>
        </form>
    </div>
</div>

</body>
</html>