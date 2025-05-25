<?php
require "../utils/dbconnexion.php";
require "../utils/clean_inp.php";
require "../models/Of.php";
class OfController
{
    public static function addOf(Of $of)
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();
        $sql = "INSERT into OF values (:of_id, :qt , :of_ref, :variant, :cmd_id)";

        $stm = $conn->prepare($sql);

        $of_id = $of->getOfId();
        $qt = $of->getQt();
        $of_ref = $of->getOfRef();
        $variant = $of->getVariant();
        $cmd_id = $of->getCmdId();

        $stm->bindParam(":of_id", $of_id);
        $stm->bindParam(":qt", $qt);
        $stm->bindParam(":of_ref", $of_ref);
        $stm->bindParam(":variant", $variant);
        $stm->bindParam(":cmd_id", $cmd_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function getAllOfs($cmdId)
    {
        $cmdId = Clean_input($cmdId);
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * from OF where commande_id = :cmd_id";

        $stm = $conn->prepare($sql);
        $stm->bindParam(":cmd_id", $cmdId);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

}
?>