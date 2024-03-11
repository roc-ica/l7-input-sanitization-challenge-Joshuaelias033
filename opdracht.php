<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Sanitization Challenge</title>
</head>

<body>

    <h1>Welkom op onze website</h1>

    <?php
    // Ontvang het ingevoerde bericht van de gebruiker
    $userMessage = $_GET['message'] ?? '';

    // Toon het ingevoerde bericht zonder sanitatie (onveilig)
    echo "<p>Ongesaneerd bericht: $userMessage</p>";

    // Toon het ingevoerde bericht met HTML-sanitatie (deel van XSS-preventie)
    echo "<p>Veilig bericht (HTML-gecodeerd): " . htmlspecialchars($userMessage, ENT_QUOTES, 'UTF-8') . "</p>";

    // Database interactie met prepared statements om SQL-injectie te voorkomen
    
    // Vul hier je database credentials in
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "input_sanitization_challenge";

    try {
        // Maak een verbinding met de database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de PDO error mode in op exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Voeg het bericht toe aan de database met een prepared statement
        $stmt = $conn->prepare("INSERT INTO messages (message) VALUES (:message)");
        $stmt->bindParam(':message', $userMessage);
        $stmt->execute();

        echo "<p>Bericht succesvol toegevoegd aan de database.</p>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Sluit de databaseverbinding
    $conn = null;
    ?>

    <hr>

    <!-- Formulier om bericht in te voeren -->
    <form action="opdracht.php" method="get">
        <label for="message">Voer hier uw bericht in:</label>
        <input type="text" id="message" name="message">
        <input type="submit" value="Verzenden">
    </form>

</body>

</html>