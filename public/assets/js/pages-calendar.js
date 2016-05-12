var Calendar = function() {"use strict";
	var dateToShow, calendar, demoCalendar, eventClass, eventCategory, subViewElement, subViewContent, $eventDetail;

	var defaultRange = new Object;
	defaultRange.start = moment();
	defaultRange.end = moment().add(1, 'days');
	//Calendar

	var setFullCalendarEvents = function() {

        $('#loadmoreajaxloader').show();

        demoCalendar="";

        var currentDate=new Date();

        dateToShow = currentDate;

        var val=$('#event-select-dropdown').val();

        var route="/get-events/"+val;

        $.ajax({
            url:route,
            async:false,
            success:function(res){

            for(var i=0; i<res.length; i++)
            {

                var startDate=new moment(res[i]['start']);

                var  endDate=new moment(res[i]['end']).add(1,'days').format('YYYY-MM-DD HH:mm:ss');

                res[i]['start']=startDate._i;
                res[i]['end']=endDate;

                if(res[i]['status']==0)
                {
                    res[i]['className']='event-to-do';
                }else if(res[i]['status']==1){
                    res[i]['className']='event-off-site-work';
                }else{
                    res[i]['className']='event-job';
                }

                res[i]['allDay']=true;

            }

                demoCalendar=res;

            }
        }).done(function(){

             runFullCalendar();

        });

	};
	//function to initiate Full Calendar
	var runFullCalendar = function() {

		$(".add-event").off().on("click", function() {

            $('#loadmoreajaxloader').show();

            $.ajax({
                url:"/save-event-check-acl",
                type:'GET',
                success:function(res){
                    if(res==0){
                        var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                            '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                            '<span area-hidden="true">&times;</span>'+
                            '</button>'+
                            '<p>Currently you do not have permission to access this functionality. Please contact administrator to grant you access !</p>'+
                            '</div>';

                        $('#message-error-div').html(str);

                        $('#loadmoreajaxloader').hide();

                    }else{
                        eventInputDateHandler();
                        $("#hiddenEventId").val("create");
                        $(".form-full-event #event-id").val("");
                        $('.events-modal').modal();
                        $('#showEvent').hide();
                        $('#editEvent').show();
                        $('.save-event').show();
                        $('.edit-event').hide();
                        $('.save-edit-event').hide();
                        $('#delBtn').hide();
                        $('#publishBtn').show();
                        $('#error-div').html('');
                        $('.editImageDiv').hide();

                        $('#loadmoreajaxloader').hide();
                    }
                }
            });

		});

		$('.events-modal').on('hide.bs.modal', function(event) {
            eventInputDateHandler();
            $("#hiddenEventId").val("create");
			$(".form-full-event #event-id").val("");
			$(".form-full-event #event-name").val("");
            $(".form-full-event #event-description").val("");
			$(".form-full-event #start-date-time").val("").data("DateTimePicker").destroy();
			$(".form-full-event #end-date-time").val("").data("DateTimePicker").destroy();
			$(".event-categories[value='job']").prop('checked', true);
            $('.editImageDiv').hide();
            $(".form-full-event #img-file").attr('disabled',false);
		});

		$('#event-categories div.event-category').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title

			};
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true, // will cause the event to go back to its
				revertDuration: 50 //  original position after the drag
			});
		});
		/* initialize the calendar
		 -----------------------------------------------------------------*/
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var form = '';

        $('#full-calendar').fullCalendar({

			buttonIcons: {
				prev: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right'
			},
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: demoCalendar,
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			droppable: false, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) {// this function is called when something is dropped

				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');

				var $category = $(this).attr('data-class');

				// we need to copy it, so that multiple events don't have a reference to the same object

				var newEvent = new Object;
				newEvent.title = originalEventObject.title;
				newEvent.start = new Date(date);
				newEvent.end = moment(new Date(date)).add(1, 'hours');
				newEvent.allDay = true;
                //newEvent.content=$description;
				newEvent.category = $category;
				newEvent.className = 'event-' + $category;

				$('#full-calendar').fullCalendar('renderEvent', newEvent, true);
				// is the "remove after drop" checkbox checked?
				if($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}

			},

			selectable: true,
            intervalDuration:64,
			selectHelper: true,
			select: function(start, end, allDay) {

                $('#loadmoreajaxloader').show();
                var check = moment(start).format('YYYY-MM-DD hh:mm:ss');
                var check1=new moment(check)._d;
                var today = new Date();

                if(check1.getTime() < today.getTime())
                {

                    if(check1.getDate() == today.getDate() && check1.getMonth()==today.getMonth() && check1.getYear()==today.getYear())
                    {
                        $.ajax({
                            url:"/save-event-check-acl",
                            type:'GET',
                            success:function(res){

                                if(res==0){
                                    var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                                        '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                                        '<span area-hidden="true">&times;</span>'+
                                        '</button>'+
                                        '<p>Currently you do not have permission to access this functionality. Please contact administrator to grant you access !</p>'+
                                        '</div>';

                                    $('#message-error-div').html(str);

                                    $('#loadmoreajaxloader').hide();

                                }else{
                                    eventInputDateHandler();
                                    $("#hiddenEventId").val("create");
                                    $(".form-full-event #event-id").val("");
                                    $(".form-full-event #event-name").val("");
                                    $(".form-full-event #event-description").val("");
                                    $(".form-full-event #start-date-time").data("DateTimePicker").date(moment(start));
                                    $(".form-full-event #end-date-time").data("DateTimePicker").date(moment(start).add(1, 'hours'));
                                    $(".event-categories[value='job']").prop('checked', true);
                                    $('#showEvent').hide();
                                    $('#editEvent').show();
                                    $('#delBtn').hide();
                                    $('.save-event').show();
                                    $('.edit-event').hide();
                                    $('#error-div').html('');
                                    $('.events-modal').modal();
                                    $('#publishBtn').show();
                                    $('.save-edit-event').hide();
                                    $('.editImageDiv').hide();

                                    $('#loadmoreajaxloader').hide();
                                }

                            }
                        });
                    }else{

                        eventInputDateHandler();
                        $("#hiddenEventId").val("create");
                        $(".form-full-event #event-id").val("");
                        $(".form-full-event #event-name").val("");
                        $(".form-full-event #event-description").val("");
                        $(".form-full-event #start-date-time").data("DateTimePicker").destroy();
                        $(".form-full-event #end-date-time").data("DateTimePicker").destroy();
                        alert('You cant create event for previous date.');
                        $('#publishBtn').show();
                        $('.editImageDiv').hide();

                        $('#loadmoreajaxloader').hide();
                    }

                } else {
                    $.ajax({
                        url:"/save-event-check-acl",
                        type:'GET',
                        success:function(res){

                            if(res==0){
                                var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                                    '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                                    '<span area-hidden="true">&times;</span>'+
                                    '</button>'+
                                    '<p>Currently you do not have permission to access this functionality. Please contact administrator to grant you access !</p>'+
                                    '</div>';

                                $('#message-error-div').html(str);

                                $('#loadmoreajaxloader').hide();

                            }else{
                                eventInputDateHandler();
                                $("#hiddenEventId").val("create");
                                $(".form-full-event #event-id").val("");
                                $(".form-full-event #event-name").val("");
                                $(".form-full-event #event-description").val("");
                                $(".form-full-event #start-date-time").data("DateTimePicker").date(moment(start));
                                $(".form-full-event #end-date-time").data("DateTimePicker").date(moment(start).add(1, 'hours'));
                                $(".event-categories[value='job']").prop('checked', true);
                                $('#showEvent').hide();
                                $('#editEvent').show();
                                $('#delBtn').hide();
                                $('.save-event').show();
                                $('.edit-event').hide();
                                $('#publishBtn').show();
                                $('#error-div').html('');
                                $('.events-modal').modal();
                                $('.save-edit-event').hide();
                                $('.editImageDiv').hide();

                                $('#loadmoreajaxloader').hide();
                            }

                        }
                    });
                }


			},

			eventClick: function(calEvent, jsEvent, view) {

                eventInputDateHandler();

				var eventId = calEvent._id;

                $('#loadmoreajaxloader').show();

                for(var i = 0; i < demoCalendar.length; i++) {

					if(demoCalendar[i]._id == eventId) {

                        $("#hiddenEventId").val(demoCalendar[i].id);
						$(".form-full-event #event-id").val(eventId);
						$(".form-full-event #event-name").val(demoCalendar[i].title);
						$(".form-full-event #event-description").val(demoCalendar[i].content);

                        if(demoCalendar[i].image != null)
                        {
                            $(".form-full-event #img-title").html(demoCalendar[i].image);
                            $('.editImageDiv').show();
                            $(".form-full-event #img-file").attr('disabled',true);
                            $(".form-full-event #field-name-image").html('<img class="image-align-event" src="/uploads/events/'+ demoCalendar[i].image +'">');
                            $('#isNewImage').val(0);
                        }else{
                            $('.editImageDiv').hide();
                            $('#img-file').attr('disabled',false);
                            $('#isNewImage').val(0);
                        }

						$(".form-full-event #start-date-time").data("DateTimePicker").date(moment(moment(moment(demoCalendar[i].start)._i).format('MM/DD/YYYY hh:mm A')));
                        $(".form-full-event #end-date-time").data("DateTimePicker").date(moment(moment(moment(demoCalendar[i].end)._i).subtract(1,'days').format('MM/DD/YYYY hh:mm A')));

						if(demoCalendar[i].category == "" || typeof demoCalendar[i].category == "undefined") {
							eventCategory = "Generic";
						} else {
							eventCategory = demoCalendar[i].category;
						}

                        var date = new moment(demoCalendar[i].start);
                        var date1 = new moment(demoCalendar[i].end).subtract(1,'days');

                        var hoursStart = (date._i.split(' '))[1].split(':')[0];

                        var suffixStart = (hoursStart >= 12)? 'pm' : 'am';
                        hoursStart = (hoursStart > 12)? hoursStart -12 : hoursStart;
                        hoursStart = (hoursStart == '00')? 12 : hoursStart;

                        var minutesStart = (date._i.split(' '))[1].split(':')[1];

                        var hoursEnd = (date1._i.split(' '))[1].split(':')[0];

                        var suffixEnd = (hoursEnd >= 12)? 'pm' : 'am';
                        hoursEnd = (hoursEnd > 12)? hoursEnd -12 : hoursEnd;
                        hoursEnd = (hoursEnd == '00')? 12 : hoursEnd;

                        var minutesEnd = (date1._i.split(' '))[1].split(':')[1];

                        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                        var start_date=days[date.day()]+' '+date.date()+'/'+(date.month()+1)+'/'+date.year()+' '+hoursStart+':'+minutesStart+' '+suffixStart;
                        var end_date=days[date1.day()]+' '+date1.date()+'/'+(date1.month()+1)+'/'+date1.year()+' '+hoursEnd+':'+minutesEnd+' '+suffixEnd;

                        $("#event-title").html(demoCalendar[i].title);

                        $("#event-detail").html(demoCalendar[i].content);

                        if(demoCalendar[i].status == 0) {
                            $("#status-show").html('<span class="label label-danger">Draft</span>');
                        } else if(demoCalendar[i].status == 1) {
                            $("#status-show").html('<span class="label label-info">Pending</span>');
                        } else {
                            $("#status-show").html('<span class="label label-default">Published</span>');
                        }

                        if(demoCalendar[i].image == null) {
                            $("#event-image").prop('src','/uploads/events/picture.svg');
                        } else {
                            $("#event-image").prop('src','/uploads/events/'+demoCalendar[i].image);
                        }

                        var date2 = new moment(demoCalendar[i].created_at)._d;

                        var hoursCreatedAt = date2.getHours();

                        var suffixCreatedAt = (hoursCreatedAt >= 12)? 'pm' : 'am';
                        hoursCreatedAt = (hoursCreatedAt > 12)? hoursCreatedAt -12 : hoursCreatedAt;
                        hoursCreatedAt = (hoursCreatedAt == '00')? 12 : hoursCreatedAt;

                        var minutesCreatedAt = date2.getMinutes();

                        var created_at = days[date2.getDay()]+' '+date2.getDate()+'/'+(date2.getMonth()+1)+'/'+date2.getFullYear()+' '+hoursCreatedAt+':'+minutesCreatedAt+' '+suffixCreatedAt;

                        $("#created_time").html(created_at);
                        $("#event-start-time").html(start_date);
                        $("#event-end-time").html(end_date);

                        var route = "/get-user-event/"+demoCalendar[i].created_by;

                        $.get(route,function(res){
                            if(res.length != 0) {
                                $("#event-created-by").html(res[0]['first_name']+" "+res[0]['last_name']  );
                            } else {
                                $("#event-created-by").html(' --')
                            }
                        });

                        var route1 = "/get-user-event/"+demoCalendar[i].published_by;

                        var pubDate = new moment(demoCalendar[i].published_at)._d;

                        var hours = pubDate.getHours();

                        var suffix = (hours >= 12)? 'pm' : 'am';
                        hours = (hours > 12)? hours -12 : hours;
                        hours = (hours == '00')? 12 : hours;

                        var minutes = pubDate.getMinutes();

                        var published_at = days[pubDate.getDay()]+' '+pubDate.getDate()+'/'+(pubDate.getMonth()+1)+'/'+pubDate.getFullYear() +' '+hours+':'+minutes+' '+suffix;

                        $.get(route1,function(res){
                            if(res.length != 0) {
                                $("#published-by-div").show();
                                $("#event-published-by").html(res[0]['first_name']+" "+res[0]['last_name']+" on "+published_at);
                            } else {
                                $("#published-by-div").hide();
                            }

                        });

                        $('#showEvent').show();
                        $('#editEvent').hide();
                        $('.save-event').hide();

                        $('#error-div').html('');
                        if(demoCalendar[i].status == 2)
                        {
                            $('.edit-event').hide();
                            $('#publishBtn').hide();
                            $('#delBtn').hide();
                        }else{
                            $('.edit-event').show();
                            var val = $('#hiddenUserRole').val();
                            if(val == 2 && demoCalendar[i].status == 1) {
                                $('#publishBtn').hide();
                                $('.edit-event').hide();
                                $('#delBtn').hide();
                            }else{
                                $('#publishBtn').show();
                                $('.edit-event').show();
                                $('#delBtn').show();
                            }

                        }

                        if(val == 1 && demoCalendar[i].status == 1) {
                            $('#delBtn').show();
                        }

                        if(demoCalendar[i].status == 0){
                            $('#publishBtn').show();
                        }

                        $('.save-edit-event').hide();

						$(".event-categories[value='" + eventCategory + "']").prop('checked', true);

                        $('#error-div-edit').html("");

                        $('#error-div-edit').hide();

                        break;

					}

				}

				$('.events-modal').modal();

                $('#loadmoreajaxloader').hide();

			}

		});

        demoCalendar = $("#full-calendar").fullCalendar( 'clientEvents');

        $('#loadmoreajaxloader').hide();

        $('.fc-toolbar .fc-right').hide();
	};

	var runFullCalendarValidation = function(el) {

		var formEvent = $('#create_event_form');

        $.validator.addMethod("greaterThan",
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new moment(value)._i)) {
                    return new moment(value).unix() > new moment($(params).val()).unix();
                }

                return isNaN(value) && isNaN($(params).val())
                    || (Number(value) > Number($(params).val()));

            },'Must be greater than {0}.');

		formEvent.validate({
			errorElement: "span", // contain the error msg in a span tag
			errorClass: 'help-block',

			ignore: "",
			rules: {
				eventName: {
					minlength: 2,
					required: true
				},
                eventDescription: {
                    minlength:15,
                    required: true
                },
				eventStartDate: {
					required: true,
					date: true
				},
				eventEndDate: {
					required: true,
					date: true,
                    greaterThan:'#start-date-time'
				}

			},
			messages: {
				eventName: "* Please specify the event title",

                eventDescription: {
                    required:"* Please specify the event description.",
                    minlength:"* Please select at least 15 characters."
                },
                eventEndDate:{greaterThan:"Please select end date time must be greater than start time."}
			},
			highlight: function(element) {
				$(element).closest('.help-block').removeClass('valid');
				// display OK icon
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
				// add the Bootstrap error class to the control group
			},
			unhighlight: function(element) {// revert the change done by hightlight
				$(element).closest('.form-group').removeClass('has-error');
				// set error class to the control group
			},
			success: function(label, element) {
				label.addClass('help-block valid');
				// mark the current input as valid and display OK icon
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
			},
			submitHandler: function(form) {

                var file=$(form);
                var isEdit=$('#hiddenEventId').val();
                if(isEdit=="create")
                {
                    var obj = $("input[type=hidden]");

                    obj[3].name='hiddenField';

                    uploadImage(file);

                }else{

                    var obj = $("input[type=hidden]");

                    obj[3].name='hiddenField';

                    if(obj[3].value == "Update")
                    {

                        var img = $('#img-file').val();

                        if(img != "")
                        {
                            $('#isNewImage').val(1);
                        }

                        updateEvent(file);

                    }else{
                        saveEditPublish(file);
                    }

                }

			}
		});
	};

    /*
     +   * Function Name: uploadImage
     +   * Param: file
     +   * Return: 1 or error.
     +   * Desc: it will call ajax to save event.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */

    function uploadImage(file)
    {
        $('#upload').prop('disabled',true);
        $('#loadmoreajaxloader').show();

        var formData=new FormData(file[0]);

        $.ajax({
            url:'/save-event',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){

                window.location.href="/event/1";

                $('.events-modal').modal('hide');
            },
            error: function(data){
                // Error...

                var errors = $.parseJSON(data.responseText);

                var errorsHtml = '<div class="alert alert-danger"><ul>';

                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></di>';

                $('#error-div').html(errorsHtml);

                $('#upload').prop('disabled',false);

                $('#loadmoreajaxloader').hide();

            }

        });

    }

    /*
     +   * Function Name: saveEditPublish
     +   * Param: file
     +   * Return: 1 or error.
     +   * Desc: it will publish status published from edit form.
     +   * Developed By: Suraj Bande
     +   * Date: 15/3/2016
     +   */

    function saveEditPublish(file)
    {

        $('#publishBtn').prop('disabled',true);
        $('#loadmoreajaxloader').show();

        var id = $('#hiddenEventId').val();
        $.ajax({
            url:'/publish-edit-event/'+id,
            processData: false,
            contentType: false,
            type: 'get',
            success: function(data){
                if(data==1){
                    window.location.href="/event/1";
                }else{
                    var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                        '<span area-hidden="true">&times;</span>'+
                        '</button>'+
                        "Currently you do not have permission to access this functionality. Please contact administrator to grant you access !"+
                        "</div>";
                    $('#error-div-edit').show();
                    $('#error-div-edit').html(str);

                    $('#publishBtn').prop('disabled',false);
                    $('#loadmoreajaxloader').hide();
                }

            },
            error: function(data){
                // Error...
                var errors = $.parseJSON(data.responseText);

                var errorsHtml = '<div class="alert alert-danger"><ul>';

                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></di>';

                $('#error-edit-div').html(errorsHtml);

                $('#publishBtn').prop('disabled',false);
                $('#loadmoreajaxloader').hide();
            }

        });

    }

    /*
     +   * Function Name: updateEvent
     +   * Param: file
     +   * Return: 1 or error.
     +   * Desc: it will update event.
     +   * Developed By: Suraj Bande
     +   * Date: 15/3/2016
     +   */

    function updateEvent(file)
    {
        $('#saveEdit').prop('disabled',true);
        $('#loadmoreajaxloader').show();

        var formData=new FormData(file[0]);

        $.ajax({
            url:'/save-edit-event',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                if(data==1){
                    window.location.href="/event/1";
                }
            },
            error: function(data){
                // Error...
                var errors = $.parseJSON(data.responseText);

                var errorsHtml = '<div class="alert alert-danger"><ul>';

                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></di>';

                $('#error-edit-div1').html(errorsHtml);

                $('#saveEdit').prop('disabled',false);
                $('#loadmoreajaxloader').hide();
            }
        });
    }

	var eventInputDateHandler = function() {
		var startInput = $('#start-date-time');
		var endInput = $('#end-date-time');
		startInput.datetimepicker();
		endInput.datetimepicker();
        var dateToday=new Date();
		startInput.on("dp.change", function(e) {
            startInput.data("DateTimePicker").minDate(dateToday);
		});
		endInput.on("dp.change", function(e) {
            endInput.data("DateTimePicker").minDate(dateToday);
		});

	};


	return {
		init: function() {

            setFullCalendarEvents();

			runFullCalendarValidation();

		}
	};

}();
