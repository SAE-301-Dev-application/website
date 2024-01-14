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
    beginningDate,
    endingDate;

let festivalData,
    grijData,
    spectaclesData,
    scenesData;

let scenesColors = [
  '#90EE90', '#ADD8E6', '#FFB6C1', '#c233ff', '#ff4747', '#ffa042', '#ffff30',
  '#a80070', '#0097a8', '#00a85d', '#00a800', '#a8a800', '#a87000', '#a80000',
  '#a8005d', '#a800a8', '#5d00a8', '#0000a8', '#005da8', '#00a8a8',
];

let organizedSpectacles = [],
    unorganizedSpectacles = [];

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
                    let dataObject = JSON.parse(data);

                    dataObject.duree_min_entre_spectacles = stringTimeToSeconds(dataObject.duree_min_entre_spectacles);

                    resolve(dataObject);
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
    window.location.href = ROUTE_PATH_PREFIX + "informations-festival?id=" + FESTIVAL_ID;
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
 * Format a time string to a number.
 * 
 * @param {string} time 
 * @returns {number}
 */
function stringTimeToSeconds(time) {
    const hours = time.split(':')[0];
    const minutes = time.split(':')[1];

    return parseInt(hours) * 3600 + parseInt(minutes) * 60;
}

/**
 * Generate an array of scenes with associated colors.
 * 
 * @param {Object[]} scenesData Array of scene data.
 * @param {string[]} scenesColors Array of scene colors.
 * @returns {Object[]} Array of scenes with associated colors.
 */
function generateScenesWithColors(scenesData, scenesColors) {
    return scenesData.map((scene, index) => ({
        ...scene,
        color: scenesColors[index % scenesColors.length],
    }));
}

/**
 * Organize spectacles based on festival, GriJ, spectacles, and scenes data.
 * 
 * @param {Object} grijData - GriJ data.
 * @param {Object[]} spectaclesData - Array of spectacle data.
 * @param {Object[]} scenesData - Array of scene data with colors.
 * @returns {Object[]} - Array of organized spectacles.
 */
async function organizeSpectacles(grijData, spectaclesData, scenesData) {
    let organizedSpectacles = [];
    let unorganizedSpectacles = [];

    let currentDay = beginningDate;

    let lastEndTime = null,
        spectacleEndDate = currentDay;

    function canFitInScene(spectacle, scene) {
        return spectacle.taille_scene_sp <= scene.size;
    }

    function getNextAvailableTime() {
        if (!lastEndTime) {
            // If it's the first spectacle, use the Grij beginning date
            return beginningDate;
        }

        let durationBetweenSpectacles = grijData.duree_min_entre_spectacles,
            startSpectaclesHour = grijData.heure_debut_spectacles,
            endSpectaclesHour = grijData.heure_fin_spectacles;
        
        // Calculate the next available time based on the last spectacle's end time
        let nextAvailableTime = new Date(lastEndTime.getTime() + durationBetweenSpectacles * 1000);

        // Verify if the next available time is after the end of the day
        const grijEndTime = new Date(`${currentDay.toISOString().split('T')[0]}T${endSpectaclesHour}`);
    
        if (nextAvailableTime > grijEndTime) {
            // Set the next available time to the beginning of the next day
            currentDay = new Date(currentDay.getTime() + 24 * 60 * 60 * 1000);
            nextAvailableTime = new Date(`${currentDay.toISOString().split('T')[0]}T${startSpectaclesHour}`);
        }
    
        return nextAvailableTime;
    }

    // Sort scenes by size, so we can assign spectacles to appropriate-sized scenes first
    scenesData.sort((a, b) => a.size - b.size);

    // Iterate over each spectacle and try to organize it
    for (const spectacle of spectaclesData) {
        let isSpectacleOrganized = false;

        // Get the next available time based on GriJ constraints
        let nextAvailableTime = getNextAvailableTime();

        // Iterate over scenes to find an appropriate one for the spectacle
        for (let i = 0; i < scenesData.length && !isSpectacleOrganized; i++) {
            const scene = scenesData[i];

            // Check if the scene can accommodate the spectacle
            if (canFitInScene(spectacle, scene)) {
                // Check if the spectacle can fit within the festival duration
                spectacleEndDate = new Date(nextAvailableTime.getTime() + spectacle.duree_sp * 60000);

                if (spectacleEndDate <= endingDate) {
                    // Organize the spectacle in the scene at the calculated time
                    organizedSpectacles.push({
                        title: spectacle.titre_sp + " - " + scene.name,
                        start: nextAvailableTime,
                        end: spectacleEndDate,
                        overlap: 'none',
                        backgroundColor: scene.color,
                    });

                    isSpectacleOrganized = true;

                    // Update the lastEndTime for the next spectacle
                    lastEndTime = spectacleEndDate;

                    break;
                }
            }
        }

        // If the spectacle couldn't be organized, add it to a list of unorganized spectacles
        if (!isSpectacleOrganized) {
            // Handle unorganized spectacles as needed
            console.log(`Spectacle "${spectacle.titre_sp}" couldn't be organized.`);
            unorganizedSpectacles.push(spectacle);
        } else {
            lastEndTime = spectacleEndDate;
        }
    }

    return {
        organizedSpectacles: organizedSpectacles,
        unorganizedSpectacles: unorganizedSpectacles
    };
}


/**
 * Create the calendar.
 * 
 * @param {Date} beginningDate
 * @param {Date} endingDate
 */
const createCalendar = async (beginningDate, endingDate, organizedSpectacles) => {
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

        scrollTime: formatTime(beginningDate),
        initialDate: beginningDate,

        editable: false,
        eventDurationEditable: false,

        events: organizedSpectacles,

        eventTextColor: 'black',
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

    if (!festivalData || !grijData || !spectaclesData || !scenesData) {
        return redirectToFestivals();
    }

    beginningDate = new Date(festivalData.date_debut_fe
                             + "T"
                             + grijData.heure_debut_spectacles);

    endingDate = new Date(festivalData.date_fin_fe
                       + "T"
                       + grijData.heure_fin_spectacles);

    let { organizedSpectacles, unorganizedSpectacles } = await organizeSpectacles(
        grijData,
        spectaclesData,
        generateScenesWithColors(scenesData, scenesColors));

    console.log(organizedSpectacles, unorganizedSpectacles);

    await createCalendar(beginningDate, endingDate, organizedSpectacles);
    
    calendar.render();

    $('.fc-event-content, .fc-event-time, .fc-event-title').css('font-size', '16px');

    // Display a message with unorganized spectacles after a little delay
    setTimeout(() => {
      if (unorganizedSpectacles.length > 0) {
          $('#unorganized_spectacles').addClass('spacing').removeClass('hidden-list');
          $('#spectacles_list').html(unorganizedSpectacles.map(spectacle => `<li>${spectacle.titre_sp}</li>`).join(''));
      }
    }, 100);
});