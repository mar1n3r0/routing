<?php
if (!isset($_GET['id']) || !((int) $_GET['id'] > 0)) {
    header('Location: index.php');
    exit;
}
require 'inc/config.php';
require 'inc/header.php';
?>
<div class="navigation">
    <ul id="menu">
		<li style="float: left;"><a href="#" id="editCon">Edit Connection</a></li>
        <li style="float: left;"><a href="#" id="DelCon">Delete Connection</a></li>
        <li style="float: right;"><a href="index.php">Routes List</a></li>
        </li>
    </ul>
</div>
<?php
$sql = 'SELECT * FROM hops
        WHERE hop_id =' . (int) $_GET['id'];
$result = mysqli_query($con, $sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['hop_id'];
    ?>
    <table>
        <tr>
            <td><span class="sum">Connection:</span> <a href="?id=<?= $row['hop_id'] ?>"><?= $row['hop_name'] ?></a></td>
        </tr>
    </table>
    <form action="processpost.php" method="POST">
    <table style="display:none;" id="sendCon">
        <tr>
            <td><label for="title">Edit Name</label></td>
            <td><input type="text" name="conName" id="title" value="<?= $row['hop_name'] ?>" style="width: 400px;" /></td>
        </tr>
        <tr>
        <td><label for="title">Edit Description</label></td>
        <td style="vertical-align: top;"><span class="sum">
        <?php 
				echo '<textarea name="conInfo">' . $row['hop_info'] . '</textarea>';
			
         ?>
        </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" name="sendCon" style="width: 120px;" value="Save"/>
            </td>
        </tr>
    </table>
</form>
    <form action="processpost.php" method="POST">
    <table style="display:none;" id="RemCon">
        <tr>
            <td><label for="title">Really Delete ?</label></td>
            <td><input type="text" name="ConDel" id="title" value="<?= $row['hop_name'] ?>" style="width: 400px;" /></td>
			<input type="hidden" name="ID" value=<?php echo $_GET['id']; ?>
        </tr>
            <td>
                <input type="submit" name="RemCon" style="width: 120px;" value="Delete"/>
            </td>
        </tr>
    </table>
    </form>
    
    <table id="showCon">
        <tr>
        <td><label for="title">Description</label></td>
        <td style="vertical-align: top;"><span class="sum">
        <?php $sql='SELECT hop_info FROM hops WHERE hop_id=' . $_GET['id'];
        $q= mysqli_query($con, $sql);
        $result = mysqli_num_rows($q);
        if($result>0){
			while($row= mysqli_fetch_assoc($q)) {
				echo '<textarea name="conInfo">' . $row['hop_info'] . '</textarea>';
			}
		}
         ?>
        </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="sum">Route</td>
            <td class="sum">Connections</td>
        </tr>
        <?php
        $sql = 'SELECT r.route_id, h.hop_id, r.route_name, h.hop_name FROM routes_hops as rh
                INNER JOIN routes as r
                ON rh.route_id = r.route_id
                INNER JOIN routes_hops as rrh
                ON rrh.route_id = rh.route_id
                INNER JOIN hops as h
                ON rrh.hop_id = h.hop_id
                WHERE rh.hop_id ='.$_GET['id'].'    
                ORDER BY route_name';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $reArrange = array();
            while ($row = $result->fetch_assoc()) {
                $reArrange[$row['route_id']]['route_name'] = $row['route_name'];
                $reArrange[$row['route_id']]['hops'][$row['hop_id']] = $row['hop_name'];
            }
            foreach ($reArrange as $book) {
                echo '<tr><td>' . $book['route_name'] . '</td><td>';
                $authorsCount = count($book['hops']);
                $commaCounter = 1;
                foreach ($book['hops'] as $key => $author) {
                    if ($commaCounter == $authorsCount) {
                        $comma = '';
                    } else {
                        $comma = ', ';
                    }
                    echo '<a href="hop.php?id=' . $key . '">' . $author . '</a>' . $comma;
                    $commaCounter++;
                }
                echo '</td></tr>';
            }
        } else {
            echo '<tr><td style="color: #ffc000;" colspan="2">';
            echo 'The Search doesn\'t give any results!';
            echo '</td></tr>';
            echo '<pre>'. print_r($_GET['id'], true).  '</pre>';
        }
        ?>
        <tr>
            <td class="sum">Route</td>
            <td class="sum">Hops</td>
        </tr>
    </table>
    <?php
} else {
    echo '<table><tr><td style="color: #ffc000;" colspan="2">';
    echo 'There is no such connection!';
    echo '</td></tr></table>';
}
?>
<?php
include 'inc/footer.php';
?>
