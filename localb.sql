USE localb;

-- (Optionnel) Encodage recommandé
SET NAMES utf8mb4;
SET time_zone = "+00:00";

-- =========================
-- TABLE 1 : benevole
-- =========================
DROP TABLE IF EXISTS participation;
DROP TABLE IF EXISTS mission;
DROP TABLE IF EXISTS benevole;

CREATE TABLE benevole (
  id_benevole INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  telephone VARCHAR(30) NULL,
  mot_de_passe_hash VARCHAR(255) NOT NULL,
  role ENUM('BENEVOLE','ADMIN') NOT NULL DEFAULT 'BENEVOLE',
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABLE 2 : mission
-- =========================
CREATE TABLE mission (
  id_mission INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  lieu VARCHAR(150) NOT NULL,
  date_debut DATETIME NOT NULL,
  date_fin DATETIME NULL,
  date_limite_inscription DATETIME NULL,
  nb_places INT NOT NULL DEFAULT 1,
  statut ENUM('BROUILLON','OUVERTE','COMPLETE','CLOTUREE','ANNULEE') NOT NULL DEFAULT 'OUVERTE',
  publique TINYINT(1) NOT NULL DEFAULT 1,
  created_by INT NULL,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_maj DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_mission_created_by
    FOREIGN KEY (created_by) REFERENCES benevole(id_benevole)
    ON DELETE SET NULL ON UPDATE CASCADE,

  CONSTRAINT chk_nb_places
    CHECK (nb_places >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- TABLE 3 : participation (lien benevole <-> mission)
-- =========================
CREATE TABLE participation (
  id_participation INT AUTO_INCREMENT PRIMARY KEY,
  id_benevole INT NOT NULL,
  id_mission INT NOT NULL,

  -- statut de la demande / participation
  statut ENUM('EN_ATTENTE','VALIDEE','REFUSEE','ANNULEE') NOT NULL DEFAULT 'EN_ATTENTE',

  commentaire VARCHAR(255) NULL,
  date_demande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_decision DATETIME NULL,
  decided_by INT NULL,

  -- Un bénévole ne peut pas avoir 2 participations pour la même mission
  UNIQUE KEY uq_participation (id_benevole, id_mission),

  CONSTRAINT fk_participation_benevole
    FOREIGN KEY (id_benevole) REFERENCES benevole(id_benevole)
    ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT fk_participation_mission
    FOREIGN KEY (id_mission) REFERENCES mission(id_mission)
    ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT fk_participation_decided_by
    FOREIGN KEY (decided_by) REFERENCES benevole(id_benevole)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- INDEX utiles (performances)
-- =========================
CREATE INDEX idx_mission_dates ON mission(date_debut, statut);
CREATE INDEX idx_participation_statut ON participation(statut);
CREATE INDEX idx_participation_mission ON participation(id_mission);

-- =========================
-- Données de test (optionnel)
-- =========================
INSERT INTO benevole (nom, prenom, email, telephone, mot_de_passe_hash, role)
VALUES
('Admin', 'BenovAide', 'admin@benovaide.fr', '0600000000', '$2y$10$EXEMPLEHASHREMPLACER', 'ADMIN'),
('Dupont', 'Baptiste', 'baptiste.dupont@mail.com', '0611111111', '$2y$10$EXEMPLEHASHREMPLACER', 'BENEVOLE'),
('Charles', 'Marine', 'marine.charles@mail.com', '0622222222', '$2y$10$EXEMPLEHASHREMPLACER', 'BENEVOLE');

INSERT INTO mission (titre, description, lieu, date_debut, date_fin, date_limite_inscription, nb_places, statut, publique, created_by)
VALUES
('Collecte alimentaire', 'Aide à la collecte et au tri des denrées.', 'Paris 10e', '2026-01-15 09:00:00', '2026-01-15 13:00:00', '2026-01-14 23:59:59', 10, 'OUVERTE', 1, 1),
('Maraude', 'Distribution de repas et échange avec les personnes.', 'Lyon 3e', '2026-01-20 18:00:00', '2026-01-20 21:00:00', '2026-01-19 23:59:59', 6, 'OUVERTE', 1, 1);

INSERT INTO participation (id_benevole, id_mission, statut, commentaire)
VALUES
(2, 1, 'EN_ATTENTE', 'Disponible le matin.'),
(3, 1, 'VALIDEE', 'OK');
