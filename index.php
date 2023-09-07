<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <style>
        /* 投稿フォームのスタイル */
        .message-form {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f0f0f0;
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        /* メッセージのスタイル */
        .message {
            background-color: #f9f9f9;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
        }
        .message:nth-child(odd) {
            background-color: #e0e0e0;
        }
        
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
    <h2>掲示板</h2>
    <!-- メッセージを表示するコンテナ -->
    <div id="message-container">
        <?php
        // データベースへの接続
        $pdo = new PDO('mysql:host=localhost;dbname=BulletinBoard;charset=utf8', 'root', 'mariadb');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // メッセージを取得して表示
        $query = "SELECT * FROM Messages ORDER BY timestamp DESC";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $messages = $statement->fetchAll(PDO::FETCH_ASSOC);
        // データベースの接続を閉じる
        $pdo = null;
        foreach ($messages as $message) {
            $username = htmlspecialchars($message['username']);
            $messageText = htmlspecialchars($message['message_text']);
            echo "<div class='message'><strong>$username:</strong><p>$messageText</p></div>";
        }
        ?>
    </div>
    <!-- 新しいメッセージを投稿するフォーム -->
    <div class="message-form">
        <form id="message-form" method="POST">
            <label>ユーザー名: </label>
            <input type="text" name="username" required>
            <label>メッセージ: </label>
            <textarea name="message_text" rows="4" cols="50" required></textarea>
            <input type="submit" name="submit" value="投稿">
        </form>
    </div>
    <?php require 'footer.php'; ?>
    <script>
        // フォームの送信イベントを処理
        const messageForm = document.getElementById('message-form');
        messageForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const usernameInput = messageForm.querySelector('input[name="username"]');
            const messageTextInput = messageForm.querySelector('textarea[name="message_text"]');
            const username = usernameInput.value;
            const messageText = messageTextInput.value;
            // メッセージをデータベースに送信する処理を追加
            // ここでデータベースに挿入するAPIなどを呼び出す必要があります
            // 新しいメッセージを表示
            const messageContainer = document.getElementById('message-container');
            const newMessage = document.createElement('div');
            newMessage.className = 'message';
            newMessage.innerHTML = `<strong>${username}:</strong><p>${messageText}</p>`;
            messageContainer.insertBefore(newMessage, messageContainer.firstChild);
            // フォームをクリア
            usernameInput.value = '';
            messageTextInput.value = '';
        });
    </script>
</body>
</html>