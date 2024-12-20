<?php
require_once __DIR__ . '/../Config/mongodb.php';

$mongodb = \Config\MongoDB_Connection::getInstance();

$username = "yonetici";
$password = password_hash("123", PASSWORD_DEFAULT);

// Önce eski admin kullanıcısını sil
$mongodb->delete('users', ['username' => $username]);

// Yeni admin kullanıcısını ekle
$user = [
    'username' => $username,
    'password' => $password,
    'created_at' => date('Y-m-d H:i:s')
];

if ($mongodb->insert('users', $user)) {
    echo "Admin kullanıcısı başarıyla oluşturuldu.\n";
    echo "Kullanıcı adı: " . $username . "\n";
    echo "Şifre: 123\n";
} else {
    echo "Hata: Kullanıcı oluşturulamadı.\n";
}
?>
