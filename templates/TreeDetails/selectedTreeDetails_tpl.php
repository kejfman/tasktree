<?php

/**
 * Formularz - Szczegóły wybranego drzewa zadań
 * WYKRES
 * 
 */
require_once '../../entryPoint.php';
require_once '../../class/Tree.php';

// Pobieranie informacji o wybranym drzewie zadań
if (isset($_GET['treeID'])) {
    $treeID = explode("^", $_GET['treeID']);
    $treeID = $treeID[0];
    $treeDetails = Tree::getTreeDetails($db_connect, $treeID);
}

/**
 * Przygotowanie danych do wykresu
 */
$treeChart = Tree::getTreeChart($db_connect, $treeID);
?>

<!-- CZĘŚĆ GRAFICZNA -->

<div class="shadow-lg card border border-primary">
    <div class="card-header bg-light text-center">
        <font size="5" class="text-dark" id="selectedTreeName"><?= $treeDetails['TreeName'] ?></font>
    </div>
    <div class="card-body" style="height: 280px;">
        <canvas id="TreeChart"></canvas>
    </div>
</div>

<input id="selectedTreeID" type="text" value="<?= $treeID ?>" hidden />

<!-- JavaScript - obsługa/wykres -->

<script>
    var ctx = null;
    var chart = null;
    var config = null;
    ctx = document.getElementById('TreeChart').getContext('2d');
    config = {
        type: 'doughnut',
        data: {
            datasets: [{
                    data: [
                        <?= $treeChart['doneTasks'] ?>,
                        <?= $treeChart['notDoneTasks'] ?>
                    ],
                    backgroundColor: [
                        'MediumSeaGreen',
                        'lightgray'
                    ],
                    label: 'Wszystkie zadania'
                },
                {
                    data: [
                        <?= $treeChart['myDoneTasks'] ?>,
                        <?= $treeChart['myNotDoneTasks'] ?>
                    ],
                    backgroundColor: [
                        'MediumSeaGreen',
                        'lightgray'
                    ],
                    label: 'Moje zadania'
                }
            ],
            labels: [
                "Zamknięte",
                "Otwarte",
            ]
        },
        options: {
            // rotation: 1 * Math.PI,
            // circumference: 1 * Math.PI,
            responsive: true,
            legend: {
                position: 'right',
            },

            animation: {
                animateScale: false,
                animateRotate: true
            },
            tooltips: {
                callbacks: {
                    label: function(item, data) {
                        console.log(data.labels, item);
                        return data.datasets[item.datasetIndex].label + ": " + data.labels[item.index] + ": " + data.datasets[item.datasetIndex].data[item.index];
                    }
                }
            }
        }
    };
    chart = new Chart(ctx, config);
</script>