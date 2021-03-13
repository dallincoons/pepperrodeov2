export function createMissingDays(existingDays, startDate, endDate) {
    let startDay = startDate;
    let amountOfDays = endDate.diff(startDay, 'days');
    let startDayFormatted = startDate.format('YYYY-MM-DD');
    let result = {};

    if (!existingDays.hasOwnProperty(startDayFormatted)) {
        result[startDayFormatted] = [];
    } else {
        result[startDayFormatted] = existingDays[startDayFormatted];
    }

    for (let i = 0; i < amountOfDays; i++) {
        let dateToCheck = startDay.add(1, 'd').format('YYYY-MM-DD');
        if (!existingDays.hasOwnProperty(dateToCheck)) {
            result[dateToCheck] = [];
        } else {
            result[dateToCheck] = existingDays[dateToCheck];
        }
    }

    return result;
}
