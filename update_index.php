<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>毛澤東文選數據修改</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .small-column {
            width: 10%;  /* 为 ID、Title 和 Date 列设置较小的宽度 */
        }
        .large-column {
            width: 70%;  /* 为 Content 列设置较大的宽度 */
        }
        textarea {
            width: 100%;  /* 让文本区域填满单元格 */
            height: 100px;  /* 设置文本区域的高度 */
        }
    </style>
</head>
<body>
    <h1>毛澤東文選數據修改</h1>
    <table>
        <tr>
            <th class="small-column">ID</th>
            <th class="small-column">Title</th>
            <th class="small-column">Date</th>
            <th class="large-column">Content</th>
            <th class="small-column">Action</th>
        </tr>
        <?php
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

        // 查询数据库
        $sql = "SELECT ID, Title, Date, Content FROM speech2";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<form onsubmit='return updateData(this);' method='post'>";
                echo "<td class='small-column'><input type='hidden' name='ID' value='" . $row["ID"] . "'>" . $row["ID"] . "</td>";
                echo "<td class='small-column'><input type='text' name='title' value='" . $row["Title"] . "'></td>";
                echo "<td class='small-column'><input type='text' name='date' value='" . $row["Date"] . "'></td>";
                echo "<td class='large-column'><textarea name='cleanContent'>" . $row["Content"] . "</textarea></td>";
                echo "<td><input type='submit' value='更新'></td>";
                echo "</form>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>没有数据</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <script>
function updateData(form) {
    var formData = new FormData(form);

    fetch('update_script.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // 显示从服务器返回的消息
    })
    .catch(error => {
        alert('更新失败: ' + error);
    });

    return false; // 防止表单的默认提交行为
}
</script>
</body>
</html>