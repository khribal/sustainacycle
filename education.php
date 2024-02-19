<?php
// Connection to the database
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to convert **text** to <strong>text</strong> after applying htmlspecialchars
function convertToBold($text) {
    // Regular expression to match **text** and replace with <strong>text</strong>
    $pattern = '/\*\*(.*?)\*\*/';
    $replacement = '<strong>$1</strong>';
    $text = preg_replace($pattern, $replacement, $text);
    return $text;
}

// Function to convert __text__ to <u>text</u>
function convertToUnderline($text) {
    // Regular expression to match __text__ and replace with <u>text</u>
    $pattern = '/__(.*?)__/';
    $replacement = '<u>$1</u>';
    $text = preg_replace($pattern, $replacement, $text);
    return $text;
}

// Fetch articles from the database
$sql = "SELECT * FROM articles ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Articles on Sustainability</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('includes/nav.php') ?>
    <div class="container mt-5">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="article mb-5">
                    <?php if (!empty($row['img'])): ?>
                        <img src="<?php echo htmlspecialchars($row['img']); ?>" alt="Article Image" class="img-fluid mb-3">
                    <?php endif; ?>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($row['author']); ?> | <?php echo htmlspecialchars($row['date']); ?></p>
                    <p>Tags: <?php echo htmlspecialchars($row['tags']); ?></p>
                    <h5><?php echo htmlspecialchars($row['description']); ?></h5>
                    <!-- First apply htmlspecialchars, then convert to bold, and finally convert to underline -->
                    <p><?php echo nl2br(convertToUnderline(convertToBold(htmlspecialchars($row['article_text'])))); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>
    <!-- Footer --> 
    <footer class="container mx-auto p-2">
    <p>&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
    </footer>
    <!-- Bootstrap and jQuery libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Close connection
mysqli_close($conn);
?>
