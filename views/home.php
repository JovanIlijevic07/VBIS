<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <label for="total-price-per-month-from" class="form-label">From:</label>
                        <input type="date"
                               name="total-price-per-month-from"
                               class="form-control total-price-per-month-input-helper"
                               id="total-price-per-month-from">
                    </div>
                    <div class="col-md-6">
                        <label for="total-price-per-month-to" class="form-label">To</label>
                        <input type="date" name="total-price-per-month-to"
                               class="form-control total-price-per-month-input-helper"
                               id="total-price-per-month-to">
                    </div>
                </div>
            </div>
            <div class=" card-body">
                <div class="chart">
                    <div id="total-price-per-month-canvas">
                        <canvas id="total-price-per-month"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 634px;"
                                class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <label for="total-price-per-brand-input" class="form-label">Brand name:</label>
                        <input type="text"
                               name="total-price-per-brand-input"
                               class="form-control"
                               id="total-price-per-brand-input">
                    </div>
                </div>
            </div>
            <div class=" card-body">
                <div class="chart">
                    <div id="total-price-per-brand-canvas">
                        <canvas id="total-price-per-brand"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 634px;"
                                class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body"></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        generateTotalPricePerMonth($("#total-price-per-month-from").val(), $("#total-price-per-month-to").val());
        generateTotalPricePerBrand($("#total-price-per-brand-input").val());

        $(".total-price-per-month-input-helper").change(function () {
            generateTotalPricePerMonth($("#total-price-per-month-from").val(), $("#total-price-per-month-to").val());
        });

        $("#total-price-per-brand-input").keyup(function () {
            generateTotalPricePerBrand($("#total-price-per-brand-input").val());
        });
    });

    function generateTotalPricePerMonth(dateFrom, dateTo) {
        $("#total-price-per-month-canvas").empty();
        $("#total-price-per-month-canvas").append(
            '<canvas id="total-price-per-month"' +
            'style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 634px;"' +
            'class="chartjs-render-monitor"></canvas>'
        );

        if (!dateFrom) {
            dateFrom = new Date();
            dateFrom.setMonth(dateFrom.getMonth() - 6);
            dateFrom = new Date(dateFrom).toISOString().split('T')[0];

            $("#total-price-per-month-from").val(dateFrom);
        }

        if (!dateTo) {
            dateTo = new Date();
            dateTo = new Date(dateTo).toISOString().split('T')[0];

            $("#total-price-per-month-to").val(dateTo);
        }

        let url = `/reportTotalPricePerMonth?dateFrom=${dateFrom}&dateTo=${dateTo}`;

        $.getJSON(url, function (result) {
            let labels = result.map(function (e) {
                return e.month;
            });

            let values = result.map(function (e) {
                return e.total_price;
            });

            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Total price per month",
                        data: values,
                        backgroundColor: ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
                            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF']
                    }]
            }

            let options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

            let graph = $("#total-price-per-month").get(0).getContext('2d');

            createGraph(setData, graph, 'bar', options);
        });
    }

    function generateTotalPricePerBrand(searchQuery) {
        $("#total-price-per-brand-canvas").empty();
        $("#total-price-per-brand-canvas").append(
            '<canvas id="total-price-per-brand"' +
            'style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 634px;"' +
            'class="chartjs-render-monitor"></canvas>'
        );

        if (!searchQuery)
        {
            searchQuery = "";
        }

        let url = `/reportTotalPricePerBrand?searchQuery=${searchQuery}`;

        $.getJSON(url, function (result) {
            let labels = result.map(function (e) {
                return e.brand;
            });

            let values = result.map(function (e) {
                return e.total_price;
            });

            let setData = {
                labels: labels,
                datasets: [
                    {
                        label: "Total price per brand",
                        data: values,
                        backgroundColor: ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
                            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
                            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
                            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
                            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
                            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
                            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
                            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
                            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
                            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF']
                    }]
            }

            let options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

            let graph = $("#total-price-per-brand").get(0).getContext('2d');

            createGraph(setData, graph, 'line', options);
        });
    }
</script>