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

// Lấy danh sách sách 
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT books.*, categories.category_name, authors.author_name 
            FROM books 
            INNER JOIN categories ON books.category_id = categories.id 
            INNER JOIN authors ON books.author_id = authors.id 
            WHERE books.title LIKE '%$search%' 
            OR categories.category_name LIKE '%$search%' 
            OR authors.author_name LIKE '%$search%'";
} else {
    $sql = "SELECT books.*, categories.category_name, authors.author_name 
            FROM books 
            INNER JOIN categories ON books.category_id = categories.id 
            INNER JOIN authors ON books.author_id = authors.id";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
            margin-bottom: 5px;
        }

        form input[type="text"] {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        form input[type="submit"] {
            padding: 8px 16px;
            border: 1px solid #333;
            background-color: #333;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #555;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        td a {
            text-decoration: none;
            color: #007bff;
            margin: 0 5px;
            transition: color 0.3s ease;
        }

        td a:hover {
            color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            margin-left: 25%;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            form input[type="text"] {
                width: 200px;
            }
        }

        .add_book {
            display: block;
            text-align: center;
            margin: 5px auto;
            width: 200px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <h2>List books</h2>
    <form action="" method="post">
        <input type="text" name="search" placeholder="Search for book title" value="<?php echo $_POST['search'] ?? '' ?>">
        <input type="submit" value="search">
    </form>
    <br>
    <?php
    // Kiểm tra và hiển thị kết quả 
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Publisher</th>
                    <th>Publish Year</th>
                    <th>Edit Delete</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["title"] . "</td>
                    <td>" . $row["author_name"] . "</td>
                    <td>" . $row["category_name"] . "</td>
                    <td>" . $row["publisher"] . "</td>
                    <td>" . $row["publish_year"] . "</td>
                    <td>
                        <a href='delete_books.php?id=" . $row["id"] . "' onclick=\"return confirm('Are you sure you want to delete this book?');\">delete</a>
                        <a href='edit_books.php?id=" . $row["id"] . "' >edit</a>
                     </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No results.";
    }

    // Đóng kết nối
    mysqli_close($conn);
    ?>
    <br>
    <a class="add_book" href="add_books.php">Add new book</a>
</body>

</html>