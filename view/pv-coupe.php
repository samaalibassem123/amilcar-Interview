<!DOCTYPE html>
<html lang="fr">

<head>
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

  $errors = "";
  $succeed = false;

  //PHP LOGIC
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once "../utils/VerifFields.php";
    //AT THE END IF THERE IS NO ERROR WE INSERT IT ALL TO DB
    if (!$errors) {
      // 1 . Add Command
      ComandController::addCommend($command);
      // 2 . Add Others
      for ($i = 0; $i < sizeof($of_table); $i++) {

        $of_n = $of_table[$i];
        $of_qt = $_POST["qteof"][$i];
        $of_ref = $_POST["refof"][$i];
        $of_var = $_POST["varof"][$i];
        $of = new Of($of_n, $of_qt, $of_ref, $of_var, $command_id);

        [$status_of, $e] = OfController::addOf($of);

        if ($status_of == true) {
          //IF THE OF IS INSERTED NOW WE CAN INSERT THE TISSUES
          $tiss_ref = $_POST["ref_tissu"][$i];
          $ref_emp1 = $_POST["ref_emp1"][$i];
          $ref_emp2 = $_POST["ref_emp2"][$i];
          $ref_doublure = $_POST["ref_doublure"][$i];
          $tissu_recu = $_POST["tissu_recu"][$i];
          $tissu_cons = $_POST["tissu_cons"][$i];
          $reste_tissu = $_POST["reste_tissu"][$i];
          $commentaire = $_POST["commentaire"][$i];

          $tissue = new Tissues($of_n, $tiss_ref, $ref_emp1, $ref_emp2, $ref_doublure, $tiss_ref, $tissu_cons, $reste_tissu, $commentaire);
          [$status_tiss, $e_tiss] = TissuesController::addTissue($tissue);
          if ($status_tiss == true) {
            //now we can insert qt taille
            for ($n = 0; $n < 7; $n++) {

              $taille = $_POST["taille_" . $n][$i];
              $commande = $_POST["commande_" . $n][$i];
              $controle = $_POST["controle_" . $n][$i];
              $ecart = $_POST["ecart_" . $n][$i];
              $coupe = $_POST["coupe_" . $n][$i];

              $qtsize = new Qtsize($commande, $coupe, $controle, $ecart, $taille, $tiss_ref);
              QtsizeController::addQtsize($qtsize);
            }
          } else {
            echo "<script>alert('" . $e_tiss . "')</script>";
          }


        } else {
          echo "<script>alert('" . $e . "')</script>";
        }
      }
      $succeed = true;
    }
  }


  ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saisie PV de coupe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body>
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

        <!--COUPE OR COMMAND FORM-->
        <div class="content">
            <div class="title-header">Saisie d'un PV DE COUPE</div>
            <?php
      if ($errors) {
        echo "<p style=' background-color: pink; color: red; padding: 10px;'>" . $errors . "</p>";
      }
      if ($succeed) {
        echo "<p style=' background-color: green; color: white; padding: 10px;'>Added Succefuly</p>";
      }
      ?>

            <form id="mainForm" method="post">
                <div class="form-group">
                    <label for="photo">Photo :</label>
                    <input type="file" class="form-control" id="photo" name="photo" />
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="reference">Référence commande :</label>
                        <input type="text" class="form-control" id="reference" name="reference" required />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="quantite">Quantité :</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" required min="0" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="date_envoi">Date Envoi PV :</label>
                        <input type="date" class="form-control" id="date_envoi" name="date_envoi" required />
                    </div>
                </div>

                <hr />

                <!-- Container for all OF sections -->
                <div id="ofSectionsContainer">
                    <!-- First OF section will be added here by default -->
                </div>

                <!-- Button to add new OF section -->
                <div class="text-center mb-4">
                    <button type="button" id="addOfButton" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter un autre OF
                    </button>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-success" onclick="window.print()">
                        Imprimer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="window.print()">
                        Envoyer par Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Template for new OF sections (hidden) -->
    <div id="ofTemplate" style="display: none">
        <div class="of-section" style="
          background-color: #f0f2f5;
          border-left: 4px solid #0d6efd;
          margin-bottom: 25px;
        ">
            <div class="of-header" style="
            background-color: #e9ecef;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
          ">
                <h5 style="margin: 0; color: #495057">
                    OF : <span class="of-number"></span>
                </h5>
                <i class="bi bi-x-circle remove-of" title="Supprimer cet OF"
                    style="font-size: 1.5rem; color: #dc3545"></i>
            </div>

            <div style="padding: 15px">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>OF N° :</label>
                        <input type="text" class="form-control of-input" name="of[]" required />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Quantité de l'OF:</label>
                        <input type="number" class="form-control qteof-input" name="qteof[]" required min="0" />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Référence de l'OF:</label>
                        <input type="text" class="form-control qteof-input" name="refof[]" required />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Variant de l'OF:</label>
                        <input type="text" class="form-control qteof-input" name="varof[]" required />
                    </div>
                </div>

                <hr style="border-top: 1px solid #ced4da" />

                <h5 style="color: #495057">Détails Tissu de l'OF</h5>
                <!--TISSUE FORM-->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Réf. Tissu</label>
                        <input type="text" class="form-control" name="ref_tissu[]" required />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Réf. Emp 1</label>
                        <input type="text" class="form-control" name="ref_emp1[]" required />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Réf. Emp 2</label>
                        <input type="text" class="form-control" name="ref_emp2[]" required />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Réf. Doublure</label>
                        <input type="text" class="form-control" name="ref_doublure[]" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tissu Reçu</label>
                        <input type="number" step="0.01" class="form-control tissu-recu-input" name="tissu_recu[]"
                            required />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tissu Consommé</label>
                        <input type="number" step="0.01" class="form-control tissu-cons-input" name="tissu_cons[]"
                            required />
                    </div>
                    <div class="form-group col-md-4">
                        <label>Reste Tissu</label>
                        <input type="number" step="0.01" class="form-control reste-tissu-input" name="reste_tissu[]"
                            readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label>Commentaire</label>
                    <textarea class="form-control" name="commentaire[]" rows="3"></textarea>
                </div>

                <hr style="border-top: 1px solid #ced4da" />

                <h5>Quantité par Taille</h5>
                <!--QUANTITY PER SIZE FORM-->
                <table class="table table-bordered styled-first-col">
                    <thead>
                        <tr>
                            <th>Taille</th>
                            <th>Commandé</th>
                            <th>Coupé</th>
                            <th>Contrôle</th>
                            <th>Écart</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_0[]"
                                    value="2XS - 34" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_0[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_0[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_0[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_0[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_1[]"
                                    value="XS - 36" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_1[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_1[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_1[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_1[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_2[]"
                                    value="S - 38" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_2[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_2[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_2[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_2[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_3[]"
                                    value="M - 40" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_3[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_3[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_3[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_3[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_4[]"
                                    value="L - 42" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_4[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_4[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_4[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_4[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_5[]"
                                    value="XL - 44" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_5[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_5[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_5[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_5[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="taille_6[]"
                                    value="XXL - 46" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm commande-input"
                                    name="commande_6[]" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm coupe-input" name="coupe_6[]"
                                    min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm controle-input"
                                    name="controle_6[]" value="0" min="0" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm ecart-input" name="ecart_6[]"
                                    value="0" readonly />
                            </td>
                        </tr>
                        <!-- Total row -->
                        <tr class="total-row" style="font-weight: bold; background-color: #f8f9fa">
                            <td>Total</td>
                            <td>
                                <input type="number" class="form-control form-control-sm total-commande" value="0"
                                    readonly name="total_commande[]" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm total-coupe" value="0" readonly
                                    name="total_coupe[]" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm total-controle" value="0"
                                    readonly name="total_controle[]" />
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm total-ecart" value="0"
                                    readonly />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set today's date
        const dateInput = document.getElementById("date_envoi");
        const today = new Date().toISOString().split("T")[0];
        dateInput.value = today;

        // Add first OF section by default
        addOfSection();

        // Add OF section button
        document
            .getElementById("addOfButton")
            .addEventListener("click", addOfSection);

        // Function to add a new OF section
        function addOfSection() {
            const container = document.getElementById("ofSectionsContainer");
            const template = document.getElementById("ofTemplate");
            const newSection = template.cloneNode(true);

            newSection.id = "";
            newSection.style.display = "block";

            // Update OF number
            const ofNumber = container.children.length + 1;
            newSection.querySelector(".of-number").textContent = ofNumber;

            // Add remove functionality
            newSection
                .querySelector(".remove-of")
                .addEventListener("click", function() {
                    if (container.children.length > 1) {
                        container.removeChild(newSection);
                        // Renumber remaining OF sections
                        const sections = container.querySelectorAll(".of-section");
                        sections.forEach((section, index) => {
                            section.querySelector(".of-number").textContent = index + 1;
                        });
                    } else {
                        alert("Vous devez avoir au moins un OF.");
                    }
                });

            // Initialize calculations for this new section
            initSectionCalculations(newSection);

            container.appendChild(newSection);
        }

        // Initialize calculations for a specific section
        function initSectionCalculations(section) {
            // Table calculations
            const commandeInputs = section.querySelectorAll(".commande-input");
            const coupeInputs = section.querySelectorAll(".coupe-input");
            const controleInputs = section.querySelectorAll(".controle-input");
            const ecartInputs = section.querySelectorAll(".ecart-input");

            function calculateTable() {
                let totalCommande = 0;
                let totalCoupe = 0;
                let totalControle = 0;
                let totalEcart = 0;

                commandeInputs.forEach((input, index) => {
                    const cmd = parseInt(input.value) || 0;
                    const cut = parseInt(coupeInputs[index].value) || 0;
                    const ctrl = parseInt(controleInputs[index].value) || 0;
                    const ecart = cmd - (cut - ctrl);

                    ecartInputs[index].value = ecart;

                    totalCommande += cmd;
                    totalCoupe += cut;
                    totalControle += ctrl;
                    totalEcart += ecart;
                });

                // Update totals for this section
                const totalRow = section.querySelector(".total-row");
                if (totalRow) {
                    totalRow.querySelector(".total-commande").value = totalCommande;
                    totalRow.querySelector(".total-coupe").value = totalCoupe;
                    totalRow.querySelector(".total-controle").value = totalControle;
                    totalRow.querySelector(".total-ecart").value = totalEcart;
                }
            }

            // Fabric calculations
            const recuInputs = section.querySelectorAll(".tissu-recu-input");
            const consInputs = section.querySelectorAll(".tissu-cons-input");
            const resteInputs = section.querySelectorAll(".reste-tissu-input");

            function calculateFabric() {
                recuInputs.forEach((input, index) => {
                    const recu = parseFloat(input.value) || 0;
                    const cons = parseFloat(consInputs[index].value) || 0;
                    const reste = recu - cons;

                    resteInputs[index].value = reste.toFixed(2);
                });
            }

            // Add event listeners to this section's inputs
            section
                .querySelectorAll(".commande-input, .coupe-input, .controle-input")
                .forEach((input) => {
                    input.addEventListener("input", calculateTable);
                });

            section
                .querySelectorAll(".tissu-recu-input, .tissu-cons-input")
                .forEach((input) => {
                    input.addEventListener("input", calculateFabric);
                });

            // Initial calculations
            calculateTable();
            calculateFabric();
        }

        // Initialize calculations for existing sections (like the first one)
        document.querySelectorAll(".of-section").forEach((section) => {
            initSectionCalculations(section);
        });
    });
    </script>
    <style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>