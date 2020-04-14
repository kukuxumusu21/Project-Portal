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
                <ul class="nav">
                    <li class="divider-vertical"></li>
                        <li><?php echo anchor('home','Website Apps');?></li>
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
                            <li><?php echo anchor('sign-in','Sign In');?></li>
                        <?php endif;?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>