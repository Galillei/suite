<form method="POST" class="form-validated">
    <div class="form-row">
        <label for="login">E-mail:</label>
        <input name="login" type="text" id="login" class="validate max-length"/>
    </div>
    <div class="form-row">
        <label for="password">Password:</label>
        <input name="password" type="password" id="password"  class="validate email"/>
    </div>
    <?php

    if(isset($error))
{
//    var_dump($error);
    echo '<div class="error-message"> ';
    echo($error);
    echo '</div>';
    }
?>
    <div>
        <input type="submit" value = "Register">
    </div>