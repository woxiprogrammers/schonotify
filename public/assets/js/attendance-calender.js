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
                right: 'month,agendaWeek,agendaDay'
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

                $(".form-full-event #stud-list").html('<ul class="list-group"><li class="list-group-item">101 Suraj Bande <div class="pull-right leave-applied-tag"></div> <div class="pull-right leave-approved-tag"></div><div class="pull-right absent-tag"></div></li><li class="list-group-item">102 Shantanu Acharya <div class="pull-right absent-tag"></div></li><li class="list-group-item">107 Manoj Jadhav <div class="pull-right absent-tag"></div></li></ul>');

                $(".event-categories[value='job']").prop('checked', true);
                $('#delBtn').hide();
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
