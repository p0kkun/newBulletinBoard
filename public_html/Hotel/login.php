<?php require 'header.php'; ?>
<title>ログインフォーム</title>
</head>
<body>
    <h2>ログインフォーム</h2>
    <form method="POST" action="">
        <label>ユーザー名: </label>
        <input type="text" name="username" required>
        <br>
        <label>パスワード: </label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="login" value="ログイン">
    </form>
    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // データベースへの接続
        $pdo = new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 'hoteluser', 'password');
        // エラーモードを設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            // ユーザー情報の照合
            $query = "SELECT username, password FROM UserTable WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':username', $username);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                // パスワードが正しい場合、ログインを許可
                session_start(); // セッションを開始
                $_SESSION['username'] = $username;
                echo "ログイン成功！";
                echo "3秒後に予約画面に飛びます";
                header("refresh:3;url=reservation_form.php");
            } else {
                // ログイン失敗
                echo "ユーザー名またはパスワードが正しくありません。";
            }
        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
        // データベースの接続を閉じる
        $pdo = null;
    }
    ?>
    
<?php require 'footer.php'; ?>