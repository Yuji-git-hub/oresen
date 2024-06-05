<?php
    // データベース接続する
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "graph";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 接続エラーがあるかどうかを確認する
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //データ登録SQL作成
    $stmt = $conn->prepare("SELECT * FROM graph");
    $status = $stmt->execute();

    // 日時、数値の変数の定義
    $date = '';
    $num = '';

    //loop through the returned data
    while($r = $stmt->fetch(conn::FETCH_ASSOC)) {

        $name = $name . '"'. $r['name'].'",';
        $price = $price . '"'. $r['price'] .'",';
    }

    $name = trim($name,",");
    $price = trim($price,",");

?>



<!DOCTYPE html>
<html>
<head>
    <title>折れ線グラフ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2024/0605','2024/0602'], //横軸
                datasets: [{
                    label: '折れ線グラフ',
                    data: [10,20],
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                }]
            },
            // 縦軸の範囲の指定
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            min: -100, // 縦軸の最小値
                            max: 100, // 縦軸の最大値
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>

