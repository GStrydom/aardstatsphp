<?php
    require("../private/db.php");
    $sql = "SELECT * FROM stats";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);
    $stats = $stmt->fetchAll();
?>

<html>
	<head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"> </script>
        
        <script>
			$(document).ready( function () {
				$('#statstable').DataTable();
			});
        </script>
	</head>
	
	<body>
		<?php require("../private/navbar.php"); ?>
		<div class="container mt-4">
			<table id="statstable">
				<thead>
					<tr>
						<th>Date</th>
						<th>Player</th>
						<th>Levels</th>
						<th>Gold</th>
						<th>Trains</th>
						<th>Pups</th>
					</tr>
				</thead>

				<tbody>
					<?php
						foreach ($stats as $stat) {
							$sql = "SELECT * FROM users WHERE id = ?";
			    			$stmt = $pdo->prepare($sql);
			    			$stmt->execute([$stat->user]);
			    			$user = $stmt->fetch();
							$newDate = date("d/m/Y", strtotime($stat->date));
							echo "<tr><td>" . $newDate . "</td><td><a href='". $user->id . "'>" . $user->name . "</a></td><td>" . $stat->levels . "</td><td>" . $stat->gold . "</td><td>" . $stat->trains . "</td><td>" . $stat->pups . "</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>
