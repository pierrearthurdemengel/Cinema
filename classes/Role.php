<?php

class Role {
    
    private string $nomRole;
    private array $castings;

    public function __construct(string $nomRole) {
        $this->nomRole = $nomRole;
        $this->castings = [];
    }

    public function getNomRole() {
        return $this->nomRole;
    }

    public function getCastings() {
        return $this->castings;
    }

    public function ajouterCasting(Casting $casting) {
        $this->castings[] = $casting;
    }

    public function afficherCasting() {
        $result = "<h1>Acteurs ayant incarné $this</h1>";
        foreach ($this->castings as $casting) {
            $result .= $casting->getActeur()." (". $casting->getFilm().")<br>";
        }
        return $result;
    }

    public function __toString() {
        return $this->nomRole;
    }
}