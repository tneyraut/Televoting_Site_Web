SET foreign_key_checks = 0; 

TRUNCATE user;
TRUNCATE cours;
TRUNCATE questionnaire;
TRUNCATE question;
TRUNCATE reponse;
TRUNCATE participant;
TRUNCATE proposition_reponse;
TRUNCATE user_groupe;
TRUNCATE groupe;
TRUNCATE absence;
TRUNCATE retard;

INSERT INTO user(login,password,professeur) VALUES 
('yoda', SHA1('starwars'), 1),
('obiwan', SHA1('obiwan'), 1);

INSERT INTO user(login,password,professeur,admin,responsable_absence_retard) VALUES ('phoenix', SHA1('starwars'), 0, 1, 1);

INSERT INTO user(login,password,professeur,annee,promotion) VALUES 
('anakin', SHA1('anakin'), 0, 2, 2016),
('vador', SHA1('vador'), 0, 1, 2017),
('luke', SHA1('luke'), 0, 3, 2015),
('toto', SHA1('toto'), 0, 4, 2014),
('titi', SHA1('titi'), 0, 4, 2014),
('tata', SHA1('tata'), 0, 4, 2014),
('tutu', SHA1('tutu'), 0, 4, 2014),
('tete', SHA1('tete'), 0, 4, 2014),
('test1', SHA1('test1'), 0, 2, 2016),
('test2', SHA1('test2'), 0, 2, 2016),
('test3', SHA1('test3'), 0, 2, 2016),
('test4', SHA1('test4'), 0, 2, 2016),
('test5', SHA1('test5'), 0, 2, 2016),
('test6', SHA1('test6'), 0, 2, 2016),
('test7', SHA1('test7'), 0, 2, 2016),
('test8', SHA1('test8'), 0, 2, 2016),
('test9', SHA1('test9'), 0, 2, 2016);

INSERT INTO groupe(groupe_name) VALUES
('FI1A'),
('FI2A'),
('FI3A'),
('FI2A Groupe A'),
('FI2A Groupe B');

INSERT INTO user_groupe(user_id,groupe_id) VALUES
(4,2),
(5,1),
(6,3),
(7,3),
(8,3),
(9,3),
(10,3),
(11,3),
(12,2),
(13,2),
(14,2),
(15,2),
(16,2),
(17,2),
(18,2),
(19,2),
(20,2),
(12,4),
(13,4),
(14,4),
(15,4),
(16,4),
(17,4),
(18,4),
(19,4),
(20,4);

INSERT INTO cours(user_id,cours_name,annee,groupe_id) VALUES
(1,'Star Wars',1,1),
(1,'Informatique : Langage de programmation',1,1),
(1,'Star Wars Bis',3,3),
(1,'ISIC',2,2),
(1,'Développement Web',2,4);

INSERT INTO questionnaire(cours_id,questionnaire_name,mode_examen,pause,malus,lancee) VALUES
(1,'Questionnaire 1',0,1,0,1),
(2,'Questionnaire de bienvenue',1,0,0.25,1),
(3,'Questionnaire test image',0,1,0,1),
(4,'Test de cours',1,0,0.25,0),
(4,'Bilan ISIC - PDR',1,0,0,0);

-- --------------------------------------------------------

--
-- Questionnaire 1
--

