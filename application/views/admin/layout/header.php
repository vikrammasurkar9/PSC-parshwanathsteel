<?php
if (isset($_COOKIE['usertype'])) {
    if ($_COOKIE['usertype'] != "pscadmin") {
        header('Location: ' . base_url());
    }
   
}
else{
    header('Location: ' . base_url());
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from dreamguys.co.in/preclinic/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Mar 2019 05:10:28 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/favicon.ico">
    <title>PARSHWANATH ISPAT PVT LTD - Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/style.css">

    
    
		<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
    <!-- Bootstrap Star Rating CSS -->
	<!-- <link href='<?= base_url() ?>assets/bootstrap-star-rating/css/star-rating.min.css' type='text/css' rel='stylesheet'> -->

<!-- Custom CSS -->
<link href="<?= base_url() ?>assets/style.css" rel="stylesheet">

<!-- jQuery Library -->
<script src='<?= base_url() ?>assets/js/jquery-3.3.1.js' type='text/javascript'></script>

<!-- Bootstrap Star Rating JS -->
<!-- <script src='<?= base_url() ?>assets/bootstrap-star-rating/js/star-rating.min.js' type='text/javascript'></script> -->

    <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @keyframes fadein {
        from {
            bottom: 0;
            opacity: 0;
        }

        to {
            bottom: 30px;
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    @keyframes fadeout {
        from {
            bottom: 30px;
            opacity: 1;
        }

        to {
            bottom: 0;
            opacity: 0;
        }
    }

    .modal-open .container-fluid, .modal-open  .container {
    -webkit-filter: blur(5px) grayscale(90%);
}

    </style>
    <div id="snackbar"></div>
</head>

<body>
    <div class="main-wrapper">
        <div class="header" id="header" style="background-color:<?= $_COOKIE['firmcolor'];?>">
            <div class="header-left">
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="logo">
                    <span>PARSHWANATH GROUP</span>
                </a>
            </div>
            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
           <ul class="nav user-menu float-right">
                    <li class="nav-item dropdown has-arrow" style="width:400px">
                        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                            <span class="user-img">
                                <i class="fa fa-industry"></i>
                            </span>
                            <span>
                                <?php if(isset($_COOKIE['firm'])) 
                              {
                                  echo $_COOKIE['firm'];
                                  
                              }
                                  ?>

                            </span>
                        </a>
                        <div class="dropdown-menu">

                            <?php
                                        foreach($firms as $firm)
                                        { ?>
                            <a class="dropdown-item"
                                onClick="SetCookieForFirm('firm','<?= $firm->firm;?>','<?= $firm->id;?>','<?= $firm->firmcolor;?>')"><?= $firm->firm;?></a>
                            <?php  }
                                    ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                            <span class="user-img">
                                <i class="fa fa-user-circle"></i>
                            </span>
                            <span>
                                <?php if(isset($_COOKIE['usertype'])) 
                              {
                                  echo $_COOKIE['name'];
                                  
                              }
                                  ?>

                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= base_url('login/logout');?>">Logout</a>
                        </div>
                    </li>
                </ul>
        </div>
        <script>
        function returnConfirm() {
            return confirm("Are you sure to delete?");
        }

        function showSnackbar(message) {
            var x = document.getElementById("snackbar");
            x.innerText = message;
            x.className = "show";
            setTimeout(function() {
                x.className = x.className.replace("show", "");
            }, 3000);
        }
        </script>
        <?php
              if ($this->session->flashdata('exist_msg')) {
                  echo "<script>showSnackbar('" . $this->session->flashdata('exist_msg') . "');</script>"; 
              }                    
              if($this->session->flashdata('success_msg')){
                  echo "<script>showSnackbar('" . $this->session->flashdata('success_msg') . "');</script>"; 
              }
              if($this->session->flashdata('delete_msg')){
                echo "<script>showSnackbar('" . $this->session->flashdata('delete_msg') . "');</script>"; 
            }
            ?>