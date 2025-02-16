<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book - Surya City Library</title>
    <link rel="icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="login_library.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="admin_dashboard.php">
                <img class="logo" src="favicon.png" alt="Library Logo">
            </a>
        </div>
        <nav>
            <ul class="nav-links">
                <li>Email: <?php echo $_SESSION['email']; ?></li>
                <li class="dropdown">
                    <button class="dropbtn">My Profile</button>
                    <div class="dropdown-content">
                        <a href="admin_view_profile.php">View Profile</a>
                        <a href="admin_edit_profile.php">Edit Profile</a>
                    </div>
                </li>
                <li>
                    <a href="logout.php" class="btn-primary">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="heading">
        <h1><b>Welcome <?php echo explode(' ', $_SESSION['name'])[0]; ?>'s Dashboard</b></h1>
    </div>

    <nav style="background-color: #e3f2fd">
        <ul class="nav-links">
            <li>
                <a href="admin_dashboard.php" class="btn-primary">Dashboard</a>
            </li>
            <li class="dropdown">
                <button class="dropbtn">Books</button>
                <div class="dropdown-content">
                    <a href="admin_add_new_book.php">Add New Book</a>
                    <a href="admin_manage_book.php">Manage Books</a>
                </div>
            </li>
            <li class="dropdown">
                <button class="dropbtn">Category</button>
                <div class="dropdown-content">
                    <a href="admin_add_new_cate.php">Add New Category</a>
                    <a href="admin_manage_cate.php">Manage Category</a>
                </div>
            </li>
            <li class="dropdown">
                <button class="dropbtn">Authors</button>
                <div class="dropdown-content">
                    <a href="admin_add_new_auth.php">Add New Author</a>
                    <a href="admin_manage_auth.php">Manage Author</a>
                </div>
            </li>
            <li>
                <a href="admin_issue_book.php" class="btn-primary">Issue Book</a>
            </li>
        </ul>
    </nav>

    <form action="" method="post">
        <div class="container">
            <center>
                <h3>Issue Book</h3>
            </center>
            <label for="name">Book Name:</label>
            <select name="book_name" required>
                <option>-Select book-</option>
                <?php
					$connection = mysqli_connect("localhost","root","tiger","lms");
					$query = "select book_name from books";
					$query_run = mysqli_query($connection,$query);
					while($row = mysqli_fetch_assoc($query_run)){
				?>
                <option><?php echo $row['book_name'];?></option>
                <?php
					}
				?>
            </select>
            <label for="text">Author Name:</label>
            <select name="author_name">
                <option>-Select author-</option>
                <?php  
					$connection = mysqli_connect("localhost","root","tiger");
					$db = mysqli_select_db($connection,"lms");
					$query = "select author_name from authors";
					$query_run = mysqli_query($connection,$query);
					while($row = mysqli_fetch_assoc($query_run)){
				?>
                <option><?php echo $row['author_name'];?></option>
                <?php
					}
				?>
            </select>
            <label for="text">Book Number:</label>
            <select name="book_no">
                <option>-Select book no-</option>
                <?php  
					$connection = mysqli_connect("localhost","root","tiger","lms");
					$query = "select book_no from books";
					$query_run = mysqli_query($connection,$query);
					while($row = mysqli_fetch_assoc($query_run)){
				?>
                <option><?php echo $row['book_no'];?></option>
                <?php
					}
				?>
            </select>
            <label for="text">Student ID:</label>
            <select name="student_id">
                <option>-Select student id-</option>
                <?php
					$connection = mysqli_connect("localhost","root","tiger","lms");
					$query = "select id from users";
					$query_run = mysqli_query($connection,$query);
					while($row = mysqli_fetch_assoc($query_run)){
				?>
                <option><?php echo $row['id'];?></option>
                <?php
					}
				?>
            </select>
            <label for="issue_date">Issue Date:</label>
            <input type="date" name="issue_date" class="form-control" required>
            <button type="submit" name="issue_book" class="btn-primary">Issue Book</button>
        </div>
    </form>
    <footer>
        <p>Copyright &copy;2025 : <b>Surya City Library</b></p>
        <nav>
            <ul>
                <li><a href="https://www.facebook.com/suryacitylibrary" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com/suryacitylibrary" target="_blank">Instagram</a></li>
                <li><a href="https://wa.me/917788873416" target="_blank">Whatsapp</a></li>
                <li><a href="mailto:suryacitylibrary@gmail.com" target="_blank">Email</a></li>
                <li><a href="#top" class="btn-primary">Top</a></li>
            </ul>
        </nav>
    </footer>
</body>

</html>

<?php
if (isset($_POST['issue_book'])) {
    if (empty($_POST['book_name']) || $_POST['book_name'] == "-Select book-" || empty($_POST['author_name']) || $_POST['author_name'] == "-Select author-" || empty($_POST['book_no']) || $_POST['book_no'] == "-Select book no-" || empty($_POST['student_id']) || $_POST['student_id'] == "-Select student id-" || empty($_POST['issue_date'])) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }    
    $connection = mysqli_connect("localhost", "root", "tiger", "lms");
    if (!$connection) {
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    $book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
    $author_name = mysqli_real_escape_string($connection, $_POST['author_name']);
    $book_no = (int) $_POST['book_no'];
    $student_id = (int) $_POST['student_id'];
    $date = mysqli_real_escape_string($connection, $_POST['issue_date']);    

    $query = "INSERT INTO issued_books (book_name, author_name, book_no, student_id, issue_date, status)
              VALUES ('$book_name', '$author_name', $book_no, $student_id, '$date', 1)";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        echo "<script>alert('Book issued successfully!'); window.location.href='admin_view_issued_book.php';</script>";
    } else {
        echo "<script>alert('Error issueing book: " . mysqli_error($connection) . "');</script>";
    }

    mysqli_close($connection);
}
?>