<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>显示数据库数据</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- 引入CSS文件 -->
</head>
<body>

<h1>毛澤東選集全文</h1>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mao_speeches_new";  // 替换成你的数据库名

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn -> set_charset("utf8mb4");
$sql = "SELECT ID, Title, Date,Content  FROM speech2";  // 替换为你的表名和列名
$result = $conn->query($sql);
?>

<table id="data-table">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Content</th>
    </tr>
    <!-- PHP代码来插入数据库数据 -->
    <?php
if ($result->num_rows > 0) {
    // 输出数据的每行
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["Title"] . "</td>";
        echo "<td>" . $row["Date"] . "</td>";
        echo "<td>" . $row["Content"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>没有找到数据</td></tr>";
}
$conn->close();
?>  

</table>


</body>
</html>