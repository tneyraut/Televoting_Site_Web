--
-- Base de données: pdr
--

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS questionnaire;
DROP TABLE IF EXISTS cours;
DROP TABLE IF EXISTS question;
DROP TABLE IF EXISTS reponse;
DROP TABLE IF EXISTS participant;
DROP TABLE IF EXISTS proposition_reponse;
DROP TABLE IF EXISTS user_groupe;
DROP TABLE IF EXISTS groupe;
DROP TABLE IF EXISTS absence;
DROP TABLE IF EXISTS retard;

-- --------------------------------------------------------

--
-- Structure de la table user
--

CREATE TABLE user (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  login varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  professeur tinyint(1) DEFAULT 0,
  responsable_absence_retard tinyint(1) DEFAULT 0,
  admin tinyint(1) DEFAULT 0,
  annee int(11) NOT NULL,
  promotion int(11) NOT NULL,
  PRIMARY KEY (user_id)
);

-- --------------------------------------------------------

--
-- Structure de la table cours (autre clé primaire)
--
 
CREATE TABLE cours (
  cours_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  cours_name varchar(255) NOT NULL,
  annee int(11) NOT NULL,
  groupe_id int(11) NOT NULL,
  PRIMARY KEY (cours_id),
  KEY fk_participe (user_id)
);

-- --------------------------------------------------------

--
-- Structure de la table questionnaire
--

CREATE TABLE questionnaire (
  questionnaire_id int(11) NOT NULL AUTO_INCREMENT,
  cours_id int(11) NOT NULL,
  questionnaire_name varchar(255) NOT NULL,
  mode_examen tinyint(1) DEFAULT 0,
  malus float DEFAULT 0,
  pause tinyint(1) DEFAULT 1,
  lancee tinyint(1) DEFAULT 0,
  PRIMARY KEY (questionnaire_id),
  KEY fk_possede (cours_id)
);

-- --------------------------------------------------------

--
-- Structure de la table question
--

CREATE TABLE question (
  question_id int(11) NOT NULL AUTO_INCREMENT,
  questionnaire_id int (11) NOT NULL,
  question varchar(255) NOT NULL,
  temps_imparti int(11) DEFAULT 0,
  image varchar(255) DEFAULT '',
  PRIMARY KEY (question_id),
  KEY fk_compose (questionnaire_id)
);

-- --------------------------------------------------------

--
-- Structure de la table reponse
--

CREATE TABLE reponse (
  reponse_id int(11) NOT NULL AUTO_INCREMENT,
  question_id int(11) NOT NULL,
  reponse varchar(255) NOT NULL,
  reponse_correcte tinyint(1) DEFAULT 0,
  image varchar(255) DEFAULT '',
  PRIMARY KEY (reponse_id),
  KEY fk_repond (question_id)
);

-- --------------------------------------------------------

--
-- Structure de la table participant
--

CREATE TABLE participant (
  participant_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  questionnaire_id int(11) NOT NULL,
  nombre_de_fautes int(11) DEFAULT 0,
  nombre_de_bonnes_reponses int(11) DEFAULT 0,
  note float DEFAULT 0,
  PRIMARY KEY (participant_id)
);

-- --------------------------------------------------------

--
-- Structure de la table proposition_reponse
--

CREATE TABLE proposition_reponse (
  proposition_reponse_id int(11) NOT NULL AUTO_INCREMENT,
  participant_id int(11) NOT NULL,
  question_id int(11) NOT NULL,
  reponse_id int(11) NOT NULL,
  PRIMARY KEY (proposition_reponse_id)
);

-- --------------------------------------------------------

--
-- Structure de la table user_groupe
--

CREATE TABLE user_groupe (
  user_groupe_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  groupe_id int(11) NOT NULL,
  PRIMARY KEY (user_groupe_id)
);

-- --------------------------------------------------------

--
-- Structure de la table groupe
--

CREATE TABLE groupe (
  groupe_id int(11) NOT NULL AUTO_INCREMENT,
  groupe_name varchar(255) NOT NULL,
  PRIMARY KEY (groupe_id)
);

-- --------------------------------------------------------

--
-- Structure de la table absence
--

CREATE TABLE absence (
  absence_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  cours_id int(11) NOT NULL,
  date_value varchar(255) NOT NULL,
  justifiee tinyint(1) DEFAULT 0,
  PRIMARY KEY (absence_id)
);

-- --------------------------------------------------------

--
-- Structure de la table retard
--

CREATE TABLE retard (
  retard_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  cours_id int(11) NOT NULL,
  date_value varchar(255) NOT NULL,
  justifiee tinyint(1) DEFAULT 0,
  PRIMARY KEY (retard_id)
);
