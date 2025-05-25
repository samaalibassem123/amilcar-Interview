<?php

require "../utils/clean_inp.php";


class Command
{

    private $command_ref;
    private $img_url;
    private $quantity;
    private $d;
    public function __construct($command_ref, $img_url, $quantity, $d)
    {
        $this->command_ref = Clean_input($command_ref);
        $this->img_url = Clean_input($img_url);
        $this->quantity = Clean_input($quantity);
        $this->d = Clean_input($d);
    }
    //Getters and setters
    public function getCommandRef(): string
    {
        return $this->command_ref;
    }
    public function setCommandRef($cmdref)
    {
        $this->command_ref = Clean_input($cmdref);
    }

    public function getImgUrl(): string
    {
        return $this->img_url;
    }
    public function setImgUrl($img_url)
    {
        $this->img_url = Clean_input($img_url);
    }


    public function getQt(): string
    {
        return $this->quantity;
    }
    public function setQt($qt)
    {
        $this->quantity = Clean_input($qt);
    }

    public function getDate(): string
    {
        return $this->d;
    }
    public function setDate($d)
    {
        $this->d = Clean_input($d);
    }




}
?>