<?php

require "../utils/clean_inp.php";
class Qtsize
{
    private $qt_id;
    private $commande;
    private $coupe;
    private $controle;
    private $ecart;
    private $taille;
    private $tissue_id;

    // Constructor
    public function __construct($qt_id, $commande, $coupe, $controle, $ecart, $taille, $tissue_id)
    {
        $this->qt_id = Clean_input($qt_id);
        $this->commande = Clean_input($commande);
        $this->coupe = Clean_input($coupe);
        $this->controle = Clean_input($controle);
        $this->ecart = Clean_input($ecart);
        $this->taille = Clean_input($taille);
        $this->tissue_id = Clean_input($tissue_id);
    }

    // Getters and Setters

    public function getQtId()
    {
        return $this->qt_id;
    }

    public function setQtId($qt_id)
    {
        $this->qt_id = Clean_input($qt_id);
    }

    public function getCommande()
    {
        return $this->commande;
    }

    public function setCommande($commande)
    {
        $this->commande = Clean_input($commande);
    }

    public function getCoupe()
    {
        return $this->coupe;
    }

    public function setCoupe($coupe)
    {
        $this->coupe = Clean_input($coupe);
    }

    public function getControle()
    {
        return $this->controle;
    }

    public function setControle($controle)
    {
        $this->controle = Clean_input($controle);
    }

    public function getEcart()
    {
        return $this->ecart;
    }

    public function setEcart($ecart)
    {
        $this->ecart = Clean_input($ecart);
    }

    public function getTaille()
    {
        return $this->taille;
    }

    public function setTaille($taille)
    {
        $this->taille = Clean_input($taille);
    }

    public function getTissueId()
    {
        return $this->tissue_id;
    }

    public function setTissueId($tissue_id)
    {
        $this->tissue_id = Clean_input($tissue_id);
    }



}
?>