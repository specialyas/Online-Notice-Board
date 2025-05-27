<?php 
$q=mysqli_query($conn,"select * from notice where user='".$_SESSION['user']."'");
$rr=mysqli_num_rows($q);
if(!$rr)
{
echo "<h2 style='color:red'>You do not have any notice at the moment !!!</h2>";
}
else
{
?>
<h2>All Notification</h2>

<table class="table table-bordered">
	<Tr class="success">
		<th>Sr.No</th>
		<th>Subject</th>
		<th>Details</th>
		<th>Date</th>
		</Tr>
		<?php


$i=1;
while($row=mysqli_fetch_assoc($q))
{

echo "<Tr>";
echo "<td>".$i."</td>";
echo "<td>".$row['subject']."</td>";
echo "<td>".$row['Description']."</td>";
echo "<td>".$row['Date']."</td>";

echo "</Tr>";
$i++;
}
		?>

</table>
<?php }?>


<div class="table-wrapper">
  <table class="table table-bordered table-hover table-striped text-center align-middle">
  