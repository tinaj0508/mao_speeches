<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>毛澤東文選數據庫搜尋</title>
</head>
<body>
    <h1>毛澤東文選數據庫搜尋</h1>
    <form method="post">
        <input type="text" name="search" placeholder="输入搜索词...">
        <input type="submit" value="搜索">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["search"])) {
        // 数据库连接配置
        $servername = "localhost";
        $username = "root";   // 替换为你的数据库用户名
        $password = "";   // 替换为你的数据库密码
        $dbname = "mao_speeches_new";     // 替换为你的数据库名
        

        // 创建数据库连接
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn -> set_charset("utf8mb4");
        // 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }

        // SQL 查询语句
        $search = $_POST["search"];
        echo "已收到關鍵詞: " . $search . "<br><br><br>";
        echo "\t";

        $sql = "SELECT * FROM speech2 WHERE Content LIKE '%$search%' OR Title LIKE '%$search%'";

        // 执行查询
        $result = $conn->query($sql);

        // 输出结果
        if ($result->num_rows > 0) {
            echo "以下是內文與標題包含關鍵詞的文章標題：<br>";
            // 输出每一行数据
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["ID"]. " 　　　 Title: " . $row["Title"]."<br>";
            }
        } else {
            echo "没有找到匹配的结果<br><br>";
            // 作为测试，输出数据库中的第一行数据
        $testSql = "SELECT * FROM speech2 LIMIT 1 OFFSET 1";
        $testResult = $conn->query($testSql);
        if ($testResult && $testResult->num_rows > 0) {
            $testRow = $testResult->fetch_assoc();
            echo "不是資料庫問題，是你搜尋的問題，測試輸出給你看XD:<br><br>ID: " . $testRow["ID"] . " - Title: " . $testRow["Title"] . "<br>";
        } else {
            echo "测试查询也未找到数据或失败<br>";
        }
        }

        // 关闭连接
        $conn->close();
    }
    ?>
</body>
</html>