const TEXT_GRIJ_DATA_RECEIVED       = "Données GriJ reçues :\n",
      TEXT_SPECTACLES_DATA_RECEIVED = "Données spectacles reçues :\n",
      TEXT_SCENES_DATA_RECEIVED     = "Données scènes reçues :\n";

const ERROR_GET_DATA = "Erreur lors de la récupération des données ",
      GRIJ_DATA_NAME = "de la GriJ",
      SPECTACLES_DATA_NAME = "des spectacles",
      SCENES_DATA_NAME = "des scènes";

const URL_PARAMS = new URLSearchParams(window.location.search);

const FESTIVAL_ID = URL_PARAMS.get('id')
console.log(FESTIVAL_ID);

const CALENDAR_DIV = document.getElementById('calendar');

let calendar,
    grij,
    spectacles,
    scenes;

/**
 * Recover the GriJ data from the database with an AJAX request.
 */
const getGrij = async () => {
    $.get("/website/generate-planification/get-grij", {id: "1"})
        .done(data => {
            console.log(TEXT_GRIJ_DATA_RECEIVED + data);

            if (data.startsWith("error")) {
                console.log(ERROR_GET_DATA + GRIJ_DATA_NAME + " :\n" + data);
                grij = null;
            } else {
                grij = JSON.parse(data);
            }
        })
        .fail(() => {
            console.log(ERROR_GET_DATA + GRIJ_DATA_NAME);
            grij = null;
        });
};

/**
 * Recover the spectacles data from the database with an AJAX request.
 */
const getSpectacles = async () => {
    $.get("/website/generate-planification/get-spectacles", {id: "1"})
        .done(data => {
            console.log(TEXT_SPECTACLES_DATA_RECEIVED + data);

            if (data.startsWith("error")) {
                console.log(ERROR_GET_DATA + SPECTACLES_DATA_NAME + " :\n" + data);
                spectacles = null;
            } else {
                spectacles = JSON.parse(data);
            }
        })
        .fail(() => {
            console.log(ERROR_GET_DATA + SPECTACLES_DATA_NAME);
            spectacles = null;
        });
};

/**
 * Recover the scenes data from the database with an AJAX request.
 */
const getScenes = async () => {
  $.get("/website/generate-planification/get-scenes", {id: "1"})
      .done(data => {
          console.log(TEXT_SCENES_DATA_RECEIVED + data);

          if (data.startsWith("error")) {
              console.log(ERROR_GET_DATA + SCENES_DATA_NAME + " :\n" + data);
              scenes = null;
          } else {
              scenes = JSON.parse(data);
          }
      })
      .fail(() => {
          console.log(ERROR_GET_DATA + SCENES_DATA_NAME);
          scenes = null;
      });
};

const createCalendar = async () => {
    calendar = new FullCalendar.Calendar(CALENDAR_DIV, {
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
};

document.addEventListener("DOMContentLoaded", async () => {
    await getGrij();
    await getSpectacles();
    await getScenes();

    await createCalendar();
    
    calendar.render();
});