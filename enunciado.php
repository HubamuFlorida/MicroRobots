<?php
session_start();
?>
<html>
<head>
    <title>Examen 1a Evaluación</title>
</head>
<body>
    <h1>Examen 1a Evaluación</h1>
    <form method="post">
        <label for="fila_inicio">Fila de inicio (0-5):</label>
        <input type="number" id="fila_inicio" name="fila_inicio" min="0" max="5" required>
        <br>
        <label for="columna_inicio">Columna de inicio (0-5):</label>
        <input type="number" id="columna_inicio" name="columna_inicio" min="0" max="5" required>
        <br>
        <label for="fila_fin">Fila de fin (0-5):</label>
        <input type="number" id="fila_fin" name="fila_fin" min="0" max="5" required>
        <br>
        <label for="columna_fin">Columna de fin (0-5):</label>
        <input type="number" id="columna_fin" name="columna_fin" min="0" max="5" required>
        <br>
        <button type="submit">Comprobar Movimiento</button>
    </form>
    
    <?php
    /* NO HE SABIDO HACERLO DE OTRA FORMA */
    $numeros = [1, 2, 3, 4, 5, 6];
    $colores = ['RED', 'YEL', 'GRE', 'BLU', 'BLA', 'WHI'];
    $combinaciones = [];
    $tablero = [
        [[1, 'RED'], [2, 'YEL'], [3, 'GRE'], [4, 'BLU'], [5, 'BLA'], [6, 'WHI']],
        [[6, 'RED'], [5, 'YEL'], [4, 'GRE'], [3, 'BLU'], [2, 'BLA'], [1, 'WHI']],
        [[2, 'RED'], [3, 'YEL'], [4, 'GRE'], [5, 'BLU'], [6, 'BLA'], [1, 'WHI']],
        [[3, 'RED'], [4, 'YEL'], [5, 'GRE'], [6, 'BLU'], [1, 'BLA'], [2, 'WHI']],
        [[4, 'RED'], [5, 'YEL'], [6, 'GRE'], [1, 'BLU'], [2, 'BLA'], [3, 'WHI']],
        [[5, 'RED'], [6, 'YEL'], [1, 'GRE'], [2, 'BLU'], [3, 'BLA'], [4, 'WHI']]
    ];
    $_SESSION['tablero'] = $tablero;

    function tiradaPermitida($inicio, $fin) {
        return $inicio['fila'] === $fin['fila'] || $inicio['columna'] === $fin['columna'];
    }

    function tiradaValida($inicio, $fin, $tablero) {
        $casilla_inicio = $tablero[$inicio['fila']][$inicio['columna']];
        $casilla_fin = $tablero[$fin['fila']][$fin['columna']];
        return $casilla_inicio[0] === $casilla_fin[0] || $casilla_inicio[1] === $casilla_fin[1];
    }

    function dibujarTablero($tablero) {
        echo "<table border='1'>";
        foreach ($tablero as $fila) {
            echo "<tr>";
            foreach ($fila as $casilla) {
                echo "<td>{$casilla[0]}<br>{$casilla[1]}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    echo "<h2>Tablero</h2>";
    dibujarTablero($_SESSION['tablero']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fila_inicio = intval($_POST['fila_inicio']);
        $columna_inicio = intval($_POST['columna_inicio']);
        $fila_fin = intval($_POST['fila_fin']);
        $columna_fin = intval($_POST['columna_fin']);

        $inicio = ['fila' => $fila_inicio, 'columna' => $columna_inicio];
        $fin = ['fila' => $fila_fin, 'columna' => $columna_fin];

        if (tiradaPermitida($inicio, $fin)) {
            if (tiradaValida($inicio, $fin, $_SESSION['tablero'])) {
                echo "<p style='color:green;'>El movimiento es válido.</p>";
            } else {
                echo "<p style='color:red;'>El movimiento no es válido (color o número no coinciden).</p>";
            }
        } else {
            echo "<p style='color:red;'>El movimiento no está permitido (no es en la misma fila o columna).</p>";
        }
    }
    ?>
</body>
</html>
