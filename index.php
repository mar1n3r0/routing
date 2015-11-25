<?php
require 'inc/config.php';
require 'inc/header.php';
require 'processpost.php';
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
        $sortSql = 'asc';
        $sortFix = 'desc';
    } else if ($_GET['sort'] == 'desc') {
        $sortSql = 'desc';
        $sortFix = 'asc';
    }
} else {
    $sortSql = 'asc';
    $sortFix = 'desc';
}

if (isset($_POST['postSearch'])) {
    $key = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['searchKey'])));
    $sqlSearch = 'WHERE route_name LIKE "%' . $key . '%"';
} else {
    $sqlSearch = '';
}

if (isset($_SESSION['username'])) {
	$display = 'block';
    $usernameField = 'Hello, <span style="color: #93c72e;">' . $_SESSION['username'] . '</span>
        <li><a href="logout.php">Logout</a></li>';
} else {
	$display = 'none';
    $usernameField = '<li><a href="login.php">Login</a></li>';
}
?>
<div class="navigation" style="margin: 0 0 10px 0px;">
    <ul id="menu" style="text-align: right;">
        <?= $usernameField; ?>
    </ul>
</div>
<div id="main"class="navigation" style="display:<?php echo $display . ';'; ?>">
    <ul id="menu">
        <li><a href="#" id="addBook">Add Route</a></li>
        <li><a href="#" id="addAuthor">Add Connection</a></li>
        <li><a href="index.php?sort=<?= $sortFix ?>">Sort</a></li>
    </ul>
    <form action="index.php" method="POST">
        <input type="submit" name="postSearch" value="Search Route" id="postSearch"/>
        <input type="text" name="searchKey" value="Search..." id="searchKey"/>
    </form>
</div>
<div id="main"class="navigation" style="display:<?php echo $display . ';'; ?>">
			<form enctype="multipart/form-data" id="myform" method="post" action="processpost.php">
				<table id="postBook">
        <tr>
            <td><label for="title">Route Name</label></td>
            <td><input type="text" name="bookTitle" id="title" value="" style="width: 400px;" /></td>
        </tr>
        
        <tr>
            <td><label for="aut">Connections</label></td>
            <td>
				<select name="hops[]" id="selectitems" multiple="multiple" style="width: 450px; height: 180px;">
					<?php //first we add the list of selected items if any
					$sql = 'SELECT * FROM hops';
                    $result = mysqli_query($con, $sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['hop_id'] . '">' . $row['hop_name'] . '</option>';
						}
					}
					/*foreach ($row as $i => $v) { //then insert all items, skipping those who were added above
						if (in_array($i, $authors)) : continue; endif; //skip ?>
					<option value="<?php echo $i; ?>"><?php echo $v; ?></option>
					<?php }*/ ?>
				</select>
				<br/>
				<input type="submit" name="postBook" value="Add Route" />
			</td>
			</tr>
    </table>
			</form>
		<form action="processpost.php" method="POST">
    <table id="postAuthor">
        <tr>
            <td><label for="title">Connection</label></td>
            <td><input type="text" name="authorName" id="title" value="" style="width: 400px;" /></td>
        </tr>
        <tr>
		<td><label for="desc">Description</label></td>	
        <td>
			<textarea name="conInfo" value=""></textarea>
		</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" name="postAuthor" style="width: 120px;" value="Add Connection"/>
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
} else if (isset($_GET['succAuthor'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'The connection has been added!';
    echo '</td></tr></table>';
}   else if (isset($_GET['succCon'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'The connection has been changed!';
    echo '</td></tr></table>';
}   else if (isset($_GET['succRoute'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'The route name has been changed!';
    echo '</td></tr></table>';
}else if (isset($_GET['succreg'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'Welcome to the Routing scheme ' . $_SESSION['username'] . '!';
    echo '</td></tr></table>';
}else if (isset($_GET['DelRoute'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'The route has been deleted!';
    echo '</td></tr></table>';
}else if (isset($_GET['DelCon'])) {
    echo '<table><tr><td style="color: #93c72e;">';
    echo 'The connection has been deleted!';
    echo '</td></tr></table>';
}
?>
<table>
    <tr>
        <td class="sum">Route</td>
        <td class="sum">Connections</td>
    </tr>
<?php   
$sql = 'SELECT * FROM routes as r 
		LEFT JOIN routes_hops as rh
		ON r.route_id=rh.route_id 
		LEFT JOIN hops as h ON h.hop_id=rh.hop_id
		' . $sqlSearch . '
		ORDER BY rh.route_id ' . $sortSql;
$q = mysqli_query($con, $sql);
mysqli_close($con);
if(!$q) {
	echo "Error query";
	}
$result = mysqli_num_rows($q);
if(!$result == 0) {
	$res= array();
	
	while($row=mysqli_fetch_assoc($q)){
	//echo '<pre>'. print_r($row, true).  '</pre>';
	$res[$row['route_id']]['route_id']= $row['route_id'];
	$res[$row['route_id']]['route_name']= $row['route_name'];
	$res[$row['route_id']]['hops'][]= $row['hop_name'];
	$res[$row['route_id']]['hop_id'][]= $row['hop_id'];
	//echo '<pre>'. print_r($row['hop_id'], true).  '</pre>';
	}
	
	foreach($res as $v) {
	
	
	
	echo '<tr><td><a href="route.php?id=' . $v['route_id'] . '">' . $v['route_name'] . '</a></td>';
	$data= array();
	foreach ($v['hops'] as $vv) {
	
	$data[]= $vv;
	}
	$a= implode(', ', $data);
	$hops_num = count($v['hop_id']);
	/*if($hops_num ==0) {
	echo '<td><a href="connection.php?id='. $v['hop_id'][0]. '">' .$v['hops'][0]. '</a></td></br>';
	
	}*/
	
	
	for($i=$hops_num-1; $i>-1; $i--) {
	
	echo '<td><a href="connection.php?id='. $v['hop_id'][$i]. '">' .$v['hops'][$i]. '</a></td>   ';
	}
	
	
	
	echo '</tr>';
	}

}else {
        echo '<tr><td style="color: #ffc000;" colspan="2">';
        echo 'The Search doesn\'t give any results!';
        echo '</td></tr>';
    }
?>
<tr>
        <td class="sum">Route</td>
        <td class="sum">Connections</td>
    </tr>
</table>
</div>
</body>

</html>

