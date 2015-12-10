<html>
	<header>
		<title>Getonboard.cl bot</title>

		<script src = "jquery-2.1.4.min.js"></script>
		<script>
			$(document).ready(
				function() {
					$(".deleteJobButton").on("click", function(evt) {
						var tr_id = evt.target.closest('tr').id;
						$("#" + tr_id).hide();
						$.ajax({
							method: "POST",
							url: "deletejob.php",
							data: {url: evt.target.value}
						});
					});
				}
			);
		</script>
	</header>

	<body>
		<?php
			include("simple_html_dom.php");
			include("dbaccess.php");


			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "SELECT * FROM ignored_jobs";
			$result = $conn->query($sql);
			$conn->close();

			$bannedJobs = array();

			while($row = mysqli_fetch_assoc($result)) {
				 $bannedJobs[$row["url"]] = true;
			}

			$html = file_get_html("https://www.getonbrd.cl/empleos/programacion");

			$jobs = $html->find('.job-list li a');

			$trCounter = 0;
			echo "<table>";
			foreach($jobs as $job)
			{
				$url = $job->attr["href"];

				if(isset($bannedJobs[$url])) continue;

				echo "<tr id = '".$trCounter++."'>";
				echo "<td><a href='".$url."'>".$job->attr["title"]."</a></td>";
				echo "<td><button class='deleteJobButton' value='".$url."'>Eliminar</button></td>";
				echo "</tr>";
			}
			echo "</table>";

		?>
	</body>
</html>
