<?php
require_once "../utils/dbconnexion.php";
require_once "../utils/clean_inp.php";
require_once "../models/Qtsize.php";
class QtsizeController
{
    public static function getAllQtsize($tiss_id)
    {
        $tiss_id = Clean_input($tiss_id);

        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * from quantity_size where tissue_id=:tissid";

        $stm = $conn->prepare($sql);
        $stm->bindParam(":tissid", $tiss_id);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function addQtsize(Qtsize $qtsize)
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "INSERT INTO quantity_size (commande, coupe,controle,ecart,taille,tissue_id) values (:command, :coupe, :controle, :ecart, :taille, :tissueid)";
        $stm = $conn->prepare($sql);

        $command = $qtsize->getCommande();
        $coupe = $qtsize->getCoupe();
        $controle = $qtsize->getControle();
        $ecart = $qtsize->getEcart();
        $taille = $qtsize->getTaille();
        $tissueid = $qtsize->getTissueId();


        $stm->bindParam(":command", $command);
        $stm->bindParam(":coupe", $coupe);
        $stm->bindParam(":controle", $controle);
        $stm->bindParam(":ecart", $ecart);
        $stm->bindParam(":taille", $taille);
        $stm->bindParam(":tissueid", $tissueid);
        try {
            $stm->execute();
        } catch (Exception $e) {
            echo "<script>alert('" . $e . "')</script>";
        }


    }
}
?>