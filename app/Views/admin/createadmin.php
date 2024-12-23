<?php
helper('mongodb');

try {
    $mongodb = get_mongodb_instance();
    $bulk = new MongoDB\Driver\BulkWrite;
    
    $username = "yonetici";
    $password = password_hash("1234", PASSWORD_DEFAULT);
    
    // Yeni admin kullanıcısı dokümanı
    $document = [
        'username' => $username,
        'password' => $password,
        'created_at' => new MongoDB\BSON\UTCDateTime(time() * 1000)
    ];
    
    // Önce eski admin kullanıcısını sil
    $bulk->delete(['username' => $username]);
    
    // Yeni admin kullanıcısını ekle
    $bulk->insert($document);
    
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $result = $mongodb->executeBulkWrite(get_mongodb_database() . '.users', $bulk, $writeConcern);
    
    if ($result->getInsertedCount() > 0) {
        $message = "Admin kullanıcısı başarıyla oluşturuldu.<br>";
        $message .= "Kullanıcı adı: " . $username . "<br>";
        $message .= "Şifre: 1234";
    } else {
        $error = "Admin kullanıcısı oluşturulurken bir hata oluştu.";
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    $error = "Bir hata oluştu: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Oluştur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .message {
            color: green;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Kullanıcısı Oluşturma</h2>
        
        <?php if(isset($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
