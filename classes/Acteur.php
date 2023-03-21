<?php

class Acteur extends Personne {

    private array $castings;

    public function __construct(string $prenom, string $nom, string $sexe, string $dateNaissance) {
        parent::__construct($prenom, $nom, $sexe, $dateNaissance);
        $this->castings = []; 
    }

    public function getCastings() {
        return $this->castings;
    }

    public function ajouterCasting(Casting $casting) {
        $this->castings[] = $casting;
    }

    public function afficherFilmographie() {
        $result = "<h1>Filmographie de $this</h1>";
        foreach ($this->castings as $casting) {
            $result .= $casting->getFilm()." (". $casting->getRole().")<br>";
        }
        return $result;
    }
}