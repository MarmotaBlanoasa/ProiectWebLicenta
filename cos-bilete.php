<?php
if (isset($_COOKIE['ticket_ids'])) {
    $ticketIds = explode(',', $_COOKIE['ticket_ids']);

    // Prepare SQL query to fetch ticket details
    $placeholders = implode(',', array_fill(0, count($ticketIds), '?'));
    $sql = "SELECT * FROM bilet WHERE ID_Bilet IN ($placeholders)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind the ticket IDs to the prepared statement
        $stmt->bind_param(str_repeat('i', count($ticketIds)), ...$ticketIds);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $result = $stmt->get_result();
        $totalPrice = 0;
        echo "<h2>Your Ticket Cart</h2>";
        echo "<ul>";

        while ($row = $result->fetch_assoc()) {
            echo "<li>Event ID: " . htmlspecialchars($row['ID_Eveniment']) . ", Ticket Type: " . htmlspecialchars($row['Tip_Bilet']) . ", Price: $" . htmlspecialchars($row['Pret']) . "</li>";
            $totalPrice += $row['Pret'];
        }

        echo "</ul>";
        echo "<p>Total Payment: $" . htmlspecialchars($totalPrice) . "</p>";

        $stmt->close();
    } else {
        echo "Error in query: " . $mysqli->error;
    }
} else {
    echo "<p>No tickets in your cart.</p>";
}