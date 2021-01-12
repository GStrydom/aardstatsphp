<?php
	require ("../private/db.php");

	$totalLevels = 0;
	$totalGold = 0;
	$totalTrains = 0;
	$totalPups = 0;

	$today = date('d-m-Y');
	$sql = "SELECT * FROM stats WHERE date < NOW() - INTERVAL 1 WEEK";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$stats = $stmt->fetchAll();
	
	$dates = array();
	$levels = array();

	foreach ($stats as $stat) {
		array_push($dates, $stat->date);
	}
	
	$sql = "SELECT * FROM stats";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$stats = $stmt->fetchAll();
	
	foreach ($stats as $stat) {
		$totalLevels += $stat->levels;
		array_push($levels, $stat->levels);
		$totalGold += $stat->gold;
		$totalTrains += $stat->trains;
		$totalPups += $stat->pups;
	}
	
	$dates_array = json_encode($dates);
	$levels_array = json_encode($levels);
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
		<link rel="stylesheet" type="text/css" href="../css/styles.css"/>
		<link rel="stylesheet" type="text/css" href="../css/graphstyles.css"/>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
		<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"> </script>
		<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"> </script>
	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"> </script>
		
		<script>
			$(document).ready(function() {
				var levels_ctx = document.getElementById('levels').getContext('2d');
                var gold_ctx = document.getElementById('gold').getContext('2d');
                var trains_ctx = document.getElementById('trains').getContext('2d');
                var pups_ctx = document.getElementById('pups').getContext('2d');
                
				let totalLevels = parseInt("<?php echo $totalLevels; ?>");
				let totalGold = parseInt("<?php echo $totalGold; ?>");
				let totalTrains = parseInt("<?php echo $totalTrains; ?>");
				let totalPups = parseInt("<?php echo $totalPups; ?>");
				
				var dates = <?php echo $dates_array; ?>;
				var levels = <?php echo $levels_array; ?>;
                
				var levelsChart = new Chart(levels_ctx, {
					type: 'bar',
					data: {
						labels: [dates],
						datasets: [{
								label: 'Levels Gained',
								data: [levels],
								backgroundColor: [
									'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
                                    'rgba(0, 0, 255, 0.2)',
								],
								borderColor: [
									'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
                                    'rgba(0, 0, 255, 1)',
								],
								borderWidth: 1
							}]
					},
					options: {
						scales: {
							yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
						}
					}
				});
                
                var goldChart = new Chart(gold_ctx, {
					type: 'bar',
					data: {
						labels: [''],
						datasets: [{
								label: 'Gold Gained',
								data: [totalGold],
								backgroundColor: [
									'rgba(255, 255, 0, 0.2)',
								],
								borderColor: [
									'rgba(255, 255, 0, 1)',
								],
								borderWidth: 1
							}]
					},
					options: {
						scales: {
							yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
						}
					}
				});
                
                var trainsChart = new Chart(trains_ctx, {
					type: 'bar',
					data: {
						labels: [''],
						datasets: [{
								label: 'Trains Gained',
								data: [totalTrains],
								backgroundColor: [
									'rgba(0, 255, 0, 0.2)',
								],
								borderColor: [
									'rgba(0, 255, 0, 1)',
								],
								borderWidth: 1
							}]
					},
					options: {
						scales: {
							yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
						}
					}
				});
                
                var pupsChart = new Chart(pups_ctx, {
					type: 'bar',
					data: {
						labels: [''],
						datasets: [{
								label: 'Pups Gained',
								data: [totalPups],
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
								],
								borderColor: [
									'rgba(255, 99, 132, 1)',
								],
								borderWidth: 1
							}]
					},
					options: {
						scales: {
							yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
						}
					}
				});
			})
		</script>
	</head>
	<body>
        <?php require ("../private/navbar.php"); ?>
 		<div class="container">
            <div class="row mt-4 mb-4" id="charts-box1">
                <canvas class="col-md-6" id="levels"></canvas>
                <canvas class="col-md-6" id="gold"></canvas>
            </div>
            <div class="row" id="charts-box2">
                <canvas class="col-md-6" id="trains"></canvas>
                <canvas class="col-md-6" id="pups"></canvas>
            </div>
        </div>
	</body>
</html>