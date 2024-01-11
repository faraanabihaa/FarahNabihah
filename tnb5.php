<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Electricity TNB Calculator</title>
</head>
<body>

  <div class="container mt-5">
    <?php
    function calculateElectricityRate($voltage, $current, $rate, $hour) {
        $power = ($voltage * $current);
        $energy = ($power / 1000) * $hour; 
        $totalCharge = $energy * ($rate / 100);

        return [
            'power' => $power,
            'energy' => $energy,
            'totalCharge' => $totalCharge
        ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voltage = $_POST['voltage'];
        $current = $_POST['current'];
        $rate = $_POST['rate'];

        $totalPower = ($voltage * $current) / 1000;
        $totalRate = $rate / 100;

        echo "<h1 class='mb-4'>Electricity TNB Calculator Result</h1>";
        echo "<p>Power: {$totalPower} kW</p>";
        echo "<p>Rate: {$totalRate} RM</p>";

        echo "<table class='table'>";
        echo "<thead>
                <tr>
                <th><strong>#</strong></th>
                <th>Hour</th>
                <th>Energy (kWh)</th>
                <th>Total(RM)</th>
                </tr>
              </thead>";
        echo "<tbody>";

        $number = 1;

        for ($hour = 1; $hour <= 24; $hour++) {
            $hourlyResult = calculateElectricityRate($voltage, $current, $rate, $hour);

            echo "<tr>";
            echo "<td><strong>{$number}</strong></td>";
            echo "<td>{$hour}</td>";
            echo "<td>{$hourlyResult['energy']}</td>";
            $formattedTotal = number_format($hourlyResult['totalCharge'], 2);
            echo "<td>{$formattedTotal}</td>";
            echo "</tr>";

            $number++;
        }

        echo "</tbody>";
        echo "</table>";

        echo "<a href=\"index.html\" class=\"btn btn-secondary mt-3\">Back</a>";
    } else {
    ?>
    <h1 class="mb-4">Electricity Calculator</h1>
    <form action="tnb5.php" method="post">
      <div class="form-group">
        <label for="voltage">Voltage (V):</label>
        <input type="number" step="any" class="form-control" id="voltage" name="voltage" required>
      </div>
      <div class="form-group">
        <label for="current">Current (A):</label>
        <input type="number" step="any" class="form-control" id="current" name="current" required>
      </div>
      <div class="form-group">
        <label for="rate">Current Rate (sen/kWh):</label>
        <input type="number" step="any" class="form-control" id="rate" name="rate" required>
      </div>
      <button type="submit" class="btn btn-primary">Calculate</button>
    </form>
    <?php
    }
    ?>
  </div>

</body>
</html>

