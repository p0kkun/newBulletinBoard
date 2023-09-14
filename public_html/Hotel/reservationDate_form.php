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