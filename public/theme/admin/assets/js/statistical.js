function validateDateRange(fromStr, toStr) {
    if (fromStr && toStr) {
        const from = convertDate(fromStr);
        const to = convertDate(toStr);
        const fromDate = new Date(from);
        const toDate = new Date(to);
        if (toDate >= fromDate) {
            // Calculate the difference in milliseconds between the two dates
            const timeDiff = Math.abs(fromDate.getTime() - toDate.getTime());

            // Convert milliseconds to days
            const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // Check if the difference is more than 31 days
            if (diffDays > 31) {
                alert("Date range cannot be more than 1 month");
                // Reset the end date to be one month after the start date
                const newEndDate = new Date(fromDate.getTime() + 31 * 24 * 60 * 60 * 1000);
                $("#to_filter").datepicker('setDate', newEndDate);
            }
        } else {
            alert("The to date must be greater than or equal to the from date");
            $("#to_filter").datepicker('setDate', fromDate);
        }
    }
}

function getYearStartAndEndDates(year) {
    const startDate = new Date();
    startDate.setFullYear(year);
    startDate.setMonth(0);
    startDate.setDate(1);

    const endDate = new Date();
    endDate.setFullYear(year);
    endDate.setMonth(11);
    endDate.setDate(31);

    return { startDate: formatDate(startDate), endDate: formatDate(endDate) };
}

function getQuarterStartAndEndDates(year, quarter) {
    const startDate = new Date(year, (quarter - 1) * 3, 1); // Lấy ngày đầu tiên của quý
    const endDate = new Date(year, quarter * 3, 0); // Lấy ngày cuối cùng của quý

    return {
        startDate: formatDate(startDate),
        endDate: formatDate(endDate),
    };
}
function getMonthStartAndEndDates(year, month) {
    const startDate = new Date(year, month - 1, 1); // Lấy ngày đầu tiên của tháng
    const endDate = new Date(year, month, 0); // Lấy ngày cuối cùng của tháng

    return {
        startDate: formatDate(startDate),
        endDate: formatDate(endDate),
    };
}

function getDaysInWeeks(year) {
    const weeks = [];

    // Set start and end dates for the year
    const start_date = new Date(year, 0, 1);
    const end_date = new Date(year, 11, 31);

    // Loop through each week of the year
    let week_num = 1;
    let start_of_week = new Date(start_date);
    while (start_of_week < end_date) {
        const end_of_week = new Date(start_of_week);
        end_of_week.setDate(end_of_week.getDate() + 6);

        // Add the week to the object
        weeks[week_num] = {
            'startDate': formatDate(new Date(start_of_week)),
            'endDate': formatDate(new Date(end_of_week))
        };

        // Move to the next week
        start_of_week.setDate(start_of_week.getDate() + 7);
        week_num++;
    }

    return weeks;
}

function formatDate(date) {
    let year = date.getFullYear();
    let month = (date.getMonth() + 1).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');

    return `${day}-${month}-${year}`;
}

function convertDate(dateStr) {
    const dateParts = dateStr.split('-');
    return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
}
