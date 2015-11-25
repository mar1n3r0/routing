<?php

require 'inc/config.php';

if (isset($_POST['postAuthor'])) {
    $author = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['authorName'])));
    $conInfo = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['conInfo'])));
    if (mb_strlen($author, 'UTF-8') < 3) {
        $error_array['author_short'] = 'The connection name is too short';
    }
    if (mb_strlen($conInfo, 'UTF-8') < 3) {
        $error_array['info_short'] = 'The description is too short';
    }
    if (mb_strlen($author, 'UTF-8') > 30) {
        $error_array['author_long'] = 'The connection name is too long';
    }
    if (mb_strlen($conInfo, 'UTF-8') > 250) {
        $error_array['info_long'] = 'The connection name is too long';
    }
    /*if (!preg_match('/^[a-z\d\s\._]{3,30}$/i', $author)) {
        $error_array['author_invalid'] = 'Invalid Connection Name';
    }*/
    if (!isset($error_array)) {
        $sql = 'SELECT hop_id FROM hops WHERE hop_name="' . $author . '"';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $error_array['authorExists'] = 'Connection already Exists!';
        }
    }

    if (!isset($error_array)) {
        $sql = 'INSERT INTO hops (hop_id, hop_name, hop_info) VALUES (NULL,"' . $author . '","' . $conInfo . '" )';
        if (mysqli_query($con, $sql)) {
            header('Location: index.php?succAuthor=1');
            exit;
        } else {
            $error_array[] = mysqli_error($con);
            $_SESSION['msg_err_array'] = $error_array;
            header('Location: index.php?err=1');
            exit;
        }
    } else {
        // send back the error_array
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
        exit;
    }
}
if (isset($_POST['sendCon'])) {
    $conName = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['conName'])));
    $conInfo = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['conInfo'])));
    if (mb_strlen($conName, 'UTF-8') < 2) {
        $error_array['route_short'] = 'The connection name is too short';
    }
    if (mb_strlen($conInfo, 'UTF-8') < 3) {
        $error_array['info_short'] = 'The description is too short';
    }
    if (mb_strlen($conName, 'UTF-8') > 30) {
        $error_array['route_long'] = 'The connection name is too long';
    }
    if (mb_strlen($conInfo, 'UTF-8') > 250) {
        $error_array['info_long'] = 'The description name is too long';
    }
    /*if (!preg_match('/^[a-z\d\s\._]{3,30}$/i', $conName)) {
        $error_array['route_invalid'] = 'Invalid Connection Name';
    }*/
    
    if (!isset($error_array)) {
        $sql = 'SELECT hop_id FROM hops WHERE hop_name="' . $conName . '"';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				
			}
            //$error_array['routeExists'] = 'Route already Exists!';
        }
    }

    if (!isset($error_array)) {
        $sql2 = 'UPDATE hops SET hop_name="' . $conName . '"' . ',hop_info="' . $conInfo . '" WHERE hop_id =' . $_SESSION['id'];
        if (mysqli_query($con, $sql2)) {
            header('Location: index.php?succCon=1');
            exit;
        } else {
            $error_array[] = mysqli_error($con);
            $_SESSION['msg_err_array'] = $error_array;
            header('Location: index.php?err=1');
            exit;
        }
    } else {
        // send back the error_array
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
        exit;
    }
}
if (isset($_POST['postRoute'])) {
    $route = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['routeName'])));
    if (mb_strlen($route, 'UTF-8') < 3) {
        $error_array['route_short'] = 'The route name is too short';
    }
    if (mb_strlen($route, 'UTF-8') > 30) {
        $error_array['route_long'] = 'The route name is too long';
    }
    /*if (!preg_match('/^[a-z\d\s\._]{3,30}$/i', $route)) {
        $error_array['route_invalid'] = 'Invalid Route Name';
    }*/
    if (!isset($error_array)) {
        $sql = 'SELECT route_id FROM routes WHERE route_name="' . $route . '"';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$_SESSION['id']= $row['route_id'];
			}
            //$error_array['routeExists'] = 'Route already Exists!';
        }
    }

    if (!isset($error_array)) {
        $sql = 'UPDATE routes SET route_name="' . $route . '"' . 'WHERE route_id =' . $_SESSION['id'];
        if (mysqli_query($con, $sql)) {
            header('Location: index.php?succRoute=1');
            exit;
        } else {
            $error_array[] = mysqli_error($con);
            $_SESSION['msg_err_array'] = $error_array;
            header('Location: index.php?err=1');
            exit;
        }
    } else {
        // send back the error_array
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
        exit;
    }
}
if (isset($_POST['postBook'])) {
    $bookTitle = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['bookTitle'])));
    if (!isset($_POST['hops'])) {
        $error_array['noAuthorsSelected'] = 'Please select at least one connection!';
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
    } else {
        $authors = $_POST['hops'];
    }
    if (mb_strlen($bookTitle, 'UTF-8') < 2) {
        $error_array['book_short'] = 'The route title is too short';
    }
    if (mb_strlen($bookTitle, 'UTF-8') > 30) {
        $error_array['book_long'] = 'The route title is too long';
    }
    /*if (!preg_match('/^[a-z\d\s\._]{3,30}$/i', $bookTitle)) {
        $error_array['book_invalid'] = 'Invalid Route Name';
    }*/
    if (!isset($error_array)) {
        $sql = 'SELECT route_id FROM routes WHERE route_name="' . $bookTitle . '"';
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $error_array['bookExists'] = 'Route already Exists!';
        }
    }

    if (!isset($error_array)) {
        $sql = 'INSERT INTO routes (route_id, route_name) VALUES (NULL,"' . $bookTitle . '")';
        if (mysqli_query($con, $sql)) {
            $valuesBuilder = '';
            for ($i = 0; $i < count($authors); $i++) {
                if ($i == count($authors) - 1) {
                    $comma = '';
                } else {
                    $comma = ', ';
                }
                $valuesBuilder .= '(' . mysqli_insert_id($con) . ', ' . $authors[$i] . ')' . $comma;
            }
            $sql2 = 'INSERT INTO routes_hops (route_id, hop_id) VALUES ' . $valuesBuilder;
            
            
            if (mysqli_query($con, $sql2)) {
                header('Location: index.php');
                exit;
            }
        } else {
            $error_array[] = mysqli_error($con);
            $_SESSION['msg_err_array'] = $error_array;
            header('Location: index.php?err=1');
            exit;
        }
    } else {
        // send back the error_array
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
        exit;
    }
}

if (isset($_POST['postCon'])) {
    $routeTitle = htmlspecialchars(mysqli_real_escape_string($con, trim($_POST['routeTitle'])));
    if (!isset($_POST['hops'])) {
        $error_array['noAuthorsSelected'] = 'Please select at least one connection!';
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
    } else {
        $authors = $_POST['hops'];
        $_SESSION['hops'] = $authors;
    }
    

    if (!isset($error_array)) {
		$sql2= 'DELETE FROM routes_hops WHERE route_id=' . $_SESSION['id'];
            mysqli_query($con, $sql2);
        $sql = 'SELECT * FROM routes WHERE route_name="' . $routeTitle . '"';
        	
        if (mysqli_query($con, $sql)) {
			$result= mysqli_query($con, $sql);
			if ($result->num_rows > 0) {
				while($row=$result->fetch_assoc()) {
					$_SESSION['id2']= $row['route_id'];
				}
			}
            $valuesBuilder = '';
            for ($i = 0; $i < count($authors); $i++) {
                if ($i == count($authors) - 1) {
                    $comma = '';
                } else {
                    $comma = ', ';
                }
                $valuesBuilder .= '(' . $_SESSION['id2'] . ', ' . $authors[$i] . ')' . $comma;  
            
            $sql3 = 'INSERT INTO routes_hops (route_id, hop_id) VALUES ' . $valuesBuilder;
            
            if (mysqli_query($con, $sql3)) {
                header('Location: index.php');
                exit;
            }
			}
        } else {
            $error_array[] = mysqli_error($con);
            $_SESSION['msg_err_array'] = $error_array;
            header('Location: index.php?err=1');
            exit;
        }
    } else {
        // send back the error_array
        $_SESSION['msg_err_array'] = $error_array;
        header('Location: index.php?err=1');
        exit;
    }
}
if (isset($_POST['RemRoute'])) {

		$sql2= 'DELETE FROM routes_hops WHERE route_id="' . $_POST['ID'] . '"';
            mysqli_query($con, $sql2);
            if (mysqli_query($con, $sql2)) {
        $sql = 'DELETE FROM routes WHERE route_name="' . $_POST['routeDel'] . '"';
        	mysqli_query($con,$sql);
		}
        if (mysqli_query($con, $sql)) {
		header('Location: index.php?DelRoute=1');
            exit;
}
}
if (isset($_POST['RemCon'])) {

		$sql2= 'DELETE FROM routes_hops WHERE hop_id="' . $_POST['ID'] . '"';
            mysqli_query($con, $sql2);
            if (mysqli_query($con, $sql2)) {
        $sql = 'DELETE FROM hops WHERE hop_name="' . $_POST['ConDel'] . '"';
        	mysqli_query($con,$sql);
		}
        if (mysqli_query($con, $sql)) {	
		header('Location: index.php?DelCon=1');
            exit;
}
}
?>
