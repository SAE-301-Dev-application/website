const ROUTE_PATH_PREFIX = $('meta[name="route_path_prefix"]').attr('content');

const TEXT_FESTIVAL_DATA_RECEIVED   = "Données festival reçues :\n",
      TEXT_GRIJ_DATA_RECEIVED       = "Données GriJ reçues :\n",
      TEXT_SPECTACLES_DATA_RECEIVED = "Données spectacles reçues :\n",
      TEXT_SCENES_DATA_RECEIVED     = "Données scènes reçues :\n";

const ERROR_GET_DATA = "Erreur lors de la récupération des données",
      ERROR_GET_DATA_FESTIVAL = ERROR_GET_DATA + " du festival",
      ERROR_GET_DATA_GRIJ = ERROR_GET_DATA + " de la GriJ",
      ERROR_GET_DATA_SPECTACLES = ERROR_GET_DATA + " des spectacles",
      ERROR_GET_DATA_SCENES = ERROR_GET_DATA + " des scènes";

const URL_PARAMS = new URLSearchParams(document.location.search);

const FESTIVAL_ID = Number(URL_PARAMS.get('id')) ?? null;

const CALENDAR_DIV = $('.calendar-container > #calendar')[0];

let calendar,
    festivalData,
    grijData,
    spectaclesData,
    scenesData;

/**
 * Recover the festival data from the database with an AJAX request.
 */
async function getFestival() {
    return new Promise((resolve, reject) => {
        $.get(ROUTE_PATH_PREFIX + "generate-planification/get-festival", {id: FESTIVAL_ID})
            .done(data => {
                console.log(TEXT_FESTIVAL_DATA_RECEIVED + data);

                if (data.startsWith("error")) {
                    console.log(ERROR_GET_DATA_FESTIVAL + " :\n" + data);
                    resolve(null);
                } else {
                    resolve(JSON.parse(data));
                }
            })
            .fail(() => {
                console.log(ERROR_GET_DATA_FESTIVAL);
                resolve(null);
            });
    });
};

/**
 * Recover the GriJ data from the database with an AJAX request.
 */
async function getGrij() {
    return new Promise((resolve, reject) => {
        $.get(ROUTE_PATH_PREFIX + "generate-planification/get-grij", {id: FESTIVAL_ID})
            .done(data => {
                console.log(TEXT_GRIJ_DATA_RECEIVED + data);

                if (data.startsWith("error")) {
                    console.log(ERROR_GET_DATA_GRIJ + " :\n" + data);
                    resolve(null);
                } else {
                    resolve(JSON.parse(data));
                }
            })
            .fail(() => {
                console.log(ERROR_GET_DATA_GRIJ);
                resolve(null);
            });
    });
};

/**
 * Recover the spectacles data from the database with an AJAX request.
 */
async function getSpectacles() {
    return new Promise((resolve, reject) => {
        $.get(ROUTE_PATH_PREFIX + "generate-planification/get-spectacles", {id: FESTIVAL_ID})
            .done(data => {
                console.log(TEXT_SPECTACLES_DATA_RECEIVED + data);

                if (data.startsWith("error")) {
                    console.log(ERROR_GET_DATA_SPECTACLES + " :\n" + data);
                    resolve(null);
                } else {
                    resolve(JSON.parse(data));
                }
            })
            .fail(() => {
                console.log(ERROR_GET_DATA_SPECTACLES);
                resolve(null);
            });
    });
};

/**
 * Recover the scenes data from the database with an AJAX request.
 */
async function getScenes() {
    return new Promise((resolve, reject) => {
        $.get(ROUTE_PATH_PREFIX + "generate-planification/get-scenes", {id: FESTIVAL_ID})
            .done(data => {
                console.log(TEXT_SCENES_DATA_RECEIVED + data);

                if (data.startsWith("error")) {
                    console.log(ERROR_GET_DATA_SCENES + " :\n" + data);
                    resolve(null);
                } else {
                    resolve(JSON.parse(data));
                }
            })
            .fail(() => {
                console.log(ERROR_GET_DATA_SCENES);
                resolve(null);
            });
    });
};

/**
 * Redirect to the festivals page.
 */
const redirectToFestivals = () => {
    window.location.href = ROUTE_PATH_PREFIX + "festivals";
};

/**
 * Calculate the number of days between two dates.
 * 
 * @param {Date} firstDate
 * @param {Date} secondDate
 * @returns {number}
 */
function daysBetween(firstDate, secondDate) {
    const ONE_DAY_MS = 1000 * 60 * 60 * 24;

    const firstDateMs = firstDate.getTime();
    const secondDateMs = secondDate.getTime();

    const differenceMs = secondDateMs - firstDateMs;
    return Math.round(differenceMs / ONE_DAY_MS);
}

/**
 * Format a date time to a string.
 * 
 * @param {Date} date
 * @returns {string}
 */
function formatTime(date) {
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');

    return `${hours}:${minutes}`;
}

/**
 * Create the calendar.
 * 
 * @param {Date} beginningDate 
 * @param {Date} endingDate 
 */
const createCalendar = async (beginningDate, endingDate) => {
    calendar = new FullCalendar.Calendar(CALENDAR_DIV, {
        initialView: 'festivalView',

        views: {
            festivalView: {
                type: 'timeGrid',
                duration: {
                    days: daysBetween(beginningDate, endingDate)
                }
            }
        },

        validRange: {
            start: formatTime(beginningDate),
            end: formatTime(endingDate)
        },

        slotMinTime: formatTime(beginningDate),
        slotMaxTime: formatTime(endingDate),

        contentHeight: 700,
        locale: 'fr',

        headerToolbar: {
            left: '',
            center: 'title',
            right: ''
        },

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

        scrollTime: formatTime(beginningDate), // STUB mettre l'heure du premier spectacle
        initialDate: beginningDate,

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
    if (!ROUTE_PATH_PREFIX || !FESTIVAL_ID || isNaN(FESTIVAL_ID))
        return redirectToFestivals();

    console.log("Festival ID : " + FESTIVAL_ID);

    festivalData = await getFestival();
    grijData = await getGrij();
    spectaclesData = await getSpectacles();
    scenesData = await getScenes();

    if (!festivalData || !grijData || !spectaclesData || !scenesData)
        return redirectToFestivals();

    let beginningDate = new Date(festivalData.date_debut_fe
                                 + "T"
                                 + grijData.heure_debut_spectacles);

    let endDate = new Date(festivalData.date_fin_fe
                           + "T"
                           + grijData.heure_fin_spectacles);

    await createCalendar(beginningDate, endDate);
    
    calendar.render();
});