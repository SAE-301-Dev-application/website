let calendarElement = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarElement, {
    initialView: 'festivalView',

    views: {
        festivalView: {
            type: 'timeGrid',
            duration: { days: 7 }
        }
    },

    //validRange: {
        //start: new Date("2024-01-10T13:00:00"),
        //end: new Date("2024-01-11T11:00:00")
    //},

    contentHeight: 700,
    locale: 'fr',

    headerToolbar: {
        left: '',
        center: 'title',
        right: ''
    },

    slotMinTime: '10:30',
    slotMaxTime: '22:30',

    dayHeaderFormat: {
        weekday: 'long',
        day: 'numeric',
        month: 'numeric'
    },

    allDaySlot: false,
    slotDuration: '01:00:00',
    snapDuration: '00:15:00',

    slotLabelFormat: {
        hour: 'numeric',
        minute: '2-digit',
        omitZeroMinute: false
    },

    scrollTime: '16:00:00',
    initialDate: new Date("2024-01-12"),

    editable: false,
    eventDurationEditable: false,

    events: [{
        title: "test",
        start: new Date("2024-01-12T12:20:30"),
        end: new Date("2024-01-12T18:20:30"),
        overlap: 'none',
        backgroundColor: '#ff0000'
    }, {
      title: "test2",
      start: new Date("2024-01-12T12:30:00"),
      end: new Date("2024-01-12T18:21:00"),
      overlap: 'none',
      backgroundColor: '#ffff00'
  }]
});
calendar.render();