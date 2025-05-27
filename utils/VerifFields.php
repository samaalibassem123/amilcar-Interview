<?php

$command_id = $_POST["reference"];
$command = new Command($command_id, $_POST["photo"], $_POST["quantite"], $_POST["date_envoi"]);
$of_table = $_POST["of"];
if (!ComandController::validCommand($command)) {
    $errors .= "Commande ref is already exist";
} else {

    for ($i = 0; $i < sizeof($of_table); $i++) {
        //GET OF (ORDRE DE FABRICATION)
        $of_n = $of_table[$i];
        $of_qt = $_POST["qteof"][$i];
        $of_ref = $_POST["refof"][$i];
        $of_var = $_POST["varof"][$i];

        $of = new Of($of_n, $of_qt, $of_ref, $of_var, $command_id);
        //Valid the OF fields
        if (!OfController::ValidOf($of)) {
            $errors .= "<br/> Dublicate OF_n  " . $of->getOfId();
            break;
        }

        //GET TISSUES
        $tiss_ref = $_POST["ref_tissu"][$i];
        $ref_emp1 = $_POST["ref_emp1"][$i];
        $ref_emp2 = $_POST["ref_emp2"][$i];
        $ref_doublure = $_POST["ref_doublure"][$i];
        $tissu_recu = $_POST["tissu_recu"][$i];
        $tissu_cons = $_POST["tissu_cons"][$i];
        $reste_tissu = $_POST["reste_tissu"][$i];
        $commentaire = $_POST["commentaire"][$i];

        $tissue = new Tissues($of_n, $tiss_ref, $ref_emp1, $ref_emp2, $ref_doublure, $tiss_ref, $tissu_cons, $reste_tissu, $commentaire);
        //Vaild the tissues fields
        list($status, $e) = TissuesController::ValidTissues($tissue);
        if ($status == false) {//Invalid fileds
            $errors .= "<br/>" . $e;
            break;
        }

        //verify quantity per size fields
        $qt_commanded = $_POST["total_commande"][$i];
        $total_coupe = $_POST["total_coupe"][$i];
        $total_controle = $_POST["total_controle"][$i];

        if ($qt_commanded > $tissu_recu) {
            $errors .= "<br/> Total commandé must be <=" . $tissu_recu;
        }
        if ($total_coupe > $tissu_cons) {
            $errors .= "<br/> Total coupé must be <=" . $tissu_recu;
        }
        if ($total_controle > $tissu_recu) {
            $errors .= "<br/> Total contolé must be <=" . $tissu_recu;
        }





    }
}
?>