$('#loginForm').on('submit', () => {
  $.ajax({
    type: "POST",
    url: "./php/login.php",
    dataType: "JSON",
    data: $('#loginForm').serialize(),
    success: function(data){
      if (data.status === 'success') {
        window.location = 'customer/index.php';
      } else {
        $('.errorMessage').fadeIn().html(data.message);
      }
    },
  });
  return false;
});

$('#signupForm').on('submit', () => {
  $.ajax({
    type: "POST",
    url: "./php/signup.php",
    dataType: "JSON",
    data: $('#signupForm').serialize(),
    success: function(data) {
      if (data.status === 'success') {
        $('#signupForm').slideUp();
        $('.successMessage').fadeIn().html(data.message);
        $('.errorMessage').fadeOut();
      } else {
        $('.errorMessage').fadeIn().html(data.message);
      }
    }
  });

  return false;
});
