<?php require 'header.php'; ?>
<title>予約確認</title>
</head>
<body>
    <h2>予約が完了しました</h2>
    <p>会員情報:</p>
    <p>名前: <?php echo $_GET['first_name'] . ' ' . $_GET['last_name']; ?></p>
    <p>Email: <?php echo $_GET['email']; ?></p>
    <p>電話番号: <?php echo $_GET['phone_number']; ?></p>
    <p>予約した部屋の種類: <?php echo $_GET['room_type']; ?></p>
    <!-- 他の予約情報を表示 -->
<?php require 'footer.php'; ?>