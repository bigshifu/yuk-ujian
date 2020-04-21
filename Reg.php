<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Yuk Ujian - Daftar</title>

  <link href="Support/css/bootstrap.min.css" rel="stylesheet">
  <link href="Support/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
</head>

<body>
  <script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.js"></script>
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="Support/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Support/js/dialog.min.js"></script>
  <script src="Support\js\Global.js"></script>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
          aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Yuk Ujian</a>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="index.php">Kembali ke login</a>
          </li>
        </ul>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a id='nowTime' href="#">Sedang Memuat..</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:6%">
        <form>

            <label for="name">Identitas</label>
                <select id="UserLevel" name="UserLevel" class="form-control">
                    <option value="0">Siswa</option>
                    <option value="1">Guru</option>
                </select>
                <br>

            <div class="form-group has-feedback">
                <label for="username">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input id="username" name="UserName" class="form-control" placeholder="Masukkan nama anda" maxlength="20" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="userid">Username</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                    <input id="userid" name="UserId" class="form-control" placeholder="Masukkan username" maxlength="20" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="password">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="password" name="Password" class="form-control" placeholder="*******" maxlength="20" type="password">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="passwordConfirm">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="passwordConfirm" name="Confirm" class="form-control" placeholder="*******" maxlength="20" type="password">
                </div>
                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="DAFTAR">
            </div>

            <div class="form-group">
                <input value="Reset" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>
    </div>
</div>

  </div>
  
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="Support/js/bootstrap.min.js"></script>

  <script>
var regUsername = /^[a-zA-Z\u0020]+$/;
var password;
var check = [false, false, false, false];

//Dipanggil jika sukses
function success(Obj, counter) {
    Obj.parent().parent().removeClass('has-error').addClass('has-success');
    $('.tips').eq(counter).hide();
    $('.glyphicon-ok').eq(counter).show();
    $('.glyphicon-remove').eq(counter).hide();
    check[counter] = true;

}

//Dipanggil jika gagal
function fail(Obj, counter, msg) {
    Obj.parent().parent().removeClass('has-success').addClass('has-error');
    $('.glyphicon-remove').eq(counter).show();
    $('.glyphicon-ok').eq(counter).hide();
    $('.tips').eq(counter).text(msg).show();
    check[counter] = false;
}

//Memeriksa nama lengkap
$('.container').find('input').eq(0).change(function () {

    if (regUsername.test($(this).val())) {
        success($(this), 0);
    } else if ($(this).val().length < 2) {
        fail($(this), 0, 'Nama terlalu pendek, min. 2 karakter');
    } else {
        fail($(this), 0, 'Nama hanya boleh berupa huruf')
    }

});

$('.container').find('input').eq(1).change(function () {

    if ($(this).val().toString().length < 4) {
        fail($(this), 1, 'Username min. 4 karakter');
        return;
    }
    
    ///memeriksa ketersediaan username
    var UserId = $(this).val();
    var Level = $("#UserLevel option:selected").val();
    $.ajax({
        type: "POST",
        url: "Support/action/RegCheck.php",
        dataType: "JSON",
        data: {
                "Level"  : Level,
                "UserId" : UserId
            },
        success: function (data) {
            if(data.success==1){
                success($(this), 1);
            }else{
                fail($(this), 1, 'Username sudah digunakan');
            }
        }
    });
});



//Memeriksa Kata Sandi
$('.container').find('input').eq(2).change(function () {

    password = $(this).val();

    if ($(this).val().length < 8) {
        fail($(this), 2, 'Kata Sandi min. 8 karakter');
    } else {
        success($(this), 2);
    }
});


// Verifikasi Kata Sandi
$('.container').find('input').eq(3).change(function () {

    if ($(this).val() == password) {
        success($(this), 3);
    } else {
        fail($(this), 3, 'Kata sandi tidak cocok');
    }
});


$('#submit').click(function (e) {
    if (!check.every(function (value) {
        return value == true
    })) {
        alert("WRONG");
        e.preventDefault();
        for (key in check) {
            if (!check[key]) {
                $('.container').find('input').eq(key).parent().parent().removeClass('has-success').addClass('has-error')
            }
        }
    }else{
      var UserName = $('#username').val();
      var Password = md5($('#password').val());
      var Confim = $('#passwordConfirm').val();
      var UserId = $('#userid').val();
      var UserLevel = $('#UserLevel').val();

      $.ajax({
          type: "POST",
          url: "Support/action/SignUp.php",
          dataType: "JSON",
          data: {
              "UserName": UserName,
              "Password": Password,
              "UserId": UserId,
              "UserLevel":UserLevel
          },
          success: function (data) {
            if(data['success']==1){
                //alert(data['message']);
                dialog.tip("Akun berhasil dibuat", data.message,function(){window.location.href = "index.php";});
            }else{
                //alert(data['message']);
                dialog.tip("Pendaftaran gagal", data.message,function(){document.getElementById('reset').click();});
            }
          }
      })
    }
});

$('#reset').click(function () {
    $('input').slice(0, 6).parent().parent().removeClass('has-error has-success');
    $('.tips').hide();
    $('.glyphicon-ok').hide();
    $('.glyphicon-remove').hide();
    check = [false, false, false, false, false, false,];
});

</script>


</body>

</html>