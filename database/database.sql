CREATE TABLE clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE comptes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(100) NOT NULL,
    solde FLOAT NOT NULL DEFAULT 0,
    type ENUM('courant', 'epargne') NOT NULL,
    client_id INT NOT NULL,
    decouvert_max FLOAT NOT NULL DEFAULT 0,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    compte_id INT NOT NULL,
    type ENUM('deposer','retirer') NOT NULL,
    montant FLOAT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (compte_id) REFERENCES comptes(id) ON DELETE CASCADE
);