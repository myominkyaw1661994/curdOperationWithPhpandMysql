<?php 

	session_start();
	include 'config.php';

	$update = false;

	$id = "" ;
	$name ="";
	$email ="";
	$phone ="";
	$image ="";
	


	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$image = $_FILES['image']['name'];


			
		$imageName = explode('.', $image);
		$extend = strtolower(end($imageName));

		$realName = uniqid('', true).'.'.$extend;

		$upload = "uploads/".$realName;

		$query = "INSERT INTO users(name, email, phone, image) VALUES(?,?,?,?)";

		$stmt = $conn->prepare($query);
		$stmt->bind_param('ssss', $name, $email, $phone, $realName);
		$stmt->execute();
		move_uploaded_file($_FILES['image']['tmp_name'], $upload);

		header("Location: index.php");
		
		$_SESSION['response'] = "Sucessfully Inserted to the database";
		$_SESSION['res-type'] = "success";
	}

	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

		$imagequery = "SELECT * FROM users WHERE id=?";
		$stmt1 = $conn->prepare($imagequery);
		$stmt1->bind_param('i', $id);
		$stmt1->execute();

		$result = $stmt1->get_result();
		$row = $result->fetch_assoc();

		$that_want_to_delete = $row['image'];
		$paht = "uploads/".$that_want_to_delete;

		unlink($paht);


		$query = "DELETE FROM users WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();

		header("Location: index.php");
		$_SESSION['response'] = "Sucessfully delete to the database";
		$_SESSION['res-type'] = "danger";		
	}

	if(isset($_GET['edit'])){
		$id= $_GET['edit'];

		$query = "SELECT * FROM users WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$id = $row['id'];
		$name = $row['name'];
		$email = $row['email'];
		$phone = $row['phone'];
		$image = $row['image'];

		$update = true;
	}


	if(isset($_POST['update'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$oldimage= $_POST['oldImage'];


		if(isset($_FILES['image']['name'])&& ($_FILES['image']['name'] != "")){
			unlink("uploads/".$oldimage);
			$newimage = explode('.', $_FILES['image']['name']);
			$extend = strtolower(end($newimage));

			$gen_name = uniqid('', true).".".$extend;
			$path = "uploads/".$gen_name;

			move_uploaded_file($_FILES['image']['tmp_name'], $path);

		}else{
			$gen_name = $oldimage;
		}

		$query = "UPDATE users SET name=?, email=?, phone=?, image=? WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssssi", $name, $email, $phone, $gen_name, $id);
		$stmt->execute();

		header("Location: index.php");
		$_SESSION['response'] = "Sucessfully update to the database";
		$_SESSION['res-type'] = "info";	
		
	}

	if(isset($_GET['detail'])){
		$id = $_GET['detail'];

		$query = "SELECT * FROM users WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$vid = $row['id'];
		$vname = $row['name'];
		$vemail = $row['email'];
		$vphone = $row['phone'];
		$vimage = $row['image'];

		


	}

 ?>