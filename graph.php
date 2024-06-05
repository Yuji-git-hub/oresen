<?php
$filename = 'graph.txt';
$text = '';
$number00 = '';
$data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // post値
    if (isset($_POST['number']) === TRUE) {
        $number = $_POST['number'];
    }
    
    // エラーメッセージ
    if ($number === '') {
        $errors[] = '数字を入力してください';
    } else if(is_numeric($number) === FALSE) {
        $errors[] = '数値を入力してください'; 
    } else if($number < -100 || 100 < $number) {
        $errors[] = '-100以上100以下の数字を入力してください';
    }

    // ファイル書き込み
    if(count($errors) === 0) {
        if (($fp = fopen($filename, 'a')) !== FALSE) {
            if (fwrite($fp, $number . ':' . ' ' . $date . "\r\n") === FALSE) {
                print 'ファイル書き込み失敗: ' . $filename; 
            }
            fclose($fp);
        }
    }   
}

if (($fp = fopen($filename, 'r')) !== FALSE) {
    while (($tmp = fgets($fp)) !== FALSE) {
        $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
    }
    fclose($fp);
    $data = array_reverse($data);
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>グラフ</h1>
    <form method="post">
        <p>数字: <input type="text" name="number" value="">
        </p>
        <input type="submit" value="送信">
    </form>

</body>
</html>