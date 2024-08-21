<?php
// Kết nối đến cơ sở dữ liệu
$host = "localhost:3306";
$username = "root";
$password = "";
$database = "book_management";
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Kiểm tra xem dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['title']) && !empty($_POST['author_name']) && !empty($_POST['category_name'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
        $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
        $publish_year = intval($_POST['publish_year']);

        // Kiểm tra và thêm tác giả nếu chưa tồn tại
        $author_result = mysqli_query($conn, "SELECT id FROM authors WHERE author_name = '$author_name'");
        if (mysqli_num_rows($author_result) > 0) {
            $author_id = mysqli_fetch_assoc($author_result)['id'];
        } else {
            mysqli_query($conn, "INSERT INTO authors (author_name) VALUES ('$author_name')");
            $author_id = mysqli_insert_id($conn);
        }

        // Kiểm tra và thêm thể loại nếu chưa tồn tại
        $category_result = mysqli_query($conn, "SELECT id FROM categories WHERE category_name = '$category_name'");
        if (mysqli_num_rows($category_result) > 0) {
            $category_id = mysqli_fetch_assoc($category_result)['id'];
        } else {
            mysqli_query($conn, "INSERT INTO categories (category_name) VALUES ('$category_name')");
            $category_id = mysqli_insert_id($conn);
        }

        // Chuẩn bị câu lệnh SQL để thêm sách mới 
        $sql = "INSERT INTO books (title, category_id, author_id, publisher, publish_year) 
                VALUES ('$title', $category_id, $author_id, '$publisher', $publish_year)";

        if (mysqli_query($conn, $sql)) {
            echo '<h3 style="color:blue">Book added successfully.</h3>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo '<h3 style="color:red">All required fields must be filled in.</h3>';
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            font-size: 16px;
            color: #333;
        }

        th {
            text-align: right;
            font-weight: normal;
            color: #555;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin: 20px auto;
            width: 200px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h2>Add new book</h2>
    <form action="" method="post">
        <table>
            <tr>
                <td>Title book:</td>
                <td><input type="text" name="title" required></td>
            </tr>
            <tr>
                <td>Author name:</td>
                <td><input type="text" name="author_name" required></td>
            </tr>
            <tr>
                <td>Category name:</td>
                <td><input type="text" name="category_name" required></td>
            </tr>
            <tr>
                <td>Publisher:</td>
                <td><input type="text" name="publisher"></td>
            </tr>
            <tr>
                <td>Publish year:</td>
                <td><input type="number" name="publish_year" min="1800" max="<?php echo date('Y'); ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><input type="submit" value="Add"></td>
            </tr>
        </table>
    </form>

    <br>
    <a href="index.php">View book list</a>
</body>

</html>

</html>