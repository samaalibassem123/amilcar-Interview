<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once "../models/Command.php";
    include_once "../models/Of.php";
    include_once "../models/Qtsize.php";
    include_once "../models/Tissues.php";

    include_once "../controllers/ComandController.php";
    include_once "../controllers/OfController.php";
    include_once "../controllers/QtsizeController.php";
    include_once "../controllers/TissuesController.php";

    //Get all the command
    $commands = ComandController::getAllCommands();


    //Filter Commands 
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
        $of_id = $_GET["ofid"];
        $refcmd = $_GET["refcmd"];
        //Filter By OF ID
        if ($of_id) {
            //first we need to find cmd ref of the ofid
            $OF = OfController::getOf($of_id);
            if ($OF != null) {
                $cmd_id = $OF["commande_id"];

                $commands = array_filter($commands, function ($cmd) use ($cmd_id) {
                    return $cmd["comande_ref"] === $cmd_id;
                });
            } else {
                $commands = array();

            }
        }
        //Filter By Ref command
        if ($refcmd) {
            $commands = array_filter($commands, function ($cmd) use ($refcmd) {
                return $cmd["comande_ref"] === $refcmd;
            });
        }
        if (!$refcmd && !$of_id) {
            $commands = array();
        }
    }
    //reset button
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["reset"])) {
        $commands = ComandController::getAllCommands();

    }


    ?>


</head>

<body class="flex flex-row items-center">
    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <h4 class="text-white">SYSTÈME COUPE - AMILCAR TECHNOLOGIES</h4>

            <!-- Plan de Coupe with dropdown -->
            <div class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#planDeCoupeSub" role="button" aria-expanded="false"
                    aria-controls="planDeCoupeSub">
                    <i class="bi bi-scissors"></i> Plan de Coupe
                    <i class="bi bi-caret-down ms-auto"></i>
                </a>
                <div class="collapse ps-3" id="planDeCoupeSub">
                    <a class="nav-link" href="/liste-plans.html">Liste des plans</a>
                    <a class="nav-link" href="/saisie-plan.html">Saisie plan de coupe</a>
                </div>
            </div>

            <!-- Other navigation items -->
            <a class="nav-link" href="/fiche-matelassage.html"><i class="bi bi-gear"></i> Fiche matelassage</a>
            <a class="nav-link" href="/eclatement.html"><i class="bi bi-box"></i> Eclatement des packets</a>

            <div class="nav-item">
                <a class="nav-link active" data-bs-toggle="collapse" href="#pvSub" role="button" aria-expanded="false"
                    aria-controls="pvSub">
                    <i class="bi bi-bar-chart"></i> PV de coupe
                    <i class="bi bi-caret-down ms-auto"></i>
                </a>
                <div class="collapse ps-3" id="pvSub">
                    <a class="nav-link active" href="pv-coupe.php">Saisie d'un PV de coupe</a>
                    <a class="nav-link" href="liste_pv_coupe.php">Liste des PV de coupe</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <form method="get">
                <div>
                    <label for="">OF id : </label>
                    <input type="text" name="ofid" id="">
                </div>
                <div>
                    <label for="">Référence commande : </label>
                    <input type="text" name="refcmd" id="">
                </div>
                <button type="submit" name="search">Search</button>
                <button type="submit" name="reset">Reset</button>
            </form>
            <?php
            foreach ($commands as $cmd) {
                //GET ofs
                $ofs = OfController::getAllOfs($cmd["comande_ref"]);

                ?>

            <div class="commande">
                <div>
                    <img src="<?php echo $cmd["photo_url"]; ?>" alt="">
                    <div>date de commande : <?php echo $cmd["date_env"]; ?></div>
                    <div>ref de commande : <?php echo $cmd["comande_ref"]; ?> </div>
                    <p>quanity: <?php echo $cmd["quantity"]; ?></p>
                </div>
                <hr>
                <div class="section1">
                    <!--OF-->
                    <?php
                        foreach ($ofs as $of) {
                            //GET tisuue
                            $tissue = TissuesController::getTissue($of["of_id"]);
                            //GET Qt per size
                            $qt_size = QtsizeController::getAllQtsize($tissue["tissu_ref"]);

                            ?>
                    <div>
                        <p>OF id: <span style=" font-weight: normal;"><?php echo $of["of_id"]; ?></span></p>
                        <p>OF ref: <span style=" font-weight: normal;"><?php echo $of["of_ref"]; ?></span></p>
                        <p>OF quantity: <span style=" font-weight: normal;"><?php echo $of["quantity"]; ?></span></p>
                        <p>OF variant: <span style=" font-weight: normal;"><?php echo $of["variant"]; ?></span></p>
                        <!--TISSUES-->
                        <hr>
                        <div>
                            <p>tissu_ref : <span style=" font-weight: normal;"><?php echo $tissue["tissu_ref"]; ?></p>
                            <p>ref emp1 : <span style=" font-weight: normal;"><?php echo $tissue["ref_emp1"]; ?></p>
                            <p>ref emp2 : <span style=" font-weight: normal;"><?php echo $tissue["ref_emp2"]; ?></p>
                            <p>ref doublur: <span style=" font-weight: normal;"><?php echo $tissue["ref_doublur"]; ?>
                            </p>
                            <p>tissu recu: <span style=" font-weight: normal;"><?php echo $tissue["tissu_recu"]; ?></p>
                            <p>tissu consom: <span style=" font-weight: normal;"><?php echo $tissue["tissu_consom"]; ?>
                            </p>
                            <p>reste tissu: <span style=" font-weight: normal;"><?php echo $tissue["reste_tissu"]; ?>
                            </p>
                            <p>Comment: <span style=" font-weight: normal;"><?php echo $tissue["comment"]; ?></p>
                        </div>
                        <?php
                                foreach ($qt_size as $qs) {

                                    ?>
                        <hr>
                        <!--Quantity per size-->
                        <div>
                            quantity per size:
                            <p>Taille : <span style=" font-weight: normal;"><?php echo $qs["taille"]; ?></p>
                            <p>commande : <span style=" font-weight: normal;"><?php echo $qs["commande"]; ?></p>
                            <p>coupe : <span style=" font-weight: normal;"><?php echo $qs["coupe"]; ?></p>
                            <p>controle : <span style=" font-weight: normal;"><?php echo $qs["controle"]; ?></p>
                            <p>ecart: <span style=" font-weight: normal;"><?php echo $qs["ecart"]; ?> </p>
                        </div>
                        <?php
                                }

                                ?>
                    </div>
                    <?php
                        }
                        ?>

                </div>


            </div>
            <?php
            }
            ?>

        </div>



    </div>
    </div>

    </div>


</body>

<style>
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
}

.commande {
    border: 1px solid gray;
    border-radius: 10px;
    margin: 5px;
    padding: 10px;
    font-weight: bold;
}

.commande>.section1 {
    display: flex;
    width: 100%;
    gap: 20px;
}


.wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    background-color: #212529;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 1000;
    overflow-y: auto;
}

.sidebar h4 {
    padding: 1rem;
    margin: 0;
    background-color: #343a40;
    text-align: center;
}

.sidebar .nav-link {
    color: #ced4da;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #495057;
    display: block;
}

.sidebar .nav-link:hover {
    background-color: #495057;
    color: white;
    text-decoration: none;
}

.content {
    margin-left: 250px;
    flex-grow: 1;
    padding: 2rem;
    width: calc(100% - 250px);
    position: relative;
}

.title-header {
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    color: #0d6efd;
    letter-spacing: 1px;
}

.titling-table input[type="text"] {
    width: 100%;
    padding: 0.4rem;
    box-sizing: border-box;
}

.table td {
    vertical-align: middle;
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        width: 200px;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .content {
        margin-left: 200px;
        padding: 1rem;
        width: calc(100% - 200px);
    }
}

.table input.form-control-sm {
    min-width: 100px;
    height: 38px;
    font-size: 1rem;
    padding: 0.375rem 0.75rem;
}

.table thead th {
    background-color: #f0f4f8;
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d1dbe5;
}

.table td,
.table th {
    vertical-align: middle;
    padding: 8px 12px;
}

.table input.form-control-sm {
    font-size: 13px;
}

.table.styled-first-col td:first-child,
.table.styled-first-col th:first-child {
    background-color: #f0f4f8;
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d1dbe5;
}

.sidebar .nav-link.active {
    background-color: #2c3e50;
    color: #ffffff;
    font-weight: bold;
    border-left: 4px solid #0d6efd;
}

.sidebar .collapse .nav-link {
    font-size: 0.9rem;
    color: #cbd5e0;
}

.sidebar .collapse .nav-link:hover {
    color: #ffffff;
}

.of-section {
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    background-color: #f8f9fa;
}

.of-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
}

.remove-of {
    color: #dc3545;
    cursor: pointer;
    font-size: 1.2rem;
}

.remove-of:hover {
    color: #c82333;
}
</style>

</html>