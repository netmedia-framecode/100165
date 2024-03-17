// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart");

// Assuming that "dataGrafik" is an array of objects with "periode" (year) and "hasil_prediksi" properties
var categories = [...new Set(dataGrafik.map((item) => item.category))];
var yearsSet = new Set(dataGrafik.map((item) => item.periode));
var years = Array.from(yearsSet).sort((a, b) => a - b); // Sort the years in ascending order

// Create an array of empty data structures for each category
var datasets = categories.map((category, index) => {
  return {
    label: category,
    backgroundColor: getBackgroundColor(index),
    hoverBackgroundColor: getHoverBackgroundColor(index),
    borderColor: getBorderColor(index),
    borderWidth: 1,
    data: years.map((year) => {
      var dataPoint = dataGrafik.find(
        (item) => item.category === category && item.periode === year
      );
      return dataPoint ? dataPoint.hasil_prediksi : 0;
    }),
  };
});

var myLineChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: years.map(String), // Convert years to strings for better display
    datasets: datasets,
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0,
      },
    },
    scales: {
      x: {
        type: "category",
        grid: {
          display: false,
          drawBorder: false,
        },
        labels: years.map(String),
      },
      y: {
        position: "left",
        grid: {
          display: false,
        },
        ticks: {
          beginAtZero: true,
          callback: function (value) {
            return number_format(value);
          },
        },
      },
    },
    plugins: {
      legend: {
        display: true,
      },
      tooltip: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            var value =
              chart.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            return datasetLabel + ": " + number_format(value);
          },
        },
      },
    },
  },
});

function getBackgroundColor(index) {
  // Menghasilkan warna latar belakang berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 0.5)",
    "rgba(255, 99, 132, 0.5)",
    "rgba(54, 162, 235, 0.5)",
    "rgba(255, 205, 86, 0.5)",
  ];
  return colors[index % colors.length];
}

function getHoverBackgroundColor(index) {
  // Menghasilkan warna latar belakang hover berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 0.7)",
    "rgba(255, 99, 132, 0.7)",
    "rgba(54, 162, 235, 0.7)",
    "rgba(255, 205, 86, 0.7)",
  ];
  return colors[index % colors.length];
}

function getBorderColor(index) {
  // Menghasilkan warna garis batas berdasarkan indeks
  var colors = [
    "rgba(78, 115, 223, 1)",
    "rgba(255, 99, 132, 1)",
    "rgba(54, 162, 235, 1)",
    "rgba(255, 205, 86, 1)",
  ];
  return colors[index % colors.length];
}
