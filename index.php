<?php 
  include 'action.php';

  $addone = 1;
?>

<!DOCTYPE >
<html>
<head>
	<title>CRUD</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<!-- nav bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-dark ">
  <a class="navbar-brand text-white" href="index.php">CRUD</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link text-white" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    <!--   <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<!-- nav Bar -->
<!-- form -->
	<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<h3 class="text-center text-dark mt-2">Advanced CRUD App Using Php and Mysql Prepared Statment Object Oriented</h3>
          <hr>

          <!-- Start of alert  -->
            <?php if(isset($_SESSION['response'])) {?>
            <div class="alert alert-<?= $_SESSION['res-type']?> alert-dismissible text-center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $_SESSION['response'] ?>
            </div>

            <?php } unset($_SESSION['response'])?>

          <!-- End of alert -->  
				</div>
			</div>
			<div class="row">
		<div class="col-md-4">
			<h3 class="text-center text-info mt-3">Add Record</h3>
			<form class="ml-4" method="POST" action="action.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=$id;?>">
				<div class="form-group">
					<input type="text" name="name" class="form-control" value="<?= $name ?>" placeholder="Enter name" required="true">
				</div>

				<div class="form-group">
					<input type="text" name="email" class="form-control" value="<?= $email ?>" placeholder="Enter a email" required="true">
				</div>

				<div class="form-group">
					<input type="text" name="phone" class="form-control" value="<?= $phone ?>"placeholder="Enter a phone" required="true">
				</div>

				<div class="form-group">
          <input type="hidden" name="oldImage" value="<?=$image?>">
					<input type="file" name="image" class="custom-file">
          <?php if($update){?>
            <p>Orignal image: </p>
            <img src="uploads\<?= $image?>" width="120">
          <?php }?>
				</div>

				<div class="form-group">
          <?php if($update){?>
          <input type="submit" name="update" class="btn btn-success btn-block" value="Update">  
        <?php } else{?>
					<input type="submit" name="add" class="btn btn-primary btn-block" value="Add">
        <?php }?>
				</div>

			</form>
<!-- form -->

		</div>	
		<div class="col-md-8">

      <?php 
        $query = "SELECT * FROM users";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();


       ?>

			<h3 class="text-center text-info mt-3">Record Present in the Database</h3>
			<!-- Start of the table -->

		<table class="table">
  				<thead>
   					 <tr>
      					 <th scope="col">#</th>
      					 <th scope="col">Image</th>
     					 <th scope="col">Name</th>
     					 <th scope="col">Email</th>
     					 <th scope="col">Phone</th>
               <th>Action</th>
    				  </tr>
  				</thead>
  				<tbody>
            <?php while($row = $result->fetch_assoc()){ ?>
    			<tr>
      				<!-- <td><?=$row['id'];?></td>  -->
              <td><?= $addone++;  ?></td>
      				<td><img src="uploads\<?=$row['image'];?>" width="25"></td>
      				<td><?=$row['name'];?></td>
      				<td><?=$row['email'];?></td>
      				<td><?=$row['phone'];?></td>
              <td>
                <a href="details.php?detail=<?=$row['id'];?>" class="badge badge-primary p-2">Detail</a> |
                <a href="action.php?delete=<?=$row['id']; ?>" onclick="return confirm('Do you want to delete?');" class="badge badge-danger p-2">Delete</a> |
                <a href="index.php?edit=<?=$row['id'];?>" class="badge badge-success p-2">Edit</a> 
              </td>
    			</tr>

          <?php }?>
    
  				</tbody>
		</table>

			<!-- End of the table -->
		</div>	

	</div>

</div>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>