<?php

class Personne {
    
    private string $prenom;
    private string $nom;
    private string $sexe;
    private DateTime $dateNaissance;

    public function __construct(string $prenom, string $nom, string $sexe, string $dateNaissance) {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->sexe = $sexe;
        $this->dateNaissance = new DateTime($dateNaissance);
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getSexe() {
        return $this->sexe;
    }

    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    public function __toString() {
        return $this->prenom." ".$this->nom;
    }
}