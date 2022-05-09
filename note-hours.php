<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$user = $project = $hour = $date = "";
$user_err = $project_err = $hour_err = $date_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate user
    if(empty(trim($_POST["user"]))){
        $user_err = "Selecteer een gebruikersnaam.";     
    } else{
        $user = trim($_POST["user"]);
    }

    // Validate project
    if(empty(trim($_POST["project"]))){
        $project_err = "Selecteer een project.";     
    } else{
        $project = trim($_POST["project"]);
    }

    // Validate hour
    if(empty(trim($_POST["hour"]))){
        $hour_err = "Vul je uren in.";     
    } else{
        $hour = trim($_POST["hour"]);
    }

    // Validate date
    if(empty(trim($_POST["date"]))){
        $date_err = "Selecteer een datum.";     
    } else{
        $date = trim($_POST["date"]);
    }

    // Check input errors before inserting in database
    if(empty($user_err) && empty($project_err) && empty($hour_err) && empty($date_err)){
            
        // Prepare an insert statement
        $sql = "INSERT INTO `registerd-hours` (user, project, hour, date) VALUES (?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_user, $param_project, $param_hour, $param_date);
            
            // Set parameters
            $param_user = $user;
            $param_project = $project;
            $param_hour = $hour;
            $param_date = $date;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: registerd-hours.php");
            } else{
                echo "Oops! Er is iets fout gegaan. Probeer het later opnieuw.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
} 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uren Registreren</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Uren Registreren</h2>
        <h9>Vul dit in om je uren te registreren.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Gebruiker</label>
                <input type="text" name="user" class="form-control <?php echo (!empty($user_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user; ?>">
                <span class="invalid-feedback"><?php echo $user_err; ?></span>
            </div>
            <div class="form-group">
                <label>Project</label>
                <input type="text" name="project" class="form-control <?php echo (!empty($project_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $project; ?>">
                <span class="invalid-feedback"><?php echo $project_err; ?></span>
            </div>
            <div class="form-group">
                <label>Uren</label>
                <input type="time" name="hour" class="form-control <?php echo (!empty($hour_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $hour; ?>">
                <span class="invalid-feedback"><?php echo $hour_err; ?></span>
            </div>
            <div class="form-group">
                <label>Datum</label>
                <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                <span class="invalid-feedback"><?php echo $date_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Taak toevoegen">
                <a class="btn btn-link ml-2" href="registerd-hours.php">Annuleren</a>
            </div>
        </form>
    </div>
</body>
</html>