<?php
require "../utils/dbconnexion.php";
require "../utils/clean_inp.php";
require "../models/Command.php";
class ComandController
{
    public static function getAllCommands()
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * FROM commande";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function addCommend(Command $command)
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "INSERT INTO commande values (:cmd_red,:img_url ,:d, :qt)";
        $stm = $conn->prepare($sql);

        $cmd_ref = $command->getCommandRef();
        $cmd_img = $command->getImgUrl();
        $qt = $command->getQt();
        $date = $command->getDate();

        $stm->bindParam(":cmd_red", $cmd_ref);
        $stm->bindParam(":img_url", $cmd_img);
        $stm->bindParam(":qt", $qt);
        $stm->bindParam(":d", $date);

        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }
}
?>