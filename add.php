<?php
    $title = $email = $ingredients = '';
    $errors= array('email'=>'','title'=>'','ingredients'=>'');
    

    //if(isset($_GET['submit']))
   // echo $_GET['email'];
    //echo $_GET['title'];
    //echo $_GET['ingredients'];
    if(isset($_POST['submit'])){
    //echo htmlspecialchars($_POST['email']);
    //echo htmlspecialchars($_POST['title']);
    //echo htmlspecialchars($_POST['ingredients']);
    //check the email
    if(empty($_POST['email'])){
        $errors['email'] =  'An email is required . <br>';
    }else{
        $email = $_POST['email'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
          $errors['email']  = 'email must be a valid email address.';
        }
    }
    //check the title
    if(empty($_POST['title'])){
        $errors['title'] =  'An title is required . <br>';
    }else{
       $title = $_POST['title'];
       if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
        $errors['title'] = 'title must be letters and spaces only';
       }
    }
    //check the email
    if(empty($_POST['ingredients'])){
        $errors['ingredients'] = 'At least one ingredients. <br>';
    }else{
        $ingredients = $_POST['ingredients'];
       if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingredients)){
        $errors['ingredients'] =  'Ingredients must be a comma separated list';
       }
    }
    if(array_filter($errors)){
        //echo 'errors in the form';
    } else {
        //echo 'form is valid';
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
        //create sql
        $sql = "INSERT INTO pizzas(title,email,ingredients)  VALUES('$email' , '$title' , '$ingredients') ";
        //save to db and check
        if(mysqli_query($conn,$sql)){
            //success
            header('Location : index.php');
        }else{
            //error
            echo 'query error'. mysqli_error($conn);
        }

      
    }

    }//end of the post check



?>
<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php');?>

<section class="container grey-text">
    <h4 class="center">Add Pizza</h4>
    <form action="add.php" class="white" method="POST">
        <label for="">Your Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
        <label for="">Pizza Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>
        <label for="">Ingredients(comma separated:)</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?> ">
        <div class="red-text"><?php echo $errors['ingredients'] ; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>



<?php include('templates/footer.php');?>




    




    

</html>