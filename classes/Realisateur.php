<?php

class Realisateur extends Personne {
 
    private array $films;

    public function __construct(string $prenom, string $nom, string $sexe, string $dateNaissance) {
        parent::__construct($prenom, $nom, $sexe, $dateNaissance);
        $this->films = []; 
    }

    public function getFilms() {
        return $this->films;
    }

    public function ajouterFilm(Film $film) {
        $this->films[] = $film;
    }

    public function afficherFilms() {
        $result = "<h1>Films de $this</h1>";
        foreach ($this->films as $film) {
            $result .= $film."<br>";
        }
        return $result;
    }
}