CREATE TABLE CLIENTE (
    Indirizzo VARCHAR(255),
    Nome VARCHAR(50) NOT NULL,
    Cognome VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL,
    EMail VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL,
    CF VARCHAR(16) PRIMARY KEY
);

CREATE TABLE FEEDBACK (
    PuntiAssegnati INT,
    Commento TEXT,
    Valutazione INT,
    ClienteCF VARCHAR(16) NOT NULL,
    FOREIGN KEY (ClienteCF) REFERENCES CLIENTE(CF) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE HELPDESK (
    FasciaOraria VARCHAR(20) PRIMARY KEY, 
    ClienteCF VARCHAR(16) NOT NULL,
    DESCRIZIONE VARCHAR(150),
    FOREIGN KEY (ClienteCF) REFERENCES CLIENTE(CF) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE ASSISTENTE (
    Nome VARCHAR(50) NOT NULL,
    ID INT PRIMARY KEY,
    HelpdeskClienteCF VARCHAR(16),
    HelpdeskFasciaOraria VARCHAR(20),
    FOREIGN KEY (HelpdeskClienteCF) REFERENCES CLIENTE(CF) ON UPDATE CASCADE ON DELETE CASCADE , 
    FOREIGN KEY (HelpdeskFasciaOraria) REFERENCES HELPDESK(FasciaOraria) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE CARRELLO (
    Numero INT PRIMARY KEY
);

CREATE TABLE ACQUISTA (
    ClienteCF VARCHAR(16) NOT NULL,
    CarrelloNumero INT NOT NULL,
    FOREIGN KEY (ClienteCF) REFERENCES CLIENTE(CF) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (CarrelloNumero) REFERENCES CARRELLO(Numero) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE CORRIERE (
    IDCorriere INT PRIMARY KEY,
    Stato_ordine VARCHAR(100),
    NumeroTelefonico VARCHAR(15)
);

CREATE TABLE PRODOTTO (
    ID INT PRIMARY KEY,
    Descrizione TEXT,
    Prezzo DECIMAL(10, 2) NOT NULL,
    Nome VARCHAR(50) NOT NULL,
    CorriereIDCorriere INT,
    FOREIGN KEY (CorriereIDCorriere) REFERENCES CORRIERE(IDCorriere) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE CONTIENE(
ProdottoID INT NOT NULL,
CarrelloNumero INT NOT NULL,
FOREIGN KEY(PRODOTTOID) REFERENCES PRODOTTO(ID) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY(CarrelloNumero) REFERENCES CARRELLO(Numero) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE TIPOLOGIA(
NOME VARCHAR(50) NOT NULL,
ProdottoID INT,
FOREIGN KEY (ProdottoID) REFERENCES PRODOTTO(ID) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE FORNITORE (
    CF VARCHAR(16) PRIMARY KEY,
    ORDINE VARCHAR(100),
    NumeroConsegne INT
);

CREATE TABLE FORNITO (
    DataConsegna DATE,
    NumeroProdotti INT,
    ProdottoID INT,
    FornitoreCF VARCHAR(16),
    PRIMARY KEY (DataConsegna, ProdottoID, FornitoreCF),
    FOREIGN KEY (ProdottoID) REFERENCES PRODOTTO(ID) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (FornitoreCF) REFERENCES FORNITORE(CF) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE COMPUTER (
    Dimensione VARCHAR(20),
    AnniDiGaranzia INT PRIMARY KEY,
    Marca VARCHAR(50)
);

CREATE TABLE COMPONENTE (
    Marca VARCHAR(50) NOT NULL,
    Durata INT,
    Wireless BOOLEAN,
    ProdottoID INT NOT NULL,
    ComputerAnniDiGaranzia INT NOT NULL,
    PRIMARY KEY (Marca, ProdottoID),
    FOREIGN KEY (ProdottoID) REFERENCES PRODOTTO(ID) ON UPDATE CASCADE ON DELETE CASCADE ,
    FOREIGN KEY (ComputerAnniDiGaranzia) REFERENCES COMPUTER(AnniDiGaranzia) ON UPDATE CASCADE ON DELETE CASCADE 
);

-- Inserimento in CLIENTE
INSERT INTO CLIENTE (Indirizzo, Nome, Cognome, Username, EMail, Password, CF)
VALUES
    ('Via Roma 123', 'Mario', 'Rossi', 'mario.rossi', 'mario@email.com', 'password123', 'CF12345678901234'),
    ('Via Milano 456', 'Anna', 'Verdi', 'anna.verdi', 'anna@email.com', 'securepass', 'CF56789012345678');

-- Inserimento in FEEDBACK
INSERT INTO FEEDBACK (PuntiAssegnati, Commento, Valutazione, ClienteCF)
VALUES
    (4, 'Ottimo servizio!', 5, 'CF12345678901234'),
    (3, 'Consegna veloce ma con piccoli problemi', 4, 'CF56789012345678');

-- Inserimento in HELPDESK
INSERT INTO HELPDESK (FasciaOraria, ClienteCF, Descrizione)
VALUES
    ('9-00/17-00', 'CF12345678901234', 'Problema con l account'),
    ('14-00/18-00', 'CF56789012345678', 'Assistenza tecnica');

-- Inserimento in ASSISTENTE
INSERT INTO ASSISTENTE (Nome, ID, HelpdeskClienteCF, HelpdeskFasciaOraria)
VALUES
    ('Emilio Giacchetti', 1554837, NULL, '9-00/17-00');
    

-- Inserimento in CARRELLO
INSERT INTO CARRELLO (Numero)
VALUES
    (1),
    (2);

-- Inserimento in ACQUISTA
INSERT INTO ACQUISTA (ClienteCF, CarrelloNumero)
VALUES
    ('CF12345678901234', 1),
    ('CF56789012345678', 2);

-- Inserimento in CORRIERE
INSERT INTO CORRIERE (IDCorriere, Stato_ordine, NumeroTelefonico)
VALUES
    (1, 'In transito', '123-4567890'),
    (2, 'Consegnato', '987-6543210');
	
	
-- Inserimento in PRODOTTO
INSERT INTO PRODOTTO (ID, Descrizione, Prezzo, Nome, CorriereIDCorriere)
VALUES
    (1, 'Intel Core i9-9900K', 499.99, 'Processore', NULL),
    (2, 'NVIDIA GeForce RTX 3080', 799.99, 'Scheda Grafica', NULL),
    (3, 'Corsair Vengeance RGB Pro 32GB', 199.99, 'Memoria RAM', NULL),
    (4, 'Samsung 970 EVO Plus 1TB', 149.99, 'SSD', NULL),
    (5, 'Asus ROG Strix Z590-E Gaming', 279.99, 'Scheda Madre', NULL),
    (6, 'Logitech G Pro Mechanical Keyboard', 129.99, 'Tastiera', NULL),
    (7, 'SteelSeries Rival 600 Gaming Mouse', 69.99, 'Mouse', NULL),
    (8, 'Dell Ultrasharp U2719D 27" Monitor', 349.99, 'Monitor', NULL),
    (9, 'Microsoft Windows 10 Home', 129.99, 'Sistema Operativo', NULL),
    (10, 'MSI MPG A850GF 850W Power Supply', 129.99, 'Alimentatore', NULL);

-- Inserimento in FORNITORE
INSERT INTO FORNITORE (CF, ORDINE, NumeroConsegne)
VALUES
    ('FNCF1234567890', 'Ordine di componenti', 3),
    ('FNCF5678901234', 'Ordine di accessori', 5);

-- Inserimento in FORNITO
INSERT INTO FORNITO (DataConsegna, NumeroProdotti, ProdottoID, FornitoreCF)
VALUES
    ('2024-01-20', 10, 1, 'FNCF1234567890'),
    ('2024-01-21', 5, 2, 'FNCF5678901234');

-- Inserimento in COMPUTER
INSERT INTO COMPUTER (Dimensione, AnniDiGaranzia, Marca)
VALUES
    ('15 pollici', 2, 'Dell'),
    ('17 pollici', 3, 'HP');

-- Inserimento in COMPONENTE
INSERT INTO COMPONENTE (Marca, Durata, Wireless, ProdottoID, ComputerAnniDiGaranzia)
VALUES
    ('Intel', NULL, true, 2, 3),
    ('AMD', NULL, false, 1, 2),
    ('NVIDIA', NULL, true, 3, 2);

-- Inserimento in Tipologia
INSERT INTO TIPOLOGIA(Nome, ProdottoID)
VALUES
    ('Gaming',1),
    ('Gaming',2),
    ('Professional',2),
    ('Ufficio',3),
    ('Ufficio',4),
    ('Gaming',5),
    ('Gaming',6),
    ('Ufficio',6),
    ('Gaming',7),
    ('Gaming',8),
    ('Ufficio',8),
    ('Ufficio',9),
    ('Gaming',10),
    ('Ufficio',10);    
	
--1 Creare un nuovo account cliente:

INSERT INTO CLIENTE (Indirizzo, Nome, Cognome, Username, Email, Password, CF)
VALUES ('Via Marchetti 178, Roma Centro', 'Mario', 'Rossi', 'MarioR79', 'rossimario@gmailcom', 'password123', 'MRRSS192859I432');

--2 Dare un feedback:

INSERT INTO FEEDBACK (Puntiassegnati, Commento, Valutazione, ClienteCF)
VALUES (5, 'Ottimo servizio!', 5, 'MRRSS192859I432');

--3 Usare Helpdesk:

INSERT INTO HELPDESK (Fasciaoraria, ClienteCF, Descrizione)
VALUES ('9:00/17:00', 'MRRSS192859I432', 'Richiesta di assistenza per un problema tecnico.');

--4 Gestione Helpdesk:

SELECT * FROM HELPDESK WHERE ClienteCF = 'MRRSS192859I432';

--5 Effettuare ordini dal fornitore:

INSERT INTO FORNITO (Dataconsegna, NumProdotti, ProdottoID, FornitoreCF)
VALUES ('2024-01-21', 10, 1, 'LNZCRS365329A632');

--6 Contattare il corriere per aggiornamenti:

SELECT Stato_ordine FROM CORRIERE WHERE IDCorriere = 1;

--7 Creazione del carrello:

INSERT INTO CARRELLO (Numero) VALUES (1);

--8 Aggiunta di un prodotto al carrello:

INSERT INTO PRODOTTO (ID, Descrizione, Prezzo, Nome, Tipologia, CarrelloNumero)
VALUES (1, 'Tastiera da gaming', 50.00, 'Phantom keyboard', 'Gaming', 1);

--9 Acquisto di un prodotto:

INSERT INTO ACQUISTA (ClienteCF, CarrelloNumero) VALUES ('RRGD256230E234', 1);

--10 Acquisto di un P.C. da assemblare con scelta componenti:

-- Inserisci i dettagli del computer e dei componenti nel database prima di effettuare l'acquisto
INSERT INTO COMPUTER (Dimensione, Annidigaranzia, Marca) VALUES ('15 pollici', 1, 'Dell');
SELECT * FROM COMPONENTE WHERE Marca = Intel AND Durata IS NULL, ProdottoID = 1, AnniDiGaranzia = 1;

-- Poi effettua l'acquisto
INSERT INTO ACQUISTA (ClienteCF, CarrelloNumero) VALUES ('MRRSS192859I432', 2); 
 
--11 Selezionare i prodotti professional da un dato nome

SELECT * FROM PRODOTTO,TIPOLOGIA WHERE Tipologia.nome= 'Professional' AND Prodotto.nome = 'Processore' AND Tipologia.ProdottoID = Prodotto.ID

--12 Selezionare i componenti data una marca tranne quelli di marca Intel:

SELECT * FROM COMPONENTE WHERE Marca = 'AMD' AND NOT EXISTS (SELECT * FROM COMPONENTE WHERE MARCA = 'Intel');

--13 Selezionare i P.C. da una data dimensione:

SELECT * FROM COMPUTER WHERE Dimensione = '17 pollici';

--14 Sottoscrivere abbonamento con una durata stabilita:
INSERT INTO COMPONENTE (Marca, Durata, Wireless, ProdottoID, ComputerAnniDiGaranzia)
VALUES ('Kaspersky', 12, FALSE, 9, 2);


--15 Selezionare le periferiche wireless:

SELECT * FROM COMPONENTE WHERE Wireless = TRUE;

--16 Selezionare i clienti che hanno dato feedback >4:

SELECT * FROM FEEDBACK WHERE Valutazione > 4;

--17 Rimuovere dal carrello i prodotti della tipologia “gaming”:

DELETE FROM PRODOTTO WHERE Tipologia = 'Gaming' AND CarrelloNumero = 1;