INSERT INTO question(questionnaire_id,question,temps_imparti) VALUES 
(1,'Qui est le meilleur Jedi de tout les temps ?',0),
(1,'Qui a vaincu Dark Sidious ?',0),
(1,'Quels Siths ont été vaincus par Obiwan ?',0),
(1,'Quelles planètes suivantes apparaissent dans les six premiers films star wars ?',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(1,'Obiwan Kenobi',0),
(1,'Luke Skywalker',0),
(1,'Anakin Skywalker',0),
(1,'Yoda',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(2,'Luke Skywalker',0),
(2,'Yoda',0),
(2,'Dark Vador',0),
(2,'Obiwan Kenobi',0),
(2,'Anakin Skywalker',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(3,'Dark Maul',1),
(3,'Dark Vador',1),
(3,'Anakin Skywalker',0),
(3,'General Grievious',0),
(3,'Comte Dooku',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(4,'Hoth',1),
(4,'Dagobah',1),
(4,'Byss',0),
(4,'Kuat',0),
(4,'Sullust',0),
(4,'Couruscant',1),
(4,'Naboo',1),
(4,'Mon Calamari',0),
(4,'Kamino',1),
(4,'Yavin',1),
(4,'Ilum',0);

-- --------------------------------------------------------

--
-- Questionnaire de bienvenue
--

INSERT INTO question(questionnaire_id,question,temps_imparti) VALUES 
(2,'Parmis les élèments suivants, les quels sont des langages de programmations ?',60),
(2,'Trouvez la bonne commande en C :',30),
(2,'Trouvez la bonne commande en Java :',30),
(2,'Trouvez la bonne commande en Objective-C :',30),
(2,'Trouvez la bonne commande en SmallTalk :',30);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(5,'Java',1),
(5,'C',1),
(5,'C++',1),
(5,'C#',1),
(5,'Objective-C',1),
(5,'C+-',0),
(5,'C+',0),
(5,'SmallTalk',1),
(5,'Fortrand',0),
(5,'Fortran',1),
(5,'Fortrant',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(6,'printf();',1),
(6,'System.out.println();',0),
(6,'Transcript show:.',0),
(6,'NSLog();',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(7,'printf();',0),
(7,'System.out.println();',1),
(7,'Transcript show:.',0),
(7,'NSLog();',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(8,'printf();',0),
(8,'System.out.println();',0),
(8,'Transcript show:.',0),
(8,'NSLog();',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(9,'printf();',0),
(9,'System.out.println();',0),
(9,'Transcript show:.',0),
(9,'NSLog();',0);


-- --------------------------------------------------------

--
-- Questionnaire Test image
--

INSERT INTO question(questionnaire_id,question,image) VALUES 
(3,'A quel univer corresponds cette image ?','images/imagesUpload/1234.jpg'),
(3,'Qui est ce droïde ?','images/imagesUpload/12.jpg');

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(10,'Star Wars',1),
(10,'Star Académie',0),
(10,'Star Trek',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(11,'R2-D2',1),
(11,'R1-D2',0),
(11,'R1-D1',0),
(11,'R2-D1',0);

-- --------------------------------------------------------

--
-- Questionnaire Bilan ISIC - PDR
--

INSERT INTO question(questionnaire_id,question,temps_imparti) VALUES 
(5,'Parmis les éléments suivants, lequel est selon vous le meilleur langage de programmation ?',30),
(5,'Parmis les éléments suivants, lequel est selon vous le pire langage de programmation ?',30),
(5,'Quel projet réalisé cette année avez-vous le plus apprécié ?',30),
(5,'Quel cours avez-vous le plus apprécié cette année ?',30),
(5,'Comment qualiferiez-vous la charge de travail en ISIC ?',30),
(5,'Quel est votre meilleur souvenir en ISIC ?',30),
(5,'Comment avez-vous trouvé ce PDR : Application Televoting ?',30),
(5,'Quelle note mettriez-vous à ce PDR ?',30);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(12,'C',1),
(12,'C++',1),
(12,'SmallTalk',1),
(12,'Java',1),
(12,'Objective-c',1),
(12,'Swift',1),
(12,'C#',1),
(12,'PHP',1),
(12,'JavaScript',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(13,'C',1),
(13,'C++',1),
(13,'SmallTalk',1),
(13,'Java',1),
(13,'Objective-c',1),
(13,'Swift',1),
(13,'C#',1),
(13,'PHP',1),
(13,'JavaScript',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(14,'Le projet Web bien évidement',1),
(14,'Le projet iOS',1),
(14,'Le projet systèmes embarqués',1),
(14,'Le projet Androïd',1),
(14,'Le PDR',1),
(14,'Aucun, je les hais tous !',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(15,'Langage C',1),
(15,'Programmation par objets',1),
(15,'Projet Web',1),
(15,'Charte graphique et Ergonomie',1),
(15,'Introduction Réseau',1),
(15,'Réseaux Avancés',1),
(15,'Services Réseau',1),
(15,'Systèmes',1),
(15,'Réseaux de télécommunications',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(16,'Tout à fait adaptée',1),
(16,'Trop de travail !',1),
(16,'Un peu surchargé',1),
(16,'Y a jamais assez de projets',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(17,'La cuite pour fêter la fin du projet web',1),
(17,'La cuite de ce soir pour fêter la fin du PDR et celle des cours',1),
(17,'Les cours de C',1),
(17,'Les cours de systèmes',1),
(17,'Le projet Web',1),
(17,'Le PDR',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(18,'Vraiment super',1),
(18,'Juste génial',1),
(18,'Best PDR ever',1);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(19,'18/20',1),
(19,'19/20',1),
(19,'20/20',1),
(19,'23/20',1),
(19,'120/20',1);

-- --------------------------------------------------------

--
-- Questionnaire Test de cours
--

INSERT INTO question(questionnaire_id,question,temps_imparti) VALUES 
(4,'Le réseau 191.34.45.4 est de quelle classe ?',30),
(4,'Le réseau 229.255.255.0 est de quelle classe ?',30),
(4,'Quel est le masque du réseau 192.234.16.0 /24 ?',30),
(4,'Le réseau 195.255.256.0 est de quelle classe ?',30),
(4,'Quelle formule permet de calculer le nombre de sous-réseaux ?',30);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(20,'Classe A',0),
(20,'Classe B',1),
(20,'Classe C',0),
(20,'Classe D',0),
(20,'Classe E',0),
(20,'Classe F',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(21,'Classe A',0),
(21,'Classe B',0),
(21,'Classe C',0),
(21,'Classe D',1),
(21,'Classe E',0),
(21,'Classe F',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(22,'192.234.255.0',0),
(22,'255.255.255.0',1),
(22,'192.255.255.0',0),
(22,'255.256.255.0',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(23,'Classe A',0),
(23,'Classe B',0),
(23,'Classe C',0),
(23,'Classe D',0),
(23,'Classe E',0),
(23,'Classe F',0);

INSERT INTO reponse(question_id,reponse,reponse_correcte) VALUES 
(24,'2^n',1),
(24,'2^n - 1',0),
(24,'2^(n-1)',0),
(24,'2^(n-1) - 1',0);

SET FOREIGN_KEY_CHECKS=1; 