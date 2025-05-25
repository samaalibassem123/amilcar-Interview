<?php
require "../utils/dbconnexion.php";
require "../utils/clean_inp.php";
require "../models/Tissues.php";
class TissuesController
{
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
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }

    }
}
?>