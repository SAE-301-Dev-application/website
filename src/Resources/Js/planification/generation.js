const CALENDAR_DIV = document.getElementById('calendar');

let calendar = new FullCalendar.Calendar(CALENDAR_DIV, {
    initialView: 'festivalView',

    views: {
        festivalView: {
            type: 'timeGrid',
            duration: { days: 7 }
        }
    },

    validRange: {
        start: new Date("2024-01-15T10:00:00"),
        end: new Date("2024-01-21T23:00:00")
    },

    contentHeight: 700,
    locale: 'fr',

    headerToolbar: {
        left: '',
        center: 'title',
        right: ''
    },

    slotMinTime: '09:00',
    slotMaxTime: '23:00',

    titleFormat: {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    },

    dayHeaderFormat: {
        weekday: 'long',
        day: 'numeric',
        month: 'numeric'
    },

    allDaySlot: false,
    slotDuration: '01:00',
    snapDuration: '00:15',

    slotLabelFormat: {
        hour: 'numeric',
        minute: '2-digit',
        omitZeroMinute: false
    },

    scrollTime: '09:00',
    initialDate: new Date("2024-01-15"),

    editable: false,
    eventDurationEditable: false,

    events: [
        {
            title: "Spectacle 1",
            start: new Date("2024-01-15T09:00:00"),
            end: new Date("2024-01-15T10:00:00"),
            overlap: 'none',
            backgroundColor: '#ff0000'
        },
        {
            title: "Spectacle 2",
            start: new Date("2024-01-15T10:00:00"),
            end: new Date("2024-01-15T11:00:00"),
            overlap: 'none',
            backgroundColor: '#ff7f00'
        }
    ]
});

calendar.render();