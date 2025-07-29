<?php
$name = $email = $subject = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $to = "your-email@example.com"; // Replace with your actual email
        $headers = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();
        $body = "Name: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $success = "Message sent successfully!";
            $name = $email = $subject = $message = "";
        } else {
            $error = "Failed to send message. Try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us</title>
    <!-- Contact page favicon -->
    <link rel="icon" href="icons/favicon-contact.ico" type="image/x-icon" />

    <style>
        :root {
            --grey: #333;
            --mustard: #ffcc00;
            --orange: #e6b800;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color: #fff;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }

        nav {
            background-color: var(--grey);
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 1em 2em;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        nav .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--mustard);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
            font-weight: bold;
        }

        nav ul li a::after {
            content: '';
            height: 2px;
            background: var(--orange);
            width: 0;
            position: absolute;
            left: 0;
            bottom: -4px;
            transition: 0.3s;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .form-container {
            max-width: 500px;
            margin: 60px auto;
            background-color: rgba(20, 20, 20, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            color: var(--mustard);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--mustard);
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: var(--mustard);
            color: #000;
            padding: 12px 20px;
            border: none;
            font-size: 16px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: var(--orange);
        }

        .success {
            color: #80ff80;
            text-align: center;
        }

        .error {
            color: #ff6666;
            text-align: center;
        }

        footer {
            background-color: rgba(10, 10, 10, 0.95);
            text-align: center;
            color: #aaa;
            padding: 20px 10px;
            font-size: 14px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">CourierSys</div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="signin.php">Sign In</a></li>
    </ul>
</nav>

<div class="form-container">
    <h2>Contact Us</h2>

    <?php if ($success): ?>
        <p class="success" id="msg"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="error" id="msg"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="contact.php" id="contactForm" novalidate>
        <label>Name *</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>

        <label>Email *</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>

        <label>Subject</label>
        <input type="text" name="subject" id="subject" value="<?= htmlspecialchars($subject) ?>">

        <label>Message *</label>
        <textarea name="message" id="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>

        <button type="submit">Send</button>
    </form>
</div>

<footer>
    &copy; <?= date("Y") ?> Contact. All rights reserved.
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contactForm');
        const msg = document.getElementById('msg');

        if (msg) {
            setTimeout(() => {
                msg.style.transition = 'opacity 0.5s ease';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }, 5000);
        }

        form.addEventListener('submit', function (e) {
            const name = form.name.value.trim();
            const email = form.email.value.trim();
            const message = form.message.value.trim();

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!name || !email || !message) {
                alert('Please fill in all required fields.');
                e.preventDefault();
                return false;
            }

            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                e.preventDefault();
                return false;
            }
        });
    });
</script>

</body>
</html>
