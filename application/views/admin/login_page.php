<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Be Good Admin Panel</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/colors.css" rel="stylesheet" type="text/css">
    <link href="<?=ASSETS?>/css/admin-style.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?=ASSETS?>/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script type="text/javascript" src="<?=ASSETS?>/js/core/app.js"></script>
    <!-- /theme JS files -->

</head>

<body class="login-container">

    <!-- Main navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            </ul>
        </div>

    
    </div>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    <!-- Simple login form -->
                    <form action="<?=site_url('admin/login')?>" method="post" id="login_form" name="login_form">
                        <div class="panel panel-body login-form">
						<img class="admin-login-logo" src="<?=FRNT_ASSETS?>images/blue-bg.png">
                            <div class="text-center">								
                                <h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
                            </div>

                            <?php if($this->session->flashdata('flash_success')){ ?>                            
                            <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold"><?php echo $this->session->flashdata('flash_success'); ?></span>
                            </div>
                            <?php } ?>

                            <?php if($this->session->flashdata('flash_error')){ ?>
                            <div class="alert alert-danger alert-styled-left alert-bordered">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                        <span class="text-semibold"><?php echo $this->session->flashdata('flash_error'); ?></span>
                            </div>
                            <?php } ?>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="email" class="form-control" name="email" placeholder="Username">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
                            </div>

<!--                             <div class="text-center">
                                <a href="login_password_recover.html">Forgot password?</a>
                            </div>
 -->                        </div>
                    </form>
                    <!-- /simple login form -->


                    <!-- Footer -->
                    <div class="footer text-muted text-center">
                        &copy; 2018. <a href="#">Be Good </a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

<script type="text/javascript" src="<?=ASSETS?>/other/jquery.validate.min.js"></script>

<script type="text/javascript">

    jQuery(document).ready(function()
    {
        jQuery("#login_form").validate({
            focusInvalid: false,
            onkeyup: false,            
            onfocusout: function (element) {
                $(element).valid();
            },
            errorElement: "div",
            rules: {
                email: {
                    required: true,
                    email: true,
                },              
                password: {
                    required: true,                    
                },
            },          
            submitHandler: function(form, e) {
                e.preventDefault();
                if ($(form).valid()) {                  
                    form.submit();
                }
            },
            errorPlacement: function(error, element) {
                if(element.parent().attr("class") == "fancy-form"){
                    error.insertAfter(element.closest(".fancy-form"));
                }else{
                    error.insertAfter(element);
                }
            },
        });
        
        // forget password form validation 
        $("#frm_forget_password").validate({
           focusInvalid: false,
            onkeyup: false,            
            onfocusout: function (element) {
                $(element).valid();
            },
            errorElement: "div",
            rules: {
                fp_email: {
                    required: true,
                    email: true,
                },                
            },          
            submitHandler: function(form, e) {
                e.preventDefault();
                if ($(form).valid()) {                  
                    form.submit();
                }
            },
            errorPlacement: function(error, element) {
                if(element.parent().attr("class") == "fancy-form"){
                    error.insertAfter(element.closest(".fancy-form"));
                }else{
                    error.insertAfter(element);
                }
            },
        });
        
    }); 
    /**
    *@uses function to load forget password modal
    **/ 
    function forget_password(){
        $("#frm_forget_password").validate().resetForm();
        $("#frm_forget_password")[0].reset();
        $("#fp_modal").modal('show');
    }

</script>


</body>
</html>