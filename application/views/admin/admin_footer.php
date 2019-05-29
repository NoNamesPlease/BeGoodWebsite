
            </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->


    <!-- Theme JS files -->
    <script type="text/javascript" src="<?=ASSETS?>js/pages/form_inputs.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>js/pages/datatables_basic.js"></script>
    <!-- /theme JS files -->


    <!-- Confirm JS files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    
    <script>
        function notifyMe(class_type, text){  
            $(".msg-text").remove();
            var msg_html;
            if(class_type == "error")
                msg_html = '<div class="msg-text alert alert-danger no-border"><button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+text+'</div>';
            else if(class_type == "success")
                msg_html = '<div class="msg-text alert alert-success no-border"><button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+text+'</div>';
            else if(class_type == "warning")
                msg_html = '<div class="msg-text alert alert-warning no-border"><button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+text+'</div>';
            $(".alert_messages").prepend(msg_html);
            $(".msg-text").fadeIn('slow');
            setTimeout( function(){ $(".msg-text").fadeOut('slow'); } ,4000) 
        }
    </script>
    
    </body>
</html>