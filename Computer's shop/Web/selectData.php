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
$operationType = "";
 
 
$query = "";
switch ($tableName) {
    case '9':
        $query = "SELECT Volo.ID AS Volo_ID, Volo.Data, Volo.Durata, Aeroporto.Codice AS Aeroporto_Codice,COUNT(Passeggero.CF) AS Numero_Passeggeri
        FROM Volo, Aeroporto, AereoDiLinea, Passeggero, Opera
        WHERE Volo.AeroportoCodice = Aeroporto.Codice AND Volo.ID = Opera.VoloID AND Opera.AereoDiLineaMatricola = AereoDiLinea.Matricola
              AND AereoDiLinea.Matricola = Passeggero.AereoDiLineaMatricola
        GROUP BY Volo.ID, Volo.Data, Volo.Durata, Aeroporto.Codice;";
        break;
    
    case '10':
        $query = "SELECT COUNT(*) AS NumeroVoli
                  FROM Volo
                  WHERE MONTH(Data) = 1;";
        break;

    case '11':
        $query = "SELECT DISTINCT A.Matricola
                  FROM AereoDiLinea A, Passeggero P, Nazionalità N
                  WHERE A.Marca = 'ItAir' AND A.Matricola = P.AereoDiLineaMatricola AND P.CF = N.PasseggeroCF AND N.Nome = 'Italia'
                    AND NOT EXISTS (
                        SELECT *
                        FROM Nazionalità as N2
                        WHERE N2.PasseggeroCF = P.CF
                          AND N2.Nome <> 'Italia'
                    );";
        break;

    case '12':
        $query = "SELECT DISTINCT Matricola
                  FROM AereoDiLinea as AL, Opera as O, Volo as V
                  WHERE O.VoloID = V.ID AND O.AereoDiLineaMatricola = AL.Matricola
                        AND DAY(V.Data) = 15
                        AND YEAR(V.Data) = 2022;";
        break;

    case '13':
        $query = "SELECT COUNT(*) AS NumeroPasseggeri
                  FROM Passeggero P, AereoDiLinea AL, Opera O
                  WHERE P.AereoDiLineaMatricola = AL.Matricola
                        AND O.AereoDiLineaMatricola = AL.Matricola
                        AND O.VoloID = '777';";
        break;

    case '14':
        $query = "SELECT AL.*,V.*
                  FROM AereoDiLinea as AL, Opera as O, Volo as V, Aeroporto as A
                  WHERE O.VoloID = V.ID AND V.AeroportoCodice = A.Codice
                        AND A.Città = 'Milano'
                        AND O.AereoDiLineaMatricola = AL.Matricola;";
        break;

        case '15':
            $operationType = "Delete";
            $query = "DELETE FROM Volo AS V
                      WHERE EXISTS (
                          SELECT *
                          FROM Prenotazione as P
                          WHERE P.VoloID = V.ID
                          AND P.NazioneArrivo = 'Spagna'
                      ); ";
            break;

    case '16':
        $query = "SELECT DISTINCT P.CF, P.Nome, P.Cognome
                  FROM Passeggero P, Nazionalità N, Prenotazione Pr
                  WHERE P.CF = N.PasseggeroCF AND N.Nome = 'Italia'
                        AND NOT EXISTS (
                            SELECT *
                            FROM Prenotazione
                            WHERE PasseggeroCF = P.CF
                            AND NazioneArrivo = 'Francia'
                        );";
        break;

    case '17':
        $query = "SELECT COUNT(*) AS NumeroMerce
                  FROM Effettua E, AereoCargo AC, Volo V, Merce M
                  WHERE E.AereoCargoMatricola = AC.Matricola AND E.VoloID = V.ID AND E.AereoCargoMatricola =  M.AereoCargoMatricola
                        AND V.Data BETWEEN '2022-01-01' AND '2022-01-21'
                        AND NOT EXISTS 
                        (
                            SELECT *
                            FROM Categoria C
                            WHERE C.MerceID = M.ID
                            AND C.Nome = 'Tecnologia'
                        );";
        break;

    case '18':
        $query = "SELECT DISTINCT P.Nome, P.Cognome
                  FROM Passeggero as P, Prenotazione as Pr, Aeroporto as A, Volo V
                  WHERE P.CF = Pr.PasseggeroCF AND Pr.VoloID = V.ID and V.AeroportoCodice = A.codice
                        AND A.Città = 'Roma'
                        AND P.Nome LIKE 'M%'
                  ORDER BY P.Cognome DESC;";
        break;

    case '19':
        $query = "SELECT MAX(M.Peso) AS PesoMassimo
                  FROM Merce M, AereoCargo AC, Effettua E, Volo V
                  WHERE M.AereoCargoMatricola = AC.Matricola
                        AND E.AereoCargoMatricola = AC.Matricola
                        AND E.VoloID = V.ID
                        AND AC.DataDiAcquisto BETWEEN '2020-01-01' AND '2020-12-31';";
        break;

   

    default:
        
        break;
}
 
$result = $conn->query($query);

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
        
        if ($result) 
        {    if ($operationType == "Delete") {
            echo '<h2>Operazione di Eliminazione eseguita con successo</h2>';
            }
            else
            {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                echo '<br><br>';
    
                echo '<h2>Risultati della Query</h2>';
                
           
                foreach ($data as $row) {
                    foreach ($row as $key => $value) {
                        echo "<p><strong>$key:</strong> $value</p>";
                    }
                    echo '<hr>';
                }
            }

        } 
        else {
            echo '<p>Errore nella query: ' . $conn->error . '</p>';
        }
        mysqli_close($conn);
        ?>
    </div>

    <br><br><br><br>
       
    <button type="submit" class="btn1"  ><a href="page1.html" style="color:#ffffff" >Ritorna indietro</a></button> 
      <br><br><br>
      <button type="submit" class="btn" ><a href="index.html">Logout</a></button>
</div>

</body>
</html>
