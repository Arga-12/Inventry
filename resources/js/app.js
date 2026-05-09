import ApexCharts from "apexcharts";

const options = {
    chart: {
        type: "bar",
        height: 350,
        toolbar: { show: false },
    },

    series: [
        {
            name: "Pengembalian",
            data: [12, 14, 13, 15, 14],
        },
        {
            name: "Peminjaman",
            data: [25, 27, 26, 28, 27],
        },
    ],

    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "Mei"],
    },

    plotOptions: {
        bar: {
            columnWidth: "50%",
        },
    },

    colors: ["#F99417", "#4D4C7D"],

    dataLabels: {
        enabled: false,
    },

    legend: {
        position: "bottom",
        horizontalAlign: "left",
    },

    grid: {
        borderColor: "#eee",
    },
};

const chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
