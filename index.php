<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Yuk Ujian - Home</title>

    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
</head>

<body>
    <?php include_once("/Support/action/connect.php"); ?>
    <script src="Support/js/Global.js"></script>
    <script src="Support/jquery-3.2.1.min.js"></script>
    <script src="Support/js/bootstrap.min.js"></script>
    
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
                <ul class="nav navbar-nav navbar-mid">
                    <li>
                        <p class="navbar-text">Login</a>
                    </li>
                </ul>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" id="nowTime">Sedang Memuat...</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="Support/action/Login.php" class="form-signin" style="margin-top:8%">
                    <h2 class="form-signin-heading">Login</h2>
                    <label for="name">Identitas</label>
                    <select id="UserLevel" name="UserLevel" class="form-control">
                        <option value="0">Siswa</option>
                        <option value="1">Guru</option>
                    </select>
                    <br>
                    <label for="UserId" class="sr-only">Username</label>
                    <input type="text" id="UserId" name="UserId" class="form-control" placeholder="Username" required autofocus>
                    <label for="UserPassword" class="sr-only">Kata Sandi</label>
                    <input type="password" id="UserPassword" name="UserPassword" class="form-control" placeholder="Kata Sandi" required>
                    <button id="submit-btn" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    <button class="btn btn-lg btn-primary btn-warning btn-block" type="button" onclick="location.href='Reg.php'">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
