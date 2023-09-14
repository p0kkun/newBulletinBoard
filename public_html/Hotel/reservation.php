<?php
require 'header.php';
?>
<title>会員登録フォーム</title>
</head>
<body>
    <h2>会員登録フォーム</h2>
    <form method="POST" action="">
        <label>名前: </label>
        <input type="text" name="first_name" required>
        <br>
        <label>姓: </label>
        <input type="text" name="last_name" required>
        <br>
        <label>Email: </label>
        <input type="email" name="email" required>
        <br>
        <label>電話番号: </label>
        <input type="text" name="phone_number">
        <br>
        <label>ユーザー名: </label>
        <input type="text" name="username" required>
        <br>
        <label>パスワード: </label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="登録">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        // パスワードの要件をチェック
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
            echo "パスワードの要件を満たしていません。";
        } else {
            // データベースへの接続
            $pdo = new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 'hoteluser', 'password');
            // エラーモードを設定
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                // 会員情報のクエリの実行
                $query1 = "INSERT INTO Customers (first_name, last_name, email, phone_number, username, password)
                           VALUES (:first_name, :last_name, :email, :phone_number, :username, :password)";
                $statement1 = $pdo->prepare($query1);
                $statement1->bindParam(':first_name', $first_name);
                $statement1->bindParam(':last_name', $last_name);
                $statement1->bindParam(':email', $email);
                $statement1->bindParam(':phone_number', $phone_number);
                $statement1->bindParam(':username', $username);
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $statement1->bindParam(':password', $hashedPassword);
                $statement1->execute();
                echo "会員登録が成功しました！";
                echo "3秒後に予約画面に飛びます";
                header("refresh:3;url=reservation_form.php");
            } catch (PDOException $e) {
                echo "エラー: " . $e->getMessage();
            }
            // データベースの接続を閉じる
            $pdo = null;
        }
    }
    ?>
<?php require 'footer.php'; ?>