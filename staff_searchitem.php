<?php

include("connection.php");

// save the session variable in another variable
$sess_sid = $_SESSION["staff_id"];

// finding the specific member record based on the session variable
$result = mysql_query("select * from staff where StaffID = $sess_sid");
$row=mysql_fetch_assoc($result);

if(!isset($_SESSION["staff_id"]))
{
 header("location:homepage.php");
}

if(isset($_POST["ReturnItem"]))
{
  $c = $_POST["ProdCode"];
  $query = mysql_query("select * from product where ProductCode = '$c'");
  $row2 = mysql_fetch_assoc($query);
  $q = $row2["ProductQuantity"];
  $quantity = $_POST["quantity"];
  $rItem = $q + $quantity;

  mysql_query("update product set ProductQuantity = $rItem where ProductCode = '$c'");
  ?>

		<script type="text/javascript">
			alert("Return <?php echo $quantity; ?> Items ");
		</script>

	<?php

}

if(isset($_POST["Itemsold"]))
{
  $c = $_POST["ProdCode"];
  $query = mysql_query("select * from product where ProductCode = '$c'");
  $row2 = mysql_fetch_assoc($query);
  $id = $row2["ProductID"];
  $q = $row2["ProductQuantity"];
  $quantity = $_POST["quantity"];
  $sItem = $q - $quantity;
  date_default_timezone_set('Asia/Kuala_Lumpur');
  $sdate = date("Y-m-d");

 if($sItem <=0){
  ?>

		<script type="text/javascript">
			alert("Invalid data");
		</script>

<?php
 }
 else{
  mysql_query("update product set ProductQuantity = $sItem where ProductCode = '$c'");
  mysql_query("insert into sales (SalesQuantity,SalesDate,ProductID,StaffID) values ('$quantity','$sdate',$id,$sess_sid)");
  ?>

		<script type="text/javascript">
			alert("Sold <?php echo $quantity; ?> Items ");
		</script>

  <?php

}
?>

<!DOCTYPE html>
<html>
<head>
<title></title>

<link rel="stylesheet" type="text/css" href="css.css"/>
<style>
.register_form
{
border-style:solid;
border-width:1px;
border-radius:5px;
background-color:#b3e0ff;
background-position:center;
width:300px;
height:380px;
margin-left:300px;
padding-left:40px;

}
td
{
font-size:20px;
}



.leftprofile
{
border:#66c2ff 1px solid;
height:840px;
width:280px;
background:#000f1a;

}

.title
{
background-color:#000f1a;
font-size:25px;
color:#66c2ff;
padding:10px;
font-family:arial narrow;
border-bottom:#66c2ff solid 1px;

}
.profile_detail table
{
margin-left:30px;
}

.profile_detail
{
background-color:#E6E6E6;
border:solid 2px ;
margin-left:300px;
margin-right:10px;
margin-top:10px;
height:800px;
}

.profile_detail input[type="password"], .profile_detail input[type="text"], .profile_detail input[type="email"], .profile_detail input[type="number"],select
{
	border-style:solid;
	border-width:2px;
	border-color:#383838;
	border-radius:4px;
	padding-left:40px;
	margin: 10px 5px;
	height:27px;
	width:180px;
}

.profile_detail input[type='submit']
{
	background-position:1px;
	background-color:#66c2ff;
	color:#000f1a;
	border-width:1.5px;
	border-color:#004c80;
	border-radius:3px;
	font-family:arial narrow;
	width:120px;
	font-size:18px;
}

.profile_detail input[type='submit']:hover
{
	font-family:arial narrow;
	background-color:#ccebff;
	color:#002ecd;
	border-color:#001f33;
}


</style>
</head>
<body>
<div style="border:black 2px solid;height:1122px;width:1020px;margin-left:200px;background-color:#e5f5ff">
<br/>
<br/>
<span style="color:#262626;font-size:55px;font-weight:bold;font-family:arial narrow;padding-left:100px;"><span style="font-style:italic;">P</span>harma<span style="color:#005c99">c</span>y </span><span style="color:#262626;font-size:45px;font-weight:bold;font-family:arial narrow;">Online</span>
<br/>
<span style="color:#262626;font-size:25px;font-weight:bold;font-family:arial narrow;padding-left:100px;font-style:oblique;">| The most efficient pharmacy is within your own system</span>
<br/>
<br/>
<br/>
<div style=";background-color:black; 	height:1px;"></div>
<div style=";background-color:#004c80;height:40px;font-weight:bold;color:#ffffff;font-size:15px;"><br/>Staff UserName:<?php echo $row["StaffUsername"]; ?><span style="float:right;">Date:<?php date_default_timezone_set("Asia/Kuala_Lumpur");echo date("d-m-Y H:i:s");?></span></div>
<div style=";background-color:black; height:1px;"></div>


<ul class="profile">

<div class="leftprofile">
<li><a href="staff_homepage.php"><span style="clear:both;">Profile</span></a></li>

<li><a href="staff_editProfile.php"><span style="clear:both;">Edit Profile</span></a>
</li>
<li><a href="staff_uploadImage.php"><span style="clear:both;">Upload Image</span></a></li>
<li><a href="staff_searchitem.php"><span style="clear:both;">Search</span></a></li>
<li><a href="staff_viewitem.php"><span style="clear:both;">View Item</span></a></li>
<li><a href="logout.php"><span style="clear:both;">Log Out</span></a></li>

</div>

</ul>

<div class="profile_detail">
<div class="title">
Search
</div>
<form name="searchfrm" method="POST">
<table>
<tr>
<td><span style="font-weight:bold;">Search By  </span></td>
<td>:</td>
<td><select name="searchby">
<option value="Code of medicine">Code of medicine</option>
<option value="Name">Name</option>
</select>
</td>
</tr>
<tr>
<td><input type="text" name="search"></td>
<td></td>
<td><input type="submit" name="btnupdate" value="Search" /></td>
</tr>
<?php
if(isset($_POST["btnupdate"]))
{
  $search = $_POST["search"];
  if($_POST["searchby"] == "Code of medicine")
  {
    $answer = mysql_query("select * from product where ProductCode = '$search' ");
    $row1 = mysql_fetch_assoc($answer);
    if(mysql_num_rows($answer) > 0)
    {
?>
 <tr>
 <td><img src="<?php echo $row1['ProductImage'] ?>" width="120px" style="border-style:solid;border-width:1px;margin-top:100px;"/></td>
 <td></td>
 <td></td>
 </tr>
<tr>
<td><span style="font-weight:bold;">Code of medicine</span></td>
<td>:</td>
<td><input type="text" name="ProdCode" value="<?php echo $row1['ProductCode']; ?>" readonly="readonly"/></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Name</span> </td>
<td>:</td>
<td><?php echo $row1['ProductName']; ?></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Price</span></td>
<td>:</td>
<td>RM <?php echo $row1['ProductPrice']; ?></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Quantity</span></td>
<td>:</td>
<td><input type="number" name="quantity" placeholder="quantity" min="1"/></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Decription</span></td>
<td>:</td>
<td><?php echo $row1['ProductDescription']; ?></td>
</tr>
<tr>
<td></td>
<td></td>
<td><span style="margin-left:150px;"><input type="submit" name="ReturnItem" value="Return Item"/> <input type="submit" name="Itemsold" value="Item sold"/></span></td>
</tr>
<?php
}
else {
  ?>

    <script type="text/javascript">
      alert("No Result Found...");
    </script>

  <?php
}
}
elseif ($_POST["searchby"] == "Name")
{
 $answer = mysql_query("select * from product where ProductName = '$search' ");
 $row1 = mysql_fetch_assoc($answer);
 if(mysql_num_rows($answer) > 0){
 ?>
 <tr>
 <td><img src="<?php echo $row1['ProductImage'] ?>" width="120px" style="border-style:solid;border-width:1px;margin-top:100px;"/></td>
 <td></td>
 <td></td>
 </tr>
<tr>
<td><span style="font-weight:bold;">Code of medicine</span></td>
<td>:</td>
<td><input type="text" name="ProdCode" value="<?php echo $row1['ProductCode']; ?>" readonly="readonly"/></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Name</span> </td>
<td>:</td>
<td><?php echo $row1['ProductName']; ?></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Price</span></td>
<td>:</td>
<td>RM <?php echo $row1['ProductPrice']; ?></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Quantity</span></td>
<td>:</td>
<td><input type="number" name="quantity" placeholder="quantity" min="1"/></td>
</tr>
<tr>
<td><span style="font-weight:bold;">Decription</span></td>
<td>:</td>
<td><?php echo $row1['ProductDescription']; ?></td>
</tr>
<tr>
<td></td>
<td></td>
<td><span style="margin-left:150px;"><input type="submit" name="ReturnItem" value="Return Item"/> <input type="submit" name="Itemsold" value="Item sold"/></span></td>
</tr>
 <?php
 }
else {
  ?>

    <script type="text/javascript">
      alert("No Result Found...");
    </script>

  <?php
}
}
}
 ?>

</table>
</form>
</div>

<div style=";background-color:black;height:1px;margin-top:40px;float:bottom;"></div>
<div style=";background-color:#004c80;height:62px"><br/></div>
</div>

</body>
</html>
