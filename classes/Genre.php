<?php

class Genre {
    
    private string $nomGenre;
    private array $films;

    public function __construct(string $nomGenre) {
        $this->nomGenre = $nomGenre;
        $this->films = [];
    }

    public function getNomGenre() { 
        return $this->nomGenre; 
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

    public function __toString() {
        return $this->nomGenre;
    }
}