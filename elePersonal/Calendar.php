<?php include 'core/init.php';
//Call general function to protect page access
protect_page();
include 'includes/masterLayout/header.php'; ?>

<div class="wrapper">
    <div class="content-main">
        <?php include 'includes/aside.php'; ?>


        <!-- right side main content -->
        <div id="page-wrapper" class="dashbard-1">
            <div class="content-main">
                <!--banner-->
                <div class="banner">
                    <h1 class="page-header">Calendar
                        <small>Events</small>
                    </h1>
                </div>
                <!--//banner-->

                <!-- Display Calendar  -->
                <div class="col-lg-7" id="renderCalendar"></div>

            </div>
        </div>

    </div>
</div>


<?php include 'includes/masterLayout/footer.php'; ?>

<script>
    $(document).ready(function () {
        var calendar = $('#renderCalendar').fullCalendar({
            editable: true,
            //set buttons
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,listWeek'
            },

            //customise button name
            views: {
                listWeek: {buttonText: 'Agenda'}
            },

            defaultView: 'month',
            navLinks: true, //allow day/week name to navigate view
            eventLimit: true,
            //load data
            events: 'core/functions/calendar_load.php',
            //make cells selectable
            selectable: true,
            selectHelper: true,

            //insert event for selected cell
            select: function (start, end, allDay) {
                var title = prompt("Enter Event Title");
                if (title) {
                    //get current date and time
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    //inset the event
                    $.ajax({
                        url: "core/functions/calendar_insert.php",
                        type: "POST",
                        data: {title: title, start: start, end: end},
                        success: function () {
                            //reload event data
                            calendar.fullCalendar('refetchEvents');
                            alert("Added Successfully");
                        }
                    })
                }
            },


            //Allow updating event data
            editable: true,
            eventResize: function (event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"); //get current data and time
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"); //get current data and time
                var title = event.title; //fetch title
                var id = event.id;
                $.ajax({
                    url: "core/functions/calendar_update.php",
                    type: "POST",
                    data: {title: title, start: start, end: end, id: id},
                    success: function () {
                        calendar.fullCalendar('refetchEvents');
                        alert('Event Update');
                    }
                })
            },

            //Delete events
            eventDrop: function (event) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss"); //get current data and time
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss"); //get current data and time
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "core/functions/calendar_update.php",
                    type: "POST",
                    data: {title: title, start: start, end: end, id: id},
                    success: function () {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated");
                    }
                });
            },

            eventClick: function (event) {
                if (confirm("Are you sure you want to remove it?")) {
                    var id = event.id;
                    $.ajax({
                        url: "core/functions/calendar_delete.php",
                        type: "POST",
                        data: {id: id},
                        success: function () {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Removed");
                        }
                    })
                }
            },


        });
    });
</script>








