var signUpView ="<form class='form-1' method = 'post' action = 'register_result.php'><p class='field'><input type='text' name='login' placeholder='Your Student ID ex.b01705001'><i class='icon-user icon-large'></i></p><p class='field'><input type='password' name='password' placeholder='Password'><i class='icon-lock icon-large'></i></p><p class='field'><input type='password' name='password' placeholder='Confirm Password'><i class='icon-lock icon-large'></i></p><p class='submit'><button class='sign_btn' type='submit' name='submit'><i class='icon-arrow-right icon-large'></i></button></p></form>";

var loginView="<form class='form-1' action='index_login.html'><p class='field'><input type='text' name='login' placeholder='Your Student ID ex.b01705001'><i class='icon-user icon-large'></i></p><p class='field'><input type='password' name='password' placeholder='Password'><i class='icon-lock icon-large'></i></p><p class='submit'><button type='submit' name='submit'><i class='icon-arrow-right icon-large'></i></button></p></form>";

$('.signup').click(function (e) {
console.log("click");
   $('.main').html(signUpView);
})
$('.login').click(function (e) {
console.log("click");
   $('.main').html(loginView);
})


