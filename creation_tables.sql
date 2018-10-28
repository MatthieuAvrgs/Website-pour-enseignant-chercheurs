
CREATE TABLE articles ( 
id INT(10) NOT NULL ,
categorie VARCHAR(45) NOT NULL ,
titre VARCHAR(500) NOT NULL ,
annee INT(4) NOT NULL ,
lieu VARCHAR(45) NOT NULL ,
nbr_auteurs INT(2) NOT NULL,
PRIMARY KEY(id)
);
CREATE TABLE auteurs ( 
id INT(10) NOT NULL ,
nom VARCHAR(45) NOT NULL ,
prenom VARCHAR(45) NOT NULL ,
organisation VARCHAR(45) NOT NULL ,
equipe VARCHAR(45) NOT NULL ,
login VARCHAR(45),
mdp VARCHAR(45),
PRIMARY KEY (id)
);
CREATE TABLE publications (
  article_id INTEGER  NOT NULL,
  auteur_id INTEGER NOT NULL,
  ordre INTEGER NOT NULL,
  PRIMARY KEY(article_id, auteur_id),
  FOREIGN KEY(article_id)
    REFERENCES articles(id)
      ON DELETE CASCADE
      ON UPDATE RESTRICT,
  FOREIGN KEY(auteur_id)
    REFERENCES auteurs(id)
      ON DELETE CASCADE
      ON UPDATE RESTRICT
);