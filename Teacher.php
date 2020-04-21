<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Yuk Ujian - Guru</title>

    <!-- Bootstrap -->
    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
    <link href="Support/css/dashboard.css" rel="stylesheet">

    <link rel="stylesheet" href="Support/css/Pages.css" />
    <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
    <script src="Support/jquery-3.2.1.min.js"></script>
</head>

<body>
    <script src="Support/js/pages.js"></script>
    <script src="Support/js/Ques_List.js"></script>
    <script src="Support/js/QsetAdd.js"></script>
    <?php include_once("Support/action/connect.php"); session_start(); ?>
    <?php if(!isset($_SESSION['level'])){
                echo "<b><center><font size='30px'>Akses Ditolak: Belum Login</font></center></b>"; 
                return; 
            }else if($_SESSION['level']!=1){
                echo "<b><center><font size='30px'>Akses Ditolak: Bukan Guru</font></center></b>"; 
                return; 
            } 
    ?>
    <script src="Support\js\Global.js"></script>
    <script src="Support/jquery-3.2.1.min.js"></script>
    <script src="Support/js/bootstrap.min.js"></script>
    <script src="Support/js/Teacher.js"></script>
    <script type="text/javascript" src="Support/js/dialog.min.js"></script>
   
    <p id="thisNav" style="display:none">1</p>
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
                    <p class="navbar-text" style="color:white">Halo，<?php echo $_SESSION['UserName']; ?></p>
                    <li>
                        <a style="color:rgb(0, 255, 98)" href="Support/action/Logout.php">Log Out</a>
                    </li>
                </ul>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" id="nowTime">Sedang Memuat..</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li id="click1">
                        <a>欢迎使用
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li id="click2">
                        <a>Skor Siswa</a>
                    </li>
                    <li id="click3">
                        <a>Cari Pertanyaan</a>
                    </li>
                    <li id="click4">
                        <a>Masukkan Pertanyaan</a>
                    </li>
                    <li id="click5">
                        <a>快速组卷</a>
                    </li>
                </ul>
            </div>

            <div id="info1">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Halo</h1>

                    <h2 class="sub-header"> 本次登录时间 </h2>
                    <font size="6px">
                    <?php
                        include_once("Support/action/connect.php");
                        $UserId = $_SESSION['UserId'];
                        $a = mysqli_fetch_array(mysqli_query($con, "SELECT MAX(loginTime) as LoginTime FROM loginhistory WHERE stuid=$UserId AND isTeacher=1;"));
                        echo $a['LoginTime'];
                        mysqli_close($con);
                    ?>
                    </font>
                    <div id="content">
                        <div class="table-responsive">
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manajemen Siswa -->
            <div id="info2" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Manajemen Siswa</h1>

                    <div id="search" style="width:50%">
                        <form role="form" onsubmit="return false;">
                            <h2 class="sub-header">Pencarian
                                <button type="button" id="search" class="btn btn-primary">Pertanyaan</button>
                            </h2>
                            <div class="input-group">
                                <span class="input-group-addon">Nama</span>
                                <input type="text" id="SearchName" class="form-control" placeholder="Masukkan nama siswa">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Username</span>
                                <input type="text" id="SearchId" class="form-control" placeholder="Masukkan username">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Rentang Skor</span>
                                <input type="text" id="SearchScore1" class="form-control" placeholder="Min">
                                <span class="input-group-addon">to</span>
                                <input type="text" id="SearchScore2" class="form-control" placeholder="Maks">
                            </div>
                        </form>
                    </div>

                    <h2 class="sub-header">Informasi Siswa</h2>
                    <div id="content_Stu">
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
                                        <td width="25%">Username</td>
                                        <td width="25%">Nama</td>
                                        <td width="25%">Login Terakhir</td>
                                        <td width="25%">Total Skor</td>
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
                    </div>
                </div>
            </div>

            <!-- Telusuri Pertanyaan -->
            <div id="info3" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Telusuri Pertanyaan</h1>

                    <h2 class="sub-header">Pilih Set Soal
                        <select id="choose_set" name="choose_set" class="dropdown">
                        </select>
                    </h2>

                    <div id="content">
                        <div >
                        <div >
                            <input type="hidden" id="currentPage_Ques" value="1">
                            <input type="hidden" id="totalPages_Ques" value="">
                            <table class="table table-bordered table-hover table-striped table-condensed">            
                                <thead>
                                    <tr>
                                        <td width="20%">Nomor</td>
                                        <td width="20%">Skor</td>
                                        <td width="20%">Penerbit</td>
                                        <td width="20%">Dibuat</td>
                                        <td width="20%">Operasi</td>
                                    </tr>
                                    <tr id="tip_Ques" style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>            
                                <tbody id="Ques_List">                
                                </tbody>
                            </table>
                            <div class="list-div-Ques">        
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Memasukkan Pertanyaan -->
            <div id="info4" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Memasukkan Pertanyaan(Pilihan Ganda)</h1>

                    <h3 class="sub-header">Silahkan Masukkan Judul</h3>

                    <div class="input-group" style="width:60%;margin-left:20%">
                        <span class="input-group-addon">Skor</span>
                        <input type="number" id="this_score" name="this_score" class="form-control" placeholder="Masukkan bilangan bulat">
                    </div>

                    <div class="input-group" style="width:60%;margin-left:20%">
                        <span class="input-group-addon">Konten Topik</span>
                        <textarea type="textarea" id="this_content" name="this_content" class="form-control" placeholder="Masukkan konten pertanyaan" rows="5" style="resize:none">
                        </textarea>
                    </div>

                    <h3 class="sub-header">Silahkan tentukan opsi, dan tandai jawaban yang benar
                        <button class="btn btn-primary" id="add_new_choose">Tambah Opsi Baru</button>
                        <button class="btn btn-success" id="submit_question">Kirim Pertanyaan Ini</button>
                    </h3>

                    <div id="chooses">
                        <div id="add_choose" class="input-group" style="width:60%;margin-left:20%">
                            <span id="choose_no" class="input-group-addon">Opsi Alternatif</span>
                            <input type="text" name="choices" class="form-control" placeholder="Masukkan Opsi">
                            <span class="input-group-addon">
                                <input type="checkbox" name="options" id="option1" value=0> Tandai dengan benar
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Buat Set Soal -->
    <div id="info5" style="display:none">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Lembar Jawaban</h1>

            <h3 class="sub-header">
                Silakan masukkan informasi rangkaian pertanyaan
                <button class="btn btn-success" id="go_create_set">Kirim Lembar Jawaban</button>
            </h3>

            <div class="input-group" style="width:60%;margin-left:20%">
                <span class="input-group-addon">Nama Ujian</span>
                <input type="text" id="QsetName" class="form-control" placeholder="Masukkan Nama Ujian" />
            </div>

            <h3 class="sub-header">
                Silakan periksa pertanyaan yang akan ditambahkan ke set pertanyaan ini dari bank soal di bawah ini
            </h3>

            <table class="table table-bordered table-hover table-striped table-condensed">            
                <thead>
                    <tr>
                        <td width="10%">Nomor</td>
                        <td width="10%">Skor</td>
                        <td width="70%">Pratinjau</td>
                        <td width="10%">Tambah</td>
                    </tr>
                    <tr id="tip_Qset" style="display:none;">
                        <td colspan="4"></td>
                    </tr>
                </thead>            
                <tbody id="Ques_List_add">                
                </tbody>
            </table>

            <div id="content">
                <div class="table-responsive">
                            
                </div>
            </div>
        </div>
    </div>

    <script src="Support/jquery-3.2.1.min.js"></script>
    <script src="Support/js/bootstrap.min.js"></script>
    <script src="Support/js/nav.js"></script>
    <script src="Support/js/Question.js"></script>
</body>

</html>