<?php
include 'config.php'; // Database connection

if (isset($_GET['q'])) {
    $query = trim($_GET['q']);
    $sql = "SELECT * FROM products WHERE name LIKE ?"; // Search by name
    $stmt = $conn->prepare($sql);
    $searchTerm = "%{$query}%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product">
                    <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                    <h3>' . htmlspecialchars($row['name']) . '</h3>
                    <p>' . htmlspecialchars($row['description']) . '</p>
                    <p>₹' . htmlspecialchars($row['price']) . '</p>
                    <button class="add-to-cart" data-id="' . $row['id'] . '">Add to Cart</button>
                  </div>';
        }
    } else {
        echo '<div class="no-results">❌ No results found</div>';
    }

    $stmt->close();
    $conn->close();
}
?>
