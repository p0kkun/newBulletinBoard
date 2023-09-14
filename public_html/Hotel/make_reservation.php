<?php
require 'header.php';
?>
<title>日程予約フォーム</title>
</head>
<body>
    <h2>日程を選んで予約してください</h2>
    <form method="POST" action="make_reservation.php">
        <label for="check_in_date">チェックイン日:</label>
        <input type="date" name="check_in_date" required>
        <br>
        <label for="check_out_date">チェックアウト日:</label>
        <input type="date" name="check_out_date" required>
        <br>
        <input type="submit" name="submit" value="予約する">
    </form>
<?php require 'footer.php'; ?>
<?php
require 'header.php';
// 会員情報を取得
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$email = $_GET['email'];
$phone_number = $_GET['phone_number'];
// データベースへの接続
$pdo = new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 'hoteluser', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 選択された部屋の種類に基づいて部屋IDを取得
$selectedRoomType = $_POST['room_type'];
$query = "SELECT room_id FROM Rooms WHERE room_type = :room_type";
$statement = $pdo->prepare($query);
$statement->bindParam(':room_type', $selectedRoomType);
$statement->execute();
$roomID = $statement->fetchColumn();
// 予約情報を挿入
$query = "INSERT INTO Reservations (customer_id, room_id, check_in_date, check_out_date)
          VALUES (:customer_id, :room_id, :check_in_date, :check_out_date)";
$statement = $pdo->prepare($query);
$customer_id = 1;  // 仮の会員ID（実際のIDを指定する必要あり）
$check_in_date = '2023-08-26';  // チェックイン日を指定
$check_out_date = '2023-08-28';  // チェックアウト日を指定
$statement->bindParam(':customer_id', $customer_id);
$statement->bindParam(':room_id', $roomID);
$statement->bindParam(':check_in_date', $check_in_date);
$statement->bindParam(':check_out_date', $check_out_date);
$statement->execute();
// リダイレクト先のURLを指定してリダイレクト
header("Location: reservation_confirmation.php?first_name=$first_name&last_name=$last_name&email=$email&phone_number=$phone_number&room_type=$selectedRoomType");
exit();
require 'footer.php';
?>
<?php
require 'header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームから送信されたデータを受け取ります
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $selectedRoomType = $_POST['room_type'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    // データベースへの接続
    $pdo = new PDO('mysql:host=localhost;dbname=Hotel;charset=utf8', 'hoteluser', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        // 会員情報を挿入
        $query1 = "INSERT INTO Customers (first_name, last_name, email, phone_number)
                   VALUES (:first_name, :last_name, :email, :phone_number)";
        $statement1 = $pdo->prepare($query1);
        $statement1->bindParam(':first_name', $first_name);
        $statement1->bindParam(':last_name', $last_name);
        $statement1->bindParam(':email', $email);
        $statement1->bindParam(':phone_number', $phone_number);
        $statement1->execute();
        // 選択された部屋の種類に基づいて部屋IDを取得
        $query2 = "SELECT room_id FROM Rooms WHERE room_type = :room_type";
        $statement2 = $pdo->prepare($query2);
        $statement2->bindParam(':room_type', $selectedRoomType);
        $statement2->execute();
        $roomID = $statement2->fetchColumn();
        // 予約情報を挿入
        $query3 = "INSERT INTO Reservations (customer_id, room_id, check_in_date, check_out_date)
                   VALUES (:customer_id, :room_id, :check_in_date, :check_out_date)";
        $statement3 = $pdo->prepare($query3);
        $customer_id = $pdo->lastInsertId();  // 直前に挿入された会員IDを取得
        $statement3->bindParam(':customer_id', $customer_id);
        $statement3->bindParam(':room_id', $roomID);
        $statement3->bindParam(':check_in_date', $check_in_date);
        $statement3->bindParam(':check_out_date', $check_out_date);
        $statement3->execute();
        // リダイレクト先のURLを指定してリダイレクト
        header("Location: reservation_confirmation.php?first_name=$first_name&last_name=$last_name&email=$email&phone_number=$phone_number&room_type=$selectedRoomType&check_in_date=$check_in_date&check_out_date=$check_out_date");
        exit();
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}
require 'footer.php';
?>