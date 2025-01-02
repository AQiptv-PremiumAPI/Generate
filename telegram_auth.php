<?php
session_start();

// Replace these values with your own
define('TELEGRAM_BOT_TOKEN', '7554267736:AAEUGn9GNcKtPpS2iSF0NNM77s1yG1w2b88); // Your bot token
define('TELEGRAM_BOT_USERNAME', 'YOUR_BOT_USERNAME'); // Your bot username

// Function to get the Telegram login URL
function getTelegramLoginUrl() {
    $redirectUrl = 'https://rioiptv.vercel.app'; // Your redirect URL
    $loginUrl = "https://telegram.me/$TELEGRAM_BOT_USERNAME?start=login&redirect_uri=" . urlencode($redirectUrl);
    return $loginUrl;
}

// If the user is redirected back from Telegram
if (isset($_GET['auth_data'])) {
    $auth_data = json_decode($_GET['auth_data'], true);
    // You might want to validate the data signature here
    // For now, just extracting the user's info
    $user_id = $auth_data['id'];
    $username = $auth_data['username'];
    $first_name = $auth_data['first_name'];
    $last_name = $auth_data['last_name'];

    // Store user information in session
    $_SESSION['user'] = [
        'id' => $user_id,
        'username' => $username,
        'first_name' => $first_name,
        'last_name' => $last_name,
    ];

    // Redirect to a welcome page
    header('Location: welcome.php');
    exit();
}

// Output the login link
echo '<a href="' . getTelegramLoginUrl() . '">Login with Telegram</a>';
?>
