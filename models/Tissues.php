<?php

include_once "../utils/clean_inp.php";


class Tissues
{
    private $of_id;
    private $tissu_ref;
    private $ref_emp1;
    private $ref_emp2;
    private $ref_doublur;
    private $tissu_recu;
    private $tissu_consom;
    private $reste_tissu;
    private $comment;

    // Constructor
    public function __construct($of_id, $tissu_ref, $ref_emp1, $ref_emp2, $ref_doublur, $tissu_recu, $tissu_consom, $reste_tissu, $comment)
    {
        $this->of_id = Clean_input($of_id);
        $this->tissu_ref = Clean_input($tissu_ref);
        $this->ref_emp1 = Clean_input($ref_emp1);
        $this->ref_emp2 = Clean_input($ref_emp2);
        $this->ref_doublur = Clean_input($ref_doublur);
        $this->tissu_recu = Clean_input($tissu_recu);
        $this->tissu_consom = Clean_input($tissu_consom);
        $this->reste_tissu = Clean_input($reste_tissu);
        $this->comment = Clean_input($comment);
    }

    // Getters and Setters
    public function getOfId()
    {
        return $this->of_id;
    }

    public function setOfId($of_id)
    {
        $this->of_id = Clean_input($of_id);
    }

    public function getTissuRef()
    {
        return $this->tissu_ref;
    }

    public function setTissuRef($tissu_ref)
    {
        $this->tissu_ref = Clean_input($tissu_ref);
    }

    public function getRefEmp1()
    {
        return $this->ref_emp1;
    }

    public function setRefEmp1($ref_emp1)
    {
        $this->ref_emp1 = Clean_input($ref_emp1);
    }

    public function getRefEmp2()
    {
        return $this->ref_emp2;
    }

    public function setRefEmp2($ref_emp2)
    {
        $this->ref_emp2 = Clean_input($ref_emp2);
    }

    public function getRefDoublur()
    {
        return $this->ref_doublur;
    }

    public function setRefDoublur($ref_doublur)
    {
        $this->ref_doublur = Clean_input($ref_doublur);
    }

    public function getTissuRecu()
    {
        return $this->tissu_recu;
    }

    public function setTissuRecu($tissu_recu)
    {
        $this->tissu_recu = Clean_input($tissu_recu);
    }

    public function getTissuConsom()
    {
        return $this->tissu_consom;
    }

    public function setTissuConsom($tissu_consom)
    {
        $this->tissu_consom = Clean_input($tissu_consom);
    }

    public function getResteTissu()
    {
        return $this->reste_tissu;
    }

    public function setResteTissu($reste_tissu)
    {
        $this->reste_tissu = Clean_input($reste_tissu);
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = Clean_input($comment);
    }


}



?>