$(document).ready(function () {
    const observer = new MutationObserver((mutations) => {
        if (mutations.find((x) => x.type === "childList")) {
            $('.datepicker').datepicker({
                language: 'vi',
                autoclose: true,
                clearBtn: true,
                todayHighlight: true,
                format: 'dd-mm-yyyy',
                endDate: new Date()
            });
        }
    });
    // Observe for changes in #element and its descendents.
    observer.observe($('#filter_area')[0], {
        subtree: true,
        childList: true,
    });

    $(document).on("change", "#year_filter", function () {
        const value = $(this).val();
        if (value) {
            const type = $("#type_filter").val();
            let date = {};
            if (type === 'year') {
                date = getYearStartAndEndDates(value);
            }
            if (type === 'quarter') {
                date = getQuarterStartAndEndDates(value, $("#quarter_filter").val())
            }
            if (type === 'month') {
                date = getMonthStartAndEndDates(value, $("#month_filter").val())
            }
            if (type === 'week') {
                date = getDaysInWeeks(value)[$("#week_filter").val()];
            }
            $("#from_filter").val(date.startDate);
            $("#to_filter").val(date.endDate);
        }
    });
    $(document).on("change", "#quarter_filter", function () {
        const value = $(this).val();
        if (value) {
            const type = $("#type_filter").val();
            let date = {};
            if (type === 'quarter') {
                date = getQuarterStartAndEndDates($("#year_filter").val(), value)
            }
            $("#from_filter").val(date.startDate);
            $("#to_filter").val(date.endDate);
        }
    });
    $(document).on("change", "#month_filter", function () {
        const value = $(this).val();
        if (value) {
            const type = $("#type_filter").val();
            let date = {};
            if (type === 'month') {
                date = getMonthStartAndEndDates($("#year_filter").val(), value)
            }
            $("#from_filter").val(date.startDate);
            $("#to_filter").val(date.endDate);
        }
    });
    $(document).on("change", "#week_filter", function () {
        const value = $(this).val();
        if (value) {
            const type = $("#type_filter").val();
            let date = {};
            if (type === 'week') {
                date = getDaysInWeeks($("#year_filter").val())[value];
            }
            $("#from_filter").val(date.startDate);
            $("#to_filter").val(date.endDate);
        }

    });
    $(document).on("change", '#from_filter', function () {
        const startDate = $(this).val();
        if (startDate) {
            $('#to_filter').datepicker('setStartDate', startDate);
            const endDate = $('#to_filter').val();
            if (endDate && new Date(convertDate(startDate)) > new Date(convertDate(endDate))) $('#to_filter').val('');
            validateDateRange(startDate, endDate)
        }
    });
    $(document).on("change", '#to_filter', function () {
        const endDate = $(this).val();
        if (endDate) {
            $('#from_filter').datepicker('setEndDate', endDate);
            const startDate = $('#from_filter').val();
            if (startDate && new Date(convertDate(startDate)) > new Date(convertDate(endDate))) $('#from_filter').val('');
            validateDateRange(startDate, endDate)
        }
    });
});

function render_filter(type, first = true) {
    const filter_area = $("#filter_area");
    let html = "";
    const today = formatDate(new Date());
    let yearCurrent = new Date().getFullYear();
    switch (type) {
        case "all":
            filter_area.html("");
            break;
        case "month":
            html = `<div class="col-md-3">
                        <select class="form-control" name="year" id="year_filter">`;
            for (let year = 2024; year <= 2033; year++) {
                html += `<option value="${year}" ${year_request && first ? (year_request == year ? 'selected' : '') : (year == yearCurrent ? 'selected' : '')}>
                        Năm ${year}</option>`;
            }
            html += `</select></div>`;
            html += `<div class="col-md-3">
                        <select class="form-control" name="month" id="month_filter">`;
            for (let month = 1; month <= 12; month++) {
                html += `<option value="${month}" ${month_request == month && first ? 'selected' : ''}>Tháng ${month}</option>`;
            }
            html += `</select></div>`;
            const date = getMonthStartAndEndDates(year_request && first ? year_request : yearCurrent, month_request && first ? month_request : 1);
            html += `<div class="col-md-3">
                        <input value="${date.startDate}" class="form-control" type="text" name="from" id="from_filter" required readonly>
                    </div>
                    <div class="col-md-3">
                        <input value="${date.endDate}" class="form-control" type="text" name="to" id="to_filter" required readonly>
                    </div>`;
            filter_area.html(html);
            break;
        case "week":
            html = `<div class="col-md-3">
                        <select class="form-control" name="year" id="year_filter">`;
            for (let year = 2024; year <= 2033; year++){
                html += `<option value="${year}" ${year_request && first ? (year_request == year ? 'selected' : '') : (year == yearCurrent ? 'selected' : '')}>
                            Năm ${year}</option>`;
            }
            html += `</select></div>`;
            html += `<div class="col-md-3">
                        <select class="form-control" name="week" id="week_filter">`;
            const weeks = getDaysInWeeks(year_request && first ? year_request : yearCurrent);
            for (let week = 1; week <= weeks.length; week++) {
                html += `<option value="${week}" ${week_request == week && first ? 'selected' : ''}>Tuần ${week}</option>`
            }
            html += `</select></div>`;
            html += `<div class="col-md-3">
                        <input value="${weeks[week_request && first ? week_request : 1].startDate}" class="form-control" type="text" name="from"
                            id="from_filter" required readonly />
                    </div>
                    <div class="col-md-3">
                        <input value="${weeks[week_request && first ? week_request : 1].endDate}" class="form-control" type="text"
                            name="to" id="to_filter" required readonly />
                    </div>`;
            filter_area.html(html);
            break;
        case "day":
            html += `<div class="col-md-3">
                        <input value="${from_request && first ? from_request : today}" class="form-control datepicker" type="text"
                            name="from" required id="from_filter" readonly />
                    </div>`;
            filter_area.html(html);
            break;
        case "option":
            html = `<div class="col-md-3">
                        <input value="${from_request && first ? from_request : ''}" type="text" name="from" id="from_filter" class="form-control datepicker"
                            placeholder="From" required readonly />
                    </div>
                    <div class="col-md-3">
                        <input value="${to_request && first ? to_request : ''}" name="to" type="text" id="to_filter" class="form-control datepicker"
                            placeholder="To" required readonly />
                    </div>`;
            filter_area.html(html);
            break;
        default:
            filter_area.html("");
    }
}
