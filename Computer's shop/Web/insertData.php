<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aereoporto";

 
$conn = new mysqli($servername, $username, $password, $dbname);

 
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

 
$tableName = $_POST['Inserisci'];


switch ($tableName) {
    case 'newAirplane':
        $matricola = mysqli_real_escape_string($conn, $_POST['alMatricola']);
        $marca = mysqli_real_escape_string($conn, $_POST['alMarca']);
        $dataDiAcquisto = mysqli_real_escape_string($conn, $_POST['alDataAcquisto']);
        $capacita = $_POST['alCapacità'];
        $sql = "INSERT INTO AereoDiLinea (Matricola, Marca, DataDiAcquisto, Capacità) VALUES ('$matricola', '$marca', '$dataDiAcquisto', $capacita)";
        $stringa = $matricola . ' ' . $marca . ' ' . $dataDiAcquisto . ' ' . $capacita;
        break;
    case 'newCargoPlane':
        $matricola = mysqli_real_escape_string($conn, $_POST['acMatricola']);
        $marca = mysqli_real_escape_string($conn, $_POST['acMarca']);
        $dataDiAcquisto = mysqli_real_escape_string($conn, $_POST['acDataAcquisto']);
        $sql = "INSERT INTO AereoCargo (Matricola, Marca, DataDiAcquisto) VALUES ('$matricola', '$marca', '$dataDiAcquisto')";
        $stringa = $matricola . ' ' . $marca . ' ' . $dataDiAcquisto;
        break;
    case 'newAirport':
        $codice = mysqli_real_escape_string($conn, $_POST['aeCodice']);
        $nome = mysqli_real_escape_string($conn, $_POST['aeNome']);
        $citta = mysqli_real_escape_string($conn, $_POST['aeCittà']);
        $stato = mysqli_real_escape_string($conn, $_POST['aeStato']);
        $sql = "INSERT INTO Aeroporto (Codice, Nome, Città, Stato) VALUES ('$codice', '$nome', '$citta', '$stato')";
        $stringa = $codice . ' ' . $nome . ' ' . $citta . ' ' . $stato;
        break;
    case 'newFlight':
        $id = $_POST['voID'];
        $data = mysqli_real_escape_string($conn, $_POST['voData']);
        $durata = mysqli_real_escape_string($conn, $_POST['voDurata']);
        $aeCodice = mysqli_real_escape_string($conn, $_POST['voAeCodice']);
        $sql = "INSERT INTO Volo (Id,Data, Durata, AeroportoCodice) VALUES ($id, '$data', '$durata', '$aeCodice')";
        $stringa = $id . ' ' . $data . ' ' . $durata . ' ' . $aeCodice;
        break;
    case 'newPassenger':
        $cf = mysqli_real_escape_string($conn, $_POST['paCF']);
        $nome = mysqli_real_escape_string($conn, $_POST['paNome']);
        $cognome = mysqli_real_escape_string($conn, $_POST['paCognome']);
        $aeLinea = $_POST['paAeLinea'];
        $sql = "INSERT INTO Passeggero (CF, Nome, Cognome, AereoDiLineaMatricola) VALUES ('$cf', '$nome', '$cognome', '$aeLinea')";
        $stringa = $cf . ' ' . $nome . ' ' . $cognome . ' ' . $aeLinea;
        break;
    case 'newNationality':
        $nome = mysqli_real_escape_string($conn, $_POST['naNome']);
        $cf = mysqli_real_escape_string($conn, $_POST['naCF']);
        $sql = "INSERT INTO Nazionalità (Nome, PasseggeroCF) VALUES ('$nome', '$cf')";
        $stringa = $nome . ' ' . $cf . ' ';
        break;
    case 'newGoods':
        $id = $_POST['meID'];
        $peso = $_POST['mePeso'];
        $aeCargo = mysqli_real_escape_string($conn, $_POST['meAeCargo']);
        $sql = "INSERT INTO Merce (ID, Peso, AereoCargoMatricola) VALUES ($id, $peso, '$aeCargo')";
        $stringa = $id . ' ' . $peso . ' ' . $aeCargo . ' ';
        break;
    case 'newGoodsCategory':
        $nome = mysqli_real_escape_string($conn, $_POST['caNome']);
        $id = $_POST['caID'];
        $sql = "INSERT INTO Categoria (Nome, MerceID) VALUES ('$nome', $id)";
        $stringa = $nome . ' ' . $id . ' ';
        break;
    case 'newReservation':
        $id = $_POST['prID'];
        $np = mysqli_real_escape_string($conn, $_POST['prNp']);
        $na = mysqli_real_escape_string($conn, $_POST['prNa']);
        $tipologia = mysqli_real_escape_string($conn, $_POST['prTipologia']);
        $cf = mysqli_real_escape_string($conn, $_POST['prCF']);
        $meID = $_POST['prMeID'];
        $voID = $_POST['prVoID'];
        $sql = "INSERT INTO Prenotazione (ID, NazionePartenza, NazioneArrivo, Tipologia, PasseggeroCF, MetodoPagamentoID, VoloID) VALUES ($id, '$np', '$na', '$tipologia', '$cf', $meID, $voID)";
        $stringa = $id . ' ' . $np. ' ' . $na . ' ' . $tipologia . ' ' . $cf. ' ' . $meID . ' ' .  $voID . ' ';
        break;
    case 'newLinkFlightCargo':
        $efAeCargo = mysqli_real_escape_string($conn, $_POST['efAeCargo']);
        $efVoID = $_POST['efVoID'];
        $sql = "INSERT INTO Effettua (AereoCargoMatricola, VoloID) VALUES ('$efAeCargo', $efVoID)";
        $stringa = $efAeCargo. ' ' . $efVoID . ' ';
        break;
    case 'newLinkFlightDiLinea':
        $efAeDiLinea = mysqli_real_escape_string($conn, $_POST['efAeDiLinea']);
        $efVoID = $_POST['efVoID'];
        $sql = "INSERT INTO Opera (AereoDiLineaMatricola, VoloID) VALUES ('$efAeDiLinea', $efVoID)";
        $stringa = $efAeDiLinea. ' ' . $efVoID . ' ';
        break;
    default:
        echo "Errore: Tabella non riconosciuta.";
        exit();
}

$conn->query($sql);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati Query</title>
    <link rel="stylesheet" href="selectCss.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>

        .result-container {
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        
        }
    </style>


</head>
<body>
<br><br><br>
<div class="wrapper">
    <div class="result-container">
        <?php
  
            echo '<br><br>';
            echo '<h2>Riepilogo inserimento</h2>';      
            echo "<p>$stringa</p>";

        ?>
    </div>

    <br><br><br><br>
       
    <button type="submit" class="btn1"  ><a href="page1.html" style="color:#ffffff" >Ritorna indietro</a></button> 
      <br><br><br>
      <button type="submit" class="btn" ><a href="index.html">Logout</a></button>
</div>

</body>
</html>

