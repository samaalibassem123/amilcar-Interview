<?php

include_once "../utils/clean_inp.php";

class Of
{
    private $of_id;
    private $qt;
    private $of_ref;
    private $variant;

    //Foreing key
    private $cmd_id;


    public function __construct($of_id, $qt, $of_ref, $variant, $cmd_id)
    {
        $this->of_id = Clean_input($of_id);
        $this->qt = Clean_input($qt);
        $this->of_ref = Clean_input($of_ref);
        $this->variant = Clean_input($variant);
        $this->cmd_id = Clean_input($cmd_id);
    }

    //Getters and setters
    public function getOfId(): string
    {
        return $this->of_id;
    }

    public function setOfId($of_id)
    {
        $this->of_id = Clean_input($of_id);
    }

    public function getQt(): string
    {
        return $this->qt;
    }

    public function setQt($qt)
    {
        $this->qt = Clean_input($qt);
    }

    public function getOfRef(): string
    {
        return $this->of_ref;
    }

    public function setOfRef($of_ref)
    {
        $this->of_ref = Clean_input($of_ref);
    }

    public function getVariant(): string
    {
        return $this->variant;
    }

    public function setVariant($variant)
    {
        $this->variant = Clean_input($variant);
    }

    public function getCmdId(): string
    {
        return $this->cmd_id;
    }

    public function setCmdId($cmd_id)
    {
        $this->cmd_id = Clean_input($cmd_id);
    }



}
?>