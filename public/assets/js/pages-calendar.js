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

                var startDate=new Date(res[i]['start']);
                var  dst = startDate.getDate();
                var  mst = startDate.getMonth();
                var  yst = startDate.getFullYear();
                var  hst = startDate.getHours();
                var  minst = startDate.getMinutes();

                var stDate=new Date(yst, mst, dst,hst,minst);

                var  endDate=new Date(res[i]['end']);
                var  det = endDate.getDate();
                var  met = endDate.getMonth();
                var  yet = endDate.getFullYear();
                var  het = endDate.getHours();
                var  minet = endDate.getMinutes();

                var etDate=new Date(yet, met, det,het,minet);

                res[i]['start']=stDate;
                res[i]['end']=etDate;
                if(res[i]['status']==0)
                {
                    res[i]['className']='event-to-do';
                }else if(res[i]['status']==1){
                    res[i]['className']='event-off-site-work';
                }else{
                    res[i]['className']='event-job';
                }

                res[i]['allDay']='false';

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
                    }else{
                        eventInputDateHandler();

                        $(".form-full-event #event-id").val("");
                        $('.events-modal').modal();
                        $('#showEvent').hide();
                        $('#editEvent').show();
                        $('.save-event').show();
                        $('.edit-event').hide();
                        $('#delBtn').hide();
                        $('#error-div').html('');
                    }
                }
            });

		});

		$('.events-modal').on('hide.bs.modal', function(event) {

			$(".form-full-event #event-id").val("");
			$(".form-full-event #event-name").val("");
            $(".form-full-event #event-description").val("");
			$(".form-full-event #start-date-time").val("").data("DateTimePicker").destroy();
			$(".form-full-event #end-date-time").val("").data("DateTimePicker").destroy();
			$(".event-categories[value='job']").prop('checked', true);
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
			editable: true,
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
			selectHelper: true,
			select: function(start, end, allDay) {

                var check = moment(start).format('YYYY-MM-DD hh:mm:ss');
                var check1=new Date(check);
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

                                }else{
                                    eventInputDateHandler();
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
                                }

                            }
                        });
                    }else{

                        eventInputDateHandler();
                        $(".form-full-event #event-id").val("");
                        $(".form-full-event #event-name").val("");
                        $(".form-full-event #event-description").val("");
                        $(".form-full-event #start-date-time").data("DateTimePicker").date(moment(start));
                        $(".form-full-event #end-date-time").data("DateTimePicker").date(moment(start).add(1, 'hours'));
                        alert('You cant create event for previous date.');
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

                            }else{
                                eventInputDateHandler();
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
                            }

                        }
                    });
                }



			},
			eventClick: function(calEvent, jsEvent, view) {

                eventInputDateHandler();

				var eventId = calEvent._id;

				for(var i = 0; i < demoCalendar.length; i++) {

					if(demoCalendar[i]._id == eventId) {
						$(".form-full-event #event-id").val(eventId);
						$(".form-full-event #event-name").val(demoCalendar[i].title);
						$(".form-full-event #event-description").val(demoCalendar[i].content);
						$(".form-full-event #start-date-time").data("DateTimePicker").date(moment(demoCalendar[i].start));
						$(".form-full-event #end-date-time").data("DateTimePicker").date(moment(demoCalendar[i].end));
						if(demoCalendar[i].category == "" || typeof demoCalendar[i].category == "undefined") {
							eventCategory = "Generic";
						} else {
							eventCategory = demoCalendar[i].category;
						}


                        var date=new Date(demoCalendar[i].start._d);
                        var date1=new Date(demoCalendar[i].end._d);
                        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                        var start_date=days[date.getDay()]+' '+date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear();
                        var end_date=days[date1.getDay()]+' '+date1.getDate()+'/'+(date1.getMonth()+1)+'/'+date1.getFullYear();

                        $("#event-title").html(demoCalendar[i].title);

                        $("#event-detail").html(demoCalendar[i].content);

                        if(demoCalendar[i].status == 0) {
                            $("#status-show").html('<span class="label label-danger">Draft</span>');
                        } else if(demoCalendar[i].status == 1) {
                            $("#status-show").html('<span class="label label-info">Pending</span>');
                        } else {
                            $("#status-show").html('<span class="label label-default">Published</span>');
                        }

                        if(demoCalendar[i].image == null || demoCalendar[i].image == "") {
                            $("#event-image").prop('src','/uploads/events/picture.svg');
                        } else {
                            $("#event-image").prop('src','/uploads/events/'+demoCalendar[i].image);
                        }

                        var date2 = new Date(demoCalendar[i].created_at);

                        var created_at = days[date2.getDay()]+' '+date2.getDate()+'/'+(date2.getMonth()+1)+'/'+date2.getFullYear();

                        $("#created_time").html(created_at);
                        $("#event-start-time").html(start_date);
                        $("#event-end-time").html(end_date);

                        var route = "/get-user-event/"+demoCalendar[i].created_by;

                        $.get(route,function(res){
                            if(res.length != 0) {
                                $("#event-created-by").html(res[0]['first_name']+" "+res[0]['last_name']);
                            } else {
                                $("#event-created-by").html(' --')
                            }
                        });

                        var route1 = "/get-user-event/"+demoCalendar[i].published_by;

                        $.get(route1,function(res){
                            if(res.length != 0) {
                                $("#event-published-by").html(res[0]['first_name']+" "+res[0]['last_name']);
                            } else {
                                $("#event-published-by").html(' --')
                            }

                        });

                        $('#showEvent').show();
                        $('#editEvent').hide();
                        $('.save-event').hide();
                        $('.edit-event').show();
                        $('#error-div').html('');
                        $('#delBtn').hide();

						$(".event-categories[value='" + eventCategory + "']").prop('checked', true);

					}
				}

				$('.events-modal').modal();

			}

		});

        $('#loadmoreajaxloader').hide();

        demoCalendar = $("#full-calendar").fullCalendar("clientEvents");

        $('.fc-toolbar .fc-right').hide();
	};

	var runFullCalendarValidation = function(el) {

		var formEvent = $('#create_event_form');

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
					date: true
				}


			},
			messages: {
				eventName: "* Please specify the event title",

                eventDescription: {
                    required:"* Please specify the event description.",
                    minlength:"* Please select at least 15 characters."
                }
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

                uploadImage(file);

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
        var formData=new FormData(file[0]);

        $.ajax({
            url:'/save-event',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){

                if(data==1){
                    window.location.href="/event/1";
                }
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
			endInput.data("DateTimePicker").minDate(dateToday);
		});
		endInput.on("dp.change", function(e) {
            startInput.data("DateTimePicker").minDate(dateToday);
		});
	};
	return {
		init: function() {

            setFullCalendarEvents();

			runFullCalendarValidation();

		}
	};

}();
