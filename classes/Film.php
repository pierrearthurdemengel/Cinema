<?php

class Film {

    private string $titre;
    private DateTime $dateSortie;
    private int $duree;
    private string $synopsis;
    private Genre $genre;
    private Realisateur $realisateur;
    private array $castings;

    public function __construct(string $titre, string $dateSortie, int $duree, string $synopsis, Genre $genre, Realisateur $realisateur) {
        $this->titre = $titre;
        $this->dateSortie = new DateTime($dateSortie);
        $this->duree = $duree;
        $this->synopsis = $synopsis;
        $this->genre = $genre;
        $this->realisateur = $realisateur;
        $this->genre->ajouterFilm($this);
        $this->realisateur->ajouterFilm($this);
        $this->castings = [];
    }

    public function getTitre() {
        return $this->titre;
    }
    
    public function getDateSortie() {
        return $this->dateSortie;
    }

    public function getDuree() {
        return date("H:i", $this->duree * 60);
    }

    public function getSynopsis() {
        return $this->synopsis;
    }

    public function getCastings() {
        return $this->castings;
    }

    public function ajouterCasting(Casting $casting) {
        $this->castings[] = $casting;
    }

    public function afficherCasting() {
        $result = "<h1>Casting de $this</h1>";
        foreach ($this->castings as $casting) {
            $result .= $casting->getActeur()." (". $casting->getRole().")<br>";
        }
        return $result;
    }

    public function __toString() {
        return $this->titre;
    }
}