<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "graph";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "INSERT INTO graph (num) VALUES ('".$_POST["number"]."')";

    if ($conn->query($sql) === TRUE) {
        echo "データベースに格納できました";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    } else {
        $conn = new mysqli($servername, $username, $password, $dbname);

        $sql = "SELECT * FROM `graph`";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data_array = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data_array[] = $row;
            }
            mysqli_free_result($result);
        } else {
            echo 'クエリの実行に失敗しました。' . PHP_EOL;
        }

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
</head>
<body>
    <h1>グラフ</h1>
    <form method="post">
        <p>数字: <input type="text" name="number" value="">
        </p>
        <input type="submit" value="送信">
    </form>
    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($data_array, 'date')); ?>,
                datasets: [{
                    label: '折れ線グラフ',
                    data: <?php echo json_encode(array_column($data_array, 'num')); ?>,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1,
                    backgroundColor: 'rgba(0,0,0,0)',
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true, 
                            max: 100,
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>