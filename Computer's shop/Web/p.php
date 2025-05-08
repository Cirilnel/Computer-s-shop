<?php
// pagina_di_verifica.php
$mysqli = new mysqli("localhost", "root", "", "aereoporto", 3306);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verifica delle credenziali (ignorando la sicurezza per scopi illustrativi)
    if ($username === "root" && $password === "root") {
        // Credenziali corrette, reindirizza a page1.html
        header("Location: page1.html");
        exit();
    } else {
        // Credenziali non valide, reindirizza a index.html
        header("Location: index.html");
        exit();
    }
} else {
    // Gestione eventuali richieste non POST
    echo "Metodo non consentito";
}
?>