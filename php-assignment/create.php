<?php
require_once 'config.php';
 
$name = $aboutyou = $birthday = "";
$name_err = $aboutyou_err = $birthday_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        $aboutyou_err = 'Please enter an about you.';     
    } else{
        $aboutyou = $input_aboutyou;
    }
    
    $input_birthday = trim($_POST["birthday"]);
    if(empty($input_birthday)){
        $birthday_err = "Please enter the Birthday.";     
    } else{
        $birthday = $input_birthday;
    }
    
    if(empty($name_err) && empty($aboutyou_err) && empty($country_err) && empty($birthday_err)){
		
        $sql = "INSERT INTO user_detail (name, country, email, mobile, aboutyou, birthday) VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ssssss", $param_name, $param_country, $param_email, $param_mobile, $param_aboutyou, $param_birthday);
            
            $param_name = $name;
            $param_country = $country;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_aboutyou = $aboutyou;
            $param_birthday = $birthday;
            
            
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add user record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
