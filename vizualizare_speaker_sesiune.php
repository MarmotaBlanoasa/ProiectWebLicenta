<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Înregistrări Speaker Sesiune</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h1>Înregistrările din Speaker Sesiune</h1>
    <p><b>Toate înregistrările din Speaker Sesiune</b></p>
    <?php
    include("conectare.php");

    // Interogarea SQL pentru tabela speaker_sesiune
    $sql = "SELECT ss.ID_Speaker_Sesiune, sp.Nume AS NumeSpeaker, sp.Prenume AS PrenumeSpeaker, se.Nume_Sesiune 
            FROM speaker_sesiune ss
            JOIN speaker sp ON ss.ID_Speaker = sp.ID_Speaker
            JOIN sesiune se ON ss.ID_Sesiune = se.ID_Sesiune 
            ORDER BY ss.ID_Speaker_Sesiune";
    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>ID Speaker Sesiune</th><th>Speaker</th><th>Sesiune</th><th>Modificare</th><th>Ștergere</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID_Speaker_Sesiune'] . "</td>";
                echo "<td>" . $row['NumeSpeaker'] . " " . $row['PrenumeSpeaker'] . "</td>";
                echo "<td>" . $row['Nume_Sesiune'] . "</td>";
                echo "<td><a href='modificare_speaker_sesiune.php?ID_Speaker_Sesiune=" . $row['ID_Speaker_Sesiune'] . "'>Modificare</a></td>";
                echo "<td><a href='stergere_speaker_sesiune.php?ID_Speaker_Sesiune=" . $row['ID_Speaker_Sesiune'] . "'>Ștergere</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nu sunt înregistrări în tabelă!";
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
    ?>
    <a href="inserare_speaker_sesiune.php">Adăugarea unei noi înregistrări</a>
</body>
</html>
