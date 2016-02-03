@extends('master')

@section('content')

<div id="app">

@include('sidebar')

<div class="app-content">
<!-- start: TOP NAVBAR -->
@include('header')

<!-- end: TOP NAVBAR -->
<div class="main-content" >
    <div class="wrap-content container" id="container">
        <!-- start: DASHBOARD TITLE -->
        @include('alerts.errors')
        <div id="message-error-div"></div>
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">Homework</h1>

                </div>
                <ul class="mini-stats col-sm-2 pull-right">

                    <li>
                        <div class="values">
                            <a href="/createHomework" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
                        </div>
                    </li>

                </ul>

            </div>
        </section>
        <!-- end: DASHBOARD TITLE -->
        <div class="container-fluid container-fullw bg-white">
            <a tabindex="0" class="btn btn-primary popover" role="button" data-toggle="popover1" data-trigger="focus" title="" data-content="And here some amazing content. It very engaging. Right?" data-original-title="Dismissible popover">
                Dismissible popover
                </a>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <div class="panel-body">
                        <ul class="timeline-xs" id="tmlin">

                        </ul>
                        <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
                    </div>
                </div>

            </div>


        </div>



    </div>
</div>

</div>

@include('footer')

@include('rightSidebar')


</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>


<script>

    jQuery(document).ready(function() {

        getMsgCount();

        Main.init();

        FormValidator.init();

        $('div#loadmoreajaxloader').show();

        pageCount=0;

        if(loaded){
            $('div#loadmoreajaxloader').html('<center>No more Homeworks to show.</center>');
            return;
        }
        ajaxCall();
        pageCount++;

    });

    var loaded = false;

    var pageCount=1;

    /*
     +   * Function Name: $(window).scroll
     +   * Param: -
     +   * Return: this is jquery method for scroll action
     +   * Desc: on each scroll it calls ajaxCall function.
     +   * Developed By: Suraj Bande
     +   * Date: 3/2/2016
     +   */

    $(window).scroll(function()
    {
        if ( $(window).scrollTop() == $(document).height() - $(window).height() )
        {

            $('div#loadmoreajaxloader').show();

            if(loaded){
                $('div#loadmoreajaxloader').html('<center>No more Homeworks to show.</center>');
                return;
            }

            ajaxCall();

            pageCount++;

        }

    });

    /*
     +   * Function Name: ajaxCall
     +   * Param: -
     +   * Return: called to load more listing
     +   * Desc: on each scroll or initially on loading it returns with records of listing with respective counts.
     +   * Developed By: Suraj Bande
     +   * Date: 3/2/2016
     +   */

    function ajaxCall(){

        $.ajax({

            url: "loadmore-homework/"+pageCount,

            success: function(html)
            {

                if(html.length!=0)
                {
                    var data= $.map(html,function(value,index){
                        return value;
                    });
                    for(var i=0; i<data.length; i++)
                    {

                        var str="";

                        str+='<li class="timeline-item">'+

                                '<div class="leaveSection">'+

                                    '<div class="text-muted text-small">'+

                                    '</div>'+

                                    '<div class="col-sm-8" style="margin-top: 4px;">'+

                                        '<h5><small class="label label-sm label-info">'+data[i]['first_name']+" "+data[i]['last_name']+'</small>'+" "+data[i]['title']+'</h5>';

                                        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                            "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
                                        ];

                                        var date_ = new Date(data[i]["created_at"]);

                                        var createdAt= date_.getDay()+" "+monthNames[date_.getMonth()]+" "+date_.getFullYear();

                                        var due_ = new Date(data[i]["due_date"]);

                                        var dueDate= due_.getDay()+" "+monthNames[due_.getMonth()]+" "+due_.getFullYear();

                                        str+='<p>Date:<i>'+createdAt+'</i> <br> Due Date:<i>'+dueDate+' </i></p>'+

                                    '</div>';

                                    if(data[i]['status']==0)
                                    {
                                        str+='<a href="/delete-homework/'+data[i]["homework_id"]+'" class="btn btn-primary btn-red pull-left"><i class="glyphicon glyphicon-trash"></i></a>';
                                    }

                                str+='<div class="col-sm-2">';

                                    if(data[i]['status']==0)
                                    {
                                        str+='<small class="label label-sm label-danger">saved to draft</small>';
                                    }else{
                                        str+='<small class="label label-sm label-inverse">Published</small>';
                                    }

                                    str+='<div style="margin-top:10px;">';

                                    if(data[i]['attachment_file']!=null)
                                    {
                                        str+='<i class="fa fa-paperclip"></i>';
                                    }

                                    str+= '<a class="text-info " href="/detailedHomework/'+data[i]['homework_id']+'">View More</a>'+

                                    '</div>'+

                                '</div>'+

                            '</div>';

                        str+='<div class="tmln-div" id="tmln_id_'+i+'" tabindex="0" data-toggle="popover_'+data[i]['homework_id']+'" data-trigger="focus" title="" content="">'+

                                '<h4 style="padding: 16px 0px 0px 0px;text-align: center ">'+data[i]['subject_name']+'</h4>'+

                             '</div>'+

                        '</li>';

                        $("#tmlin").append(str);

                        popoverHandler(data[i]['homework_id']);

                        $('div#loadmoreajaxloader').hide();

                    }

                }else{
                    console.log('end');
                    loaded=true;
                    $('div#loadmoreajaxloader').html('<center>No more notices to show.</center>');
                }

            }
        });

    }

    /*
     +   * Function Name: popoverHandler
     +   * Param: id
     +   * Return: its initialize the popover.
     +   * Desc: runtime initialize popover.
     +   * Developed By: Suraj Bande
     +   * Date: 3/2/2016
     +   */

    function popoverHandler(id) {

        var route1='/batch-class-div-homework/'+id;

        var divisions="";

        $.get(route1,function(res){

            var batch=res[0]['batch_name'];

            var classes=res[0]['class_name'];

            for ( var i=0; i<res.length; i++)
            {

                divisions+= res[i]['division_name']+" ";

            }

            $('[data-toggle="popover_'+id+'"]').popover(
                {
                    title:batch,
                    content:classes+" ("+ divisions +")"
                }
            );

        });

    }

</script>

<!-- start: MAIN JAVASCRIPTS -->

@stop