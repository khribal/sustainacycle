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
    <title>Learn About Sustainability</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<?php include('includes/nav.php') ?>
    <div class="container mt-5 mx-auto p-2">
        <h1 class="edu">Learn About Sustainability</h1>
        <h2 class="edu">Check out educational articles from our textile waste and sustainability professionals.</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="article mb-5 mt-5">
                    <?php if (!empty($row['img'])): ?>
                        <img src="<?php echo htmlspecialchars($row['img']); ?>" alt="Article Image" class="img-fluid mb-3">
                    <?php endif; ?>
                    <h3 class="edu"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="edu-auth"><?php echo htmlspecialchars($row['author']); ?> | <?php echo htmlspecialchars($row['date']); ?></p>
                    <p class="edu-tag">Tags: <?php echo htmlspecialchars($row['tags']); ?></p>
                    <h5 class="edu"><?php echo htmlspecialchars($row['description']); ?></h5>
                    <!-- First apply htmlspecialchars, then convert to bold, and finally convert to underline -->
                    <p class="edu"><?php echo nl2br(convertToUnderline(convertToBold(htmlspecialchars($row['article_text'])))); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>
    <!-- Footer --> 
    <?php 
    include('includes/footer.php');
    ?>
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
