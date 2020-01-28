<?php
require 'connect.php';
?>
<a style="margin-left: 45vw;" href="index.php">Revenir à la page précédente</a>
<?php
$eleve1 = "SELECT eleves.id, nom, prenom,titre,niveau,niveau_ae FROM eleves
LEFT JOIN eleves_competences AS e_comp ON e_comp.eleves_id = eleves.id
LEFT JOIN competences ON competences.id = e_comp.competences_id
WHERE eleves.id = " . $_GET["id"];

$result1 = $conn->query($eleve1);

while($row = $result1->fetch_assoc())
{
    echo "<br>".$row['nom']. " " .$row['prenom']. " " . $row['titre'].": ".$row['niveau'].", ".$row['niveau_ae']."<br>";
}

?>

<html>

<head>
    <title>Radar</title>

    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<body>
<div style="width:70%">
    <canvas id="canvas"></canvas>
</div>
<script src="Chart.js"></script>
<?php

$competences = [];
$niveau = [];
$niveau_ae = [];


$comp_eleves = "SELECT * FROM eleves
    LEFT JOIN eleves_competences AS e_c ON eleves.id = e_c.eleves.id
    LEFT JOIN competences AS comp ON e_c.competence_id = comp.id
    WHERE eleves.id=" . $_GET['id'] . " ORDER BY eleves.id";

$result = $conn->query($comp_eleves);

while ($row = $result->fetch_assoc()) {
    $competences[] = $row["titre"];
    $niveau[] = $row["niveau"];
    $niveau_ae[] = $row["niveau_ae"];
    echo "<br>" . $row["nom"] . ", " . $row["prenom"] . "<br> Competences : " . $row["titre"] . ", niveau : " . $row["niveau"] . ", auto-evalue : " . $row["niveau_ae"];
    echo $conn->error;

}
?>

<script>

    var niveau = [<?php echo "'".implode("','",$niveau)."'" ?>];
    var competences = [<?php echo "'".implode("','",$competences)."'" ?>];
    var niveau_ae = [<?php echo "'".implode("','",$niveau_ae)."'" ?>];

    var config = {
        type: 'radar',
        data: {
            labels: competences,
            datasets: [{
                label: 'niveau',
                borderColor: "rgba(224,91,50)",
                backgroundColor: "rgba(224,91,50,0.5)",
                pointBackgroundColor: "rgba(224,91,50)",
                data: niveau
            }, {
                label: 'niveau_ae',
                borderColor: "rgba(50,97,224)",
                backgroundColor: "rgba(50,97,224,0.5)",
                pointBackgroundColor: "rgba(50,97,224)",
                data: niveau_ae
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Comparateur des compétences'
            },
            elements: {
                line: {
                    tension: 0.0,
                }
            },
            scale: {
                beginAtZero: true,
            }
        }
    };

    window.onload = function() {
        window.myRadar = new Chart(document.getElementById('canvas'), config);
    };


</script>

</body>


</html>

