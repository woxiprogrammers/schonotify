var Calendar = function() {"use strict";
    var dateToShow, calendar, demoCalendar, eventClass, eventCategory, subViewElement, subViewContent, $eventDetail;
    var defaultRange = new Object;

    defaultRange.start = moment();
    defaultRange.end = moment().add(1, 'days');

    //function to initiate Full Calendar
    var runFullCalendar = function() {
        $(".add-event").off().on("click", function() {
            eventInputDateHandler();
            $(".form-full-event #event-id").val("");
            $('.events-modal').modal();
            $('#delBtn').hide();
        });
        $('.events-modal').on('hide.bs.modal', function(event) {
            $(".form-full-event #event-id").val("");

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
                right: 'agendaWeek,agendaDay'
            },
            events: demoCalendar,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            droppable: true, // this allows things to be dropped onto the calendar !!!
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

                $(".form-full-event #event-id").val("");
                $(".form-full-event #event-name").val("");
                var date=new Date(start);
                var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                $(".form-full-event #today").html(days[date.getDay()]+' '+date.getDate()+'/'+date.getMonth()+'/'+date.getFullYear());
                $(".event-categories[value='job']").prop('checked', true);
                $('#delBtn').hide();
                var selectedDate=new Date(start).getTime();
                var currentDate = new Date().getTime();
                var diff = selectedDate - currentDate;
                var div=$('#division-select').val();
                var data = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                var date_dump = year +"-"+month+"-"+data;
                    $.ajax({
                        url: 'view-attendance',
                        type: "get",
                        data: {date:date_dump,division:div},
                        success: function(data){
                           if(data == 0) {
                               if(diff <= 0) {
                               $(".form-full-event #stud-list").html('<h4 class="text-danger"><i class="fa fa-warning"></i> No Data found</h4>');
                                   $('#listTitle').show();
                               } else {
                                   $(".form-full-event #stud-list").html('<h4 class="text-danger"><i class="fa fa-warning"></i> No Attendance found for this date. Please select Current or previous date.</h4>');
                                   $('#listTitle').hide();
                               }
                            }
                           else {
                               var str="";
                                  for(var i=0;i<data.length;i++ ) {
                                       str += '<ul class="list-group">' ;
                                                  if (data[i]['leave_status']  == 1)
                                                  {
                                                      str+='<li class="list-group-item">' + data[i]['roll_number'] +" "+ data[i]['student_name'] +
                                                        '<div class="pull-right absent-tag"></div><div class="pull-right leave-applied-tag"></div></li>';
                                                  }
                                                  else if (data[i]['leave_status'] == 2)
                                                  {
                                                        str+='<li class="list-group-item">' + data[i]['roll_number'] +" "+ data[i]['student_name'] +
                                                            '<div class="pull-right absent-tag"></div><div class="pull-right leave-approved-tag"></div></li>';
                                                  } else {
                                                         str+='<li class="list-group-item">' + data[i]['roll_number'] +" "+ data[i]['student_name'] +
                                                             ' <div class="pull-right absent-tag"></div></li>';
                                                                      }
                                            '</ul>';
                                  }
                                   $(".form-full-event #stud-list").html(str);
                                   $('#listTitle').show();
                           }
                             if(data == 2){
                                $(".form-full-event #stud-list").html('<h4 class="text-danger"><i class="fa fa-warning"></i> NO ABSENT STUDENTS </h4>');
                                $('#listTitle').show();
                            }
                        }
                    });
                $('.events-modal').modal();
            }
        });
        demoCalendar = $("#full-calendar").fullCalendar("clientEvents");
    };
    return {
        init: function() {
            runFullCalendar();
        }
    };
}();
