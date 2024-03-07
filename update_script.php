<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["ID"];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $cleanContent = $_POST["cleanContent"];

    // 数据库连接配置
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mao_speeches_new";

    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn -> set_charset("utf8mb4");

    // 检查连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    // 更新数据库
    $stmt = $conn->prepare("UPDATE speech2 SET Title=?, Date = ?, Content=? WHERE ID=?");
    $stmt->bind_param("sssi",$title ,$date, $cleanContent, $id);

    if ($stmt->execute()) {
        echo "记录更新成功。";
    } else {
        echo "更新错误: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "非法请求。";
}
?>