<?php
require 'header.php';
?>
<title>予約フォーム</title>
</head>

<body>
    <h2>部屋を選んで予約してください</h2>
    <form method="POST" action="make_reservation.php">
        <label for="room_type">部屋の種類:</label>
        <select name="room_type" id="room_type">
            <?php
            // 部屋の種類一覧と価格を取得
            $pdo = new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 'hoteluser', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT DISTINCT room_type, price FROM Rooms";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $roomData = $statement->fetchAll(PDO::FETCH_ASSOC);
            // 選択肢を生成
            foreach ($roomData as $room) {
                $roomType = $room['room_type'];
                $price = $room['price'];
                echo "<option value=\"$roomType\">$roomType - 価格: $price 円</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" name="submit" value="予約する">
    </form>
    <?php require 'footer.php'; ?>