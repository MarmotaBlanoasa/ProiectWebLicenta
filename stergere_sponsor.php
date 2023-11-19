<?php
include("conectare.php");

if (isset($_GET['ID_Sponsor']) && is_numeric($_GET['ID_Sponsor'])) {
    $ID_Sponsor = $_GET['ID_Sponsor'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM sponsor WHERE ID_Sponsor=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Sponsor);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_sponsor.php\">Index</a></p>";
}
?>