<?php
require_once "../utils/dbconnexion.php";
require_once "../utils/clean_inp.php";
require_once "../models/Tissues.php";
class TissuesController
{
    public static function ValidTissues(Tissues $tissue)
    {
        $tiss = self::getTissueById($tissue->getTissuRef());
        if ($tiss != null) {

            $msg = "Tissue Ref " . $tissue->getTissuRef() . " Aready used";
            return [false, $msg];

        } elseif ($tissue->getTissuConsom() > $tissue->getTissuRecu()) {

            $msg = "You can't consume more than " . $tissue->getTissuRecu() . " in Détails Tissu de l'OF" . $tissue->getTissuRef();
            return [false, $msg];
        }
        return [true, ""];
    }

    public static function getTissueById($tiss_id)
    {
        $tiss_id = Clean_input($tiss_id);

        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * FROM tissues where tissu_ref = :tiss_id";
        $stm = $conn->prepare($sql);
        $stm->bindParam(":tiss_id", $tiss_id);

        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);


        if (is_array($data)) {
            return $data;
        }
        return null;

    }

    public static function getTissue($ofId)
    {
        $ofId = Clean_input($ofId);

        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "SELECT * from tissues where OF_id = :ofid";
        $stm = $conn->prepare($sql);
        $stm->bindParam(":ofid", $ofId);
        $stm->execute();
        $data = $stm->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public static function addTissue(Tissues $tissues)
    {
        $database = new Dbconnexion();
        $conn = $database->getConnection();

        $sql = "INSERT into tissues values(:ofid, :tissref, :refemp1, :refemp2, :refdoublue, :tissurecu, :tissucon, :reste, :comment)";

        $stm = $conn->prepare($sql);

        $ofid = $tissues->getOfId();
        $tissref = $tissues->getTissuRef();
        $refemp1 = $tissues->getRefEmp1();
        $refemp2 = $tissues->getRefEmp2();
        $refdoublue = $tissues->getRefDoublur();
        $tissurecu = $tissues->getTissuRecu();
        $tissucon = $tissues->getTissuConsom();
        $reste = $tissues->getResteTissu();
        $comment = $tissues->getComment();

        $stm->bindParam(":ofid", $ofid);
        $stm->bindParam(":tissref", $tissref);
        $stm->bindParam(":refemp1", $refemp1);
        $stm->bindParam(":refemp2", $refemp2);
        $stm->bindParam(":refdoublue", $refdoublue);
        $stm->bindParam(":tissurecu", $tissurecu);
        $stm->bindParam(":tissucon", $tissucon);
        $stm->bindParam(":reste", $reste);
        $stm->bindParam(":comment", $comment);

        try {
            $stm->execute();
            return [true, ""];
        } catch (Exception $e) {
            return [false, $e];
        }

    }
}
?>