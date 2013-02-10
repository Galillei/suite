<form action = '/index/' method="POST">
    <div class="form-row">
        <label for="login_root">Login:</label>
        <input name="login_root" type="text" id="login_root" class="validate max-length"/>
    </div>
    <div class="form-row">
        <label for="password_root">Password:</label>
        <input name="password_root" type="password" id="password_root"  class="validate email"/>
        <input type="hidden" value = '123' name = 'hidden'>
    </div>
    <div>
        <input type="submit" value = "LogIn">
    </div>
</form>