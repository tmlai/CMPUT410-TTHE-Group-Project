<?php
session_start();
use model\DbLayer;

include_once "adminHelper.php";
include_once "./model/Olap.php";
use controller\AdminHelper;
use model\Olap;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Admin page</title>
		<script type="text/javascript">
		function checkDate(input) {
			var validformat = /^\d{4}-\d{2}-\d{2}$/; //Basic check for format validity
			var returnval = false;

			if (input.value.trim() == "") {
				return true;
			}

			if (!validformat.test(input.value)) {

			} else {// Detailed check for valid date ranges
				var yearfield = input.value.split("-")[0];
				var monthfield = input.value.split("-")[1];
				var dayfield = input.value.split("-")[2];
				var dayobj = new Date(yearfield, monthfield - 1, dayfield);
				if ((dayobj.getMonth() + 1 != monthfield)
						|| (dayobj.getDate() != dayfield)
						|| (dayobj.getFullYear() != yearfield)) {
				} else
					returnval = true;
			}
			if (returnval == false)
				input.select();
			return returnval;
		}
						
			function checkSubmit(){
				var x1 = checkDate(document.admin.from);
				var x2 = checkDate(document.admin.to);

				if (x1 == false) {
					alert("from date is invalid!");
					document.admin.from.select();
					document.admin.from.focus();
					return false;
				}

				if(x2 == false){
					alert("to date is invalid!");
					document.admin.to.select();
					document.admin.to.focus();
					return false;
				}

				return true;
			}

			function checkTop(){
				var x1 = checkDate(document.topProduct.fromTop);
				var x2 = checkDate(document.topProduct.toTop);
				var x3 = isNaN(document.topProduct.topN.value);

				if (x1 == false) {
					alert("from date is invalid!");
					document.topProduct.fromTop.select();
					document.topProduct.fromTop.focus();
					return false;
				}

				if(x2 == false){
					alert("to date is invalid!");
					document.topProduct.toTop.select();
					document.topProduct.toTop.focus();
					return false;
				}

				if(x3 == true){
					alert("Number of Products is not a number!");
					document.topProduct.topN.select();
					document.topProduct.topN.focus();
					return false;
				}
				return true;
			}
			
		</script>
	</head>
	<body>
		<?php 
		if($_SESSION['admin'] == null || $_SESSION['admin'] == "") {
			echo "You do not have permission to access this page.";
			echo "<a href='/source/view/index.php'>Back to main page</a>";
		}
		?>
	<table width="100%">
	<tr>
	<td>
	<form name="admin" method="GET" action="admin.php" onsubmit="return checkSubmit()">
			<fieldset>
				<legend style="font-size: 2em">
					Management Module
				</legend>
				<table>
					<tr>
						<td> Customer: </td>
						<td> <select id='customer' name='customer'>
							<?php
							AdminHelper::getListCustomers();
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td> Product: </td>
						<td><select id="product" name="product">
							<?php
							AdminHelper::getListProducts();
							?>
						</select>
						</td>
					</tr>
					<tr>
						<td> Store: </td>
						<td><select id="store" name="store">
							<?php
							AdminHelper::getListExternalStores();
							?>
						</select>
						</td>
					</tr>
					<tr>
						<td> From (YYYY-MM-DD): </td>
						<td>
						<input id="from" name="from" type="text" value = ""/>
						</td>
					</tr>
					<tr>
						<td> To (YYYY-MM-DD): </td>
						<td>
						<input id="to" name="to" type="text" value = "" />
						</td>
					</tr>
				</table>
				<input id="submit" name="submit" type="submit" value="submit" />
				<input id="reset" name="reset" type="reset" value="reset" />
			</fieldset>
	</form>
	</td>
	<td>
	<form name="topProduct" method="GET" action="admin.php" onsubmit="return checkTop()">
			<fieldset>
				<legend style="font-size: 2em">
					Top Product
				</legend>
				<table>
					<tr>
						<td> Number of Products: </td>
						<td> <input id="topN" name="topN" type="text" value="10"/>
						</td>
					</tr>
					<tr>
						<td> From (YYYY-MM-DD): </td>
						<td>
						<input id="fromTop" name="fromTop" type="text" value = ""/>
						</td>
					</tr>
					<tr>
						<td> To (YYYY-MM-DD): </td>
						<td>
						<input id="toTop" name="toTop" type="text" value = "" />
						</td>
					</tr>
					<tr>
						<td> Category: </td>
						<td><select id="category" name="category">
							<?php
							AdminHelper::getListCategories();
							?>
						</select>
						</td>
					</tr>
				</table>
				<input id="submitTop" name="submitTop" type="submit" value="submit" />
				<input id="resetTop" name="resetTop" type="reset" value="reset" />
			</fieldset>
	</form>
	</td>
	</tr>
	</table>
	<?php
		$submitVal = $_GET['submit'];
		$submitTop = $_GET['submitTop'];
		if($submitVal != ''){
			// get olap analysis
			$customer = $_GET['customer'];
			$product = $_GET['product'];
			$store = $_GET['store'];
			$from = $_GET['from'];
			$to = $_GET['to'];
			
			
			if($customer == 'NULL'){
				$customer = null;
			}
			if($product == 'NULL'){
				$product = null;
			}
			if($store == 'NULL'){
				$store = null;
			}
			
			$olapObj = new Olap($customer, $product, $store, $from, $to, 0,0);
			AdminHelper::getListOlaps($olapObj);
		} elseif($submitTop != ''){
			$n = $_GET['topN'];
			$fromTop = $_GET['fromTop'];
			$toTop = $_GET['toTop'];
			$cateId = $_GET['category'];
			
			if($cateId == 'any'){
				$cateId = null;
			}
			
			AdminHelper::getTopNProducts($n, $fromTop, $toTop, $cateId);
		}
	?>
	</body>
</html>