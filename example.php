<?php
require_once("YQuery.php");

$builder = new YQuery();
$builder->select("order_id, order_date, order_amount")
	->from("orders")
	->andWhere("order_date > '2015-06-01' ", "order_date_ref")
	->groupBy("order_date");

// filter
if (isset($_POST['filter_query'])) {
	$additional = $_POST["additional"];
	$date       = $_POST["date"];
	$order_by   = $_POST["order_by"] . " DESC";

	if (!empty($additional)) {
		$builder->select($additional);
	}

	if (!empty($date)) {
		$builder->remove("andWhere", "order_date_ref")
				->andWhere("order_date > '$date' ");
	}

	if (!empty($order_by)) {
		$builder->orderBy($order_by);
	}
} 

?>

<form method="post" name="filter">
	Additional field(s):<br/> <input type="text" name="additional" /> <br/><br/>

	Date start:<br/> <input type="date" name="date" /> <br/><br/>
	
	Order By:<br/> 
		<label><input type="radio" name="order_by" value="order_id" /> Order ID</label>
		<label><input type="radio" name="order_by" value="order_date" /> Date</label>
		<label><input type="radio" name="order_by" value="order_amount" /> Amount</label>
	<br/><br/>

	<input type="submit" value="Filter" name="filter_query" />

</form>
<pre><?php print_r($_POST) ?> </pre>
Result: 
<h4><?php echo $builder->getQuery() ?></h4>