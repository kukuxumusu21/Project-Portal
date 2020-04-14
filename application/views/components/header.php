<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    <base href="<?php echo base_url();?>">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR;?>/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR;?>/css/jquery.fancybox.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().RES_DIR;?>/css/custom.css"/>
    <!-- <link type="text/css" rel="stylesheet" href="<?php //echo base_url().RES_DIR;?>/css/bootstrap.reponsive.min.css"/> -->
    
    <script src="<?php echo base_url().RES_DIR; ?>/js/jquery.min.js"></script>
    <script src="<?php echo base_url().RES_DIR; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url().RES_DIR; ?>/js/jquery.fancybox.min.js"></script>

    <script type="text/javascript">
    $(function() { // Shorthand for $(document).ready(function() {
        $('.nav li').click(function() {
            $('.nav li').removeClass('active'); 
            $(this).addClass('active');
        });
    });
    </script>
</head>
<body>
    
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo anchor('','PROJ-PORTAL','class="brand"');?>
            <div class="nav-collapse collapse">
                <ul class="nav" id="">
                    <li class="divider-vertical"></li>
                        <li><?php echo anchor('website-apps','Website Apps');?></li>
                        <li><?php echo anchor('windows-apps','Windows Apps');?></li>
                </ul>

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if($this->authentication->is_signed_in()):?>
                                <i class="icon-user icon-white"></i> <?php echo $account->username;?> <b class="caret"></b>
                        <?php else:?>     
                                <i class="icon-user icon-white"></i> <b class="caret"></b></a>  
                        <?php endif;?>
                        <ul class="dropdown-menu">
                        <?php if($this->authentication->is_signed_in()):?>
                            <li><?php echo anchor('sign-out','Sign Out');?></li>
                        <?php else:?>
                            <li><?php echo anchor('c1fa236fb935cab74c8dbfabe3ffd06f','Sign In');?></li>
                        <?php endif;?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>