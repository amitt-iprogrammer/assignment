<?php
require_once 'config.php';
 
$name = $aboutyou = $birthday = "";
$name_err = $aboutyou_err = $birthday_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }

    $input_country = trim($_POST["country"]);
    if(empty($input_country)){
        $country_err = 'Please enter an Country.';     
    } else{
        $country = $input_country;
    }
    
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = 'Please enter an Email.';     
    } else{
        $email = $input_email;
    }
    
    $input_mobile = trim($_POST["mobile"]);
    if(empty($input_mobile)){
        $mobile_err = 'Please enter an Mobile.';     
    } else{
        $mobile = $input_mobile;
    }

    $input_aboutyou = trim($_POST["aboutyou"]);
    if(empty($input_aboutyou)){
        $aboutyou_err = 'Please enter an aboutyou.';     
    } else{
        $aboutyou = $input_aboutyou;
    }
    
    $input_birthday = trim($_POST["birthday"]);
    if(empty($input_birthday)){
        $birthday_err = "Please enter the birthday.";     
    } else{
        $birthday = $input_birthday;
    }

    if(empty($name_err) && empty($aboutyou_err) && empty($birthday_err)){
        $sql = "UPDATE user_detail SET name=?, country=?, email=?, mobile=?, aboutyou=?, birthday=? WHERE id=?";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("sssssss", $param_name, $param_country, $param_email, $param_mobile, $param_aboutyou, $param_birthday, $param_id);
            
            $param_name = $name;
            $param_country = $country;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_aboutyou = $aboutyou;
            $param_birthday = $birthday;
            $param_id = $id;
            
            if($stmt->execute()){
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        $stmt->close();
    }

    $mysqli->close();
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM user_detail WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $param_id);
            
            $param_id = $id;
            
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    $name = $row["name"];
                    $country = $row["country"];
                    $email = $row["email"];
                    $mobile = $row["mobile"];
                    $aboutyou = $row["aboutyou"];
                    $birthday = $row["birthday"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
        $mysqli->close();
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                            <label>Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            <span class="help-block"><?php echo $country_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required >
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mobile_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                            <span class="help-block"><?php echo $mobile_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($aboutyou_err)) ? 'has-error' : ''; ?>">
                            <label>About you</label>
                            <textarea name="aboutyou" class="form-control"><?php echo $aboutyou; ?></textarea>
                            <span class="help-block"><?php echo $aboutyou_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($birthday_err)) ? 'has-error' : ''; ?>">
                            <label>Birthday</label>
                            <input type="date" name="birthday" class="form-control" value="<?php echo $birthday; ?>">
                            <span class="help-block"><?php echo $birthday_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
