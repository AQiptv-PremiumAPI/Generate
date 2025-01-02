<?php
// Define your bot token
$bot_token = 'YOUR_BOT_TOKEN';

// Check if Telegram data is provided
if (!isset($_GET['hash']) || !isset($_GET['id'])) {
    die('No Telegram data received.');
}

// Extract Telegram data
$auth_data = $_GET;
$check_hash = $auth_data['hash'];
unset($auth_data['hash']);

// Sort data by key
ksort($auth_data);
$data_check_string = '';
foreach ($auth_data as $key => $value) {
    $data_check_string .= $key . '=' . $value . "\n";
}
$data_check_string = trim($data_check_string);

// Create the hash using the bot token
$secret_key = hash('sha256', $bot_token, true);
$hash = hash_hmac('sha256', $data_check_string, $secret_key);

// Verify the hash
if (!hash_equals($hash, $check_hash)) {
    die('Data is invalid. Possible tampering detected.');
}

// Optional: Check if the authentication data is recent (e.g., within 24 hours)
if ((time() - $auth_data['auth_date']) > 86400) {
    die('Authentication data is too old.');
}

// Process user data (e.g., save to the database or start a session)
session_start();
$_SESSION['telegram_user'] = [
    'id' => $auth_data['id'],
    'username' => $auth_data['username'],
    'first_name' => $auth_data['first_name'],
    'last_name' => $auth_data['last_name'] ?? '',
    'photo_url' => $auth_data['photo_url'] ?? '',
];

// Redirect to your dashboard or homepage
header('Location: /dashboard.php');
exit();
?>
