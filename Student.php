<?php include_once("/Support/action/connect.php"); 
    session_start(); 
    if(isset($_SESSION['setid'])){
        unset($_SESSION['setid']);
    }
    if(!isset($_SESSION['level'])){
        echo "<b><center><font size='30px'>Akses Ditolak : Belum Login</font></center></b>"; 
        return; 
    }else if($_SESSION['level']!=0){
        echo "<b><center><font size='30px'>Akses Ditolak : Bukan Siswa</font></center></b>"; 
        return; 
    } 
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Yuk Ujian - Siswa</title>

    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
    <link rel="stylesheet" href="Support/css/Pages.css" />
</head>

<body>
    
    <script src="Support/jquery-3.2.1.min.js"></script>
    <script src="Support/js/Global.js"></script>
    <script src="Support/js/StuInfo.js"></script>
    <script type="text/javascript" src="Support/js/dialog.min.js"></script>

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
                    <p class="navbar-text">Halo，<?php echo $_SESSION['UserName']; ?>!</p>
                    <li>
                        <a style="color:rgb(0, 255, 98)" href="Support/action/Logout.php">Log Out</a>
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
            <div class="col-md-4">
                <div class="jumbotron">
                    <h1>Selamat Datang</h1>
                    <p>Nama ：<?php echo $_SESSION['UserName']; ?></p>
                    <p>Username : <?php echo $_SESSION['UserId']; ?> </p>
                    <p id="totalscore">Skor Total : Memuat..</p>
                    <br>
                    <p id="logintimetip">Waktu Login:</p>
                    <p id="logintime">Memuat..</p>
                    <p>
                        <select id="choose_set_test" name="choose_set_test" class="dropdown">
                            <option value='-1'>Silahkan pilih bank soal</option>
                        </select>
                        <a id="go_test" class="btn btn-primary btn-lg" role="button">
                            Jawab Sekarang</a>
                    </p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-primary" style="margin-right:12%;margin-top:8%">
                    <div class="panel-heading">
                        <h3 class="panel-title">Riwayat</h3>
                    </div>
                    <div class="panel-body">

                        <table class="table table-striped">
                            <caption>Pertanyaan Baru
                                <select id="choose_set_stu" name="choose_set_stu" class="dropdown">
                                    <option value='-1'>-all-</option>
                                </select>
                            </caption>
                            <div >
                            <input type="hidden" id="currentPage" value="1">
                            <input type="hidden" id="totalPages" value="">
                            <input type="hidden" id="search_id" value="">
                            <input type="hidden" id="search_name" value="">
                            <input type="hidden" id="search_score1" value="">
                            <input type="hidden" id="search_score2" value="">
                            <table class="table table-bordered table-hover table-striped table-condensed">            
                                <thead>
                                    <tr>
                                        <td width="20%">Nomor</td>
                                        <td width="20%">Skor</td>
                                        <td width="20%">Skor Saya</td>
                                        <td width="20%">Waktu</td>
                                        <td width="20%">Lihat</td>
                                    </tr>
                                    <tr id="tip" style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>            
                                <tbody id="GradeView">                
                                </tbody>
                            </table>
                            <div class="list-div">        
                            </div>
                        </div>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="Support/js/bootstrap.min.js"></script>
</body>

</html>