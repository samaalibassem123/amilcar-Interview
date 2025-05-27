<?php
require_once "../utils/dbconnexion.php";
require_once "../utils/clean_inp.php";
require_once "../models/Command.php";
class ComandController
{
    public static function validCommand(Command $command): bool
    {
        $cmd = self::getCommandById($command->getCommandRef());
        if ($cmd == null) {
            return true;
        }
        return false;
    }

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

    public static function getCommandById($commandId)
    {
        $commandId = Clean_input($commandId);

        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * FROM commande where comande_ref = :commandid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(":commandid", $commandId);

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        if (is_array($data)) {
            return $data;
        }
        return null;

    }

    public static function addCommend(Command $command)
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        //First we need to check if it is already exist 
        $cmd = self::getCommandById($command->getCommandRef());


        if ($cmd != null) {
            return false;
        }

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
            echo "<script>alert(" . $e . ")</script>";
            return false;
        }
    }
}
?>