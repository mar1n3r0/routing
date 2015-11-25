<?php
require './inc/config.php';
require 'inc/header.php';
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
} else {
    $sql = 'SELECT * FROM routes WHERE route_id=' . (int) $_GET['id'];
    $result = mysqli_query($con, $sql);
    if ($result->num_rows <= 0) {
        header('Location: index.php');
        exit;
    } else {
        $row = $result->fetch_assoc();
        $_SESSION['route_name'] = $row['route_name'];
        $_SESSION['id'] = $_GET['id'];
    }
}

?>
<div class="navigation" style="text-align: right;">
    <ul id="menu">
		<li style="float: left;"><a href="#" id="editRoute">Edit Name</a></li>
        <li style="float: left;"><a href="#" id="DelRoute">Delete Route</a></li>
        <li style="float: right;"><a href="index.php">All Routes</a></li>
        
    </ul>
</div>
<table>
    <tr>
        <td colspan="2"><span class="sum"><?= $row['route_name'] ?></span></td>
    </tr>
</table>
<form action="processpost.php" method="POST">
    <table style="display:none;" id="postRoute">
        <tr>
            <td><label for="title">Edit Name</label></td>
            <td><input type="text" name="routeName" id="title" value="<?= $row['route_name'] ?>" style="width: 400px;" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" name="postRoute" style="width: 120px;" value="Save"/>
            </td>
        </tr>
    </table>
</form>
    <form action="processpost.php" method="POST">
    <table style="display:none;" id="RemRoute">
        <tr>
            <td><label for="title">Really Delete ?</label></td>
            <td><input type="text" name="routeDel" id="title" value="<?= $row['route_name'] ?>" style="width: 400px;" /></td>
			<input type="hidden" name="ID" value=<?php echo $_GET['id']; ?>
        </tr>
            <td>
                <input type="submit" name="RemRoute" style="width: 120px;" value="Delete"/>
            </td>
        </tr>
    </table>
    </form>

    <form enctype="multipart/form-data" id="myform" method="post" action="processpost.php">
	<table id="postCon">
        <tr>
			<input type="hidden" name="routeTitle" id="title" value="<?= $_SESSION['route_name'] ?>" style="width: 400px;" />
            <td><label for="aut">Connections</label></td>
            <td>
				<select name="hops[]" id="selectitems" multiple="multiple" style="width: 450px; height: 180px;">
					<?php //first we add the list of selected items if any
					
					$sql = 'SELECT * FROM routes as r LEFT JOIN routes_hops as rh
					ON r.route_id=rh.route_id 
					LEFT JOIN hops as h ON h.hop_id=rh.hop_id 
					WHERE rh.route_id="' . $_SESSION['id'] . '"';
                    $q = mysqli_query($con, $sql);
                    $result = mysqli_num_rows($q);
                    if(!$result == 0) {
					$res= array();
                        while($row=mysqli_fetch_assoc($q)){
							
	$res[$row['route_id']]['route_id']= $row['route_id'];
	$res[$row['route_id']]['route_name']= $row['route_name'];
	$res[$row['route_id']]['hops'][]= $row['hop_name'];
	$res[$row['route_id']]['hop_id'][]= $row['hop_id'];
	//echo '<pre>'. print_r($row['hop_id'], true).  '</pre>';
	}
	
	foreach($res as $v) {
	
	$data= array();
	foreach ($v['hops'] as $vv) {
	
	$data[]= $vv;
	}
	$a= implode(', ', $data);
	$hops_num = count($v['hop_id']);
	if($hops_num > 0) {
	
	for($i=$hops_num-1; $i>-1; $i--) {
	
	echo '<option value="'. $v['hop_id'][$i]. '"selected="selected">' .$v['hops'][$i]. '</option>';
	}
	}
	}
	}						
					
					$sql2 = 'SELECT * FROM hops';
					
					
                    $result2 = mysqli_query($con, $sql2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
							
							echo '<option value="' . $row2['hop_id'] . '">' . $row2['hop_name'] . '</option>';
						}
					}
				   ?>
				</select>
				<br/>
				<input type="submit" name="postCon" value="Save" />
			</td>   
		</tr>
	</table>
</form>
<?php
if (isset($_GET['err']) && $_GET['err'] == 1 && isset($_SESSION['msg_err_array'])) {
    echo '<table><tr><td style="color: #ff491f;">';
    foreach ($_SESSION['msg_err_array'] as $v) {
        echo $v . '<br/>';
    }
    echo '</td></tr></table>';
}
include './inc/footer.php';
?>
