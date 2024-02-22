///////////////HORIZONTAL BAR CHART
export function createHorizontalBarChart(labels, dataset, chartspace) {
  // Set up data for the chart
  const data = {
      labels: labels,
      datasets: [
          {
              label: `Lbs of textiles:`,
              data: dataset,
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              borderColor: 'rgba(255, 99, 132, 1)',
              borderWidth: 1,
          }
      ]
  };

  // Set up the chart configuration
  const config = {
      type: 'bar',
      data: data,
      options: {
          indexAxis: 'y',
          responsive: true,
          plugins: {
              legend: {
                  display: false,
              },
              title: {
                  display: false,
              }
          }
      },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById(chartspace).getContext('2d');
  new Chart(chartCanvas, config);
}


////////////////////VERTICAL BAR
export function vertBar(vertLabels, vertPHPData, vertChartSpot){  
  const vertData = {
    labels: vertLabels,
    datasets: [{
      label: 'lbs Donated',
      data: vertPHPData,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)'
      ],
      borderWidth: 1
    }]
  };

  const vertConfig = {
    type: 'bar',
    data: vertData,
    options: {
      plugins: {
        legend: {
            display: false,
        },
        title: {
            display: false,
        }
    },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

    // Create the chart instance
    const vertNewChart = document.getElementById(vertChartSpot).getContext('2d');
    new Chart(vertNewChart, vertConfig);
}


//another version of vertical bar (two different value sources)
////////////////////VERTICAL BAR
export function vertBarSpecific(vertLabels1, vertLabels2, vertPHPData2, vertPHPData22, vertChartSpot2){  
  const vertData2 = {
    labels: [vertLabels1, vertLabels2],
    datasets: [{
      label: 'lbs Donated',
      data: [vertPHPData2, vertPHPData22],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)'
      ],
      borderWidth: 1
    }]
  };

  const vertConfig2 = {
    type: 'bar',
    data: vertData2,
    options: {
      plugins: {
        legend: {
            display: false,
        },
        title: {
            display: false,
        }
    },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

    // Create the chart instance
    const vertNewChart2 = document.getElementById(vertChartSpot2).getContext('2d');
    new Chart(vertNewChart2, vertConfig2);
}


///////////////// PIE CHART
// Define a function to create a pie chart
export function createPieChart(userVal, allVal, pieCanvas) {
  const data = {
    labels: ["Your textile donations (lbs)", "All textile donations (lbs)"],
    datasets: [
      {
        data: [userVal, allVal],
        backgroundColor: ['#FF6347', '#FFD700'],
      },
    ],
  };

  const config = {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: false,
        },
      },
    },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById(pieCanvas).getContext('2d');
  new Chart(chartCanvas, config);
}


////////////LINE CHART

export function createLine(quantityLine, labels, lineChartLocation){

const dataForChart = {
    labels: labels,
    datasets: [{
    label: 'lbs of materials donated',
    data: quantityLine,
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
    }]
};
const lineChartConfig = {
type: 'line',
data: dataForChart,
};

const lineChartCanvas = document.getElementById(lineChartLocation).getContext('2d');

// Create the line chart
new Chart(lineChartCanvas, lineChartConfig);
}




//////////MIXED CHART  
let chartInstance = null;
export function mixedChart(mixedLabels, mixedData, mixLineData, barLabel, lineLabel){

  //destroy and recreate chart when date filter is used
  if (chartInstance) {
    chartInstance.destroy();
  }

const mixData = {
  labels: mixedLabels,
  datasets: [{
    type: 'bar',
    label: barLabel,
    data: mixedData,
    borderColor: 'rgb(255, 99, 132)',
    backgroundColor: 'rgba(255, 99, 132, 0.2)'
  }, {
    type: 'line',
    label: lineLabel,
    data: mixLineData,
    fill: false,
    borderColor: 'rgb(54, 162, 235)'
  }]
};


const configMixed = {
  type: 'scatter',
  data: mixData,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
};

const chartSpot = document.getElementById('mixed-chart').getContext('2d');

chartInstance = new Chart(chartSpot, configMixed);

}


export function regBar(compareUser1, compareUser2){

  const compareData = {
    labels: "label", // Only one set of labels for the entire chart
    datasets: [{
      label: 'Your lbs of textile recycled',
      data: compareUser1,
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      borderColor: 'rgb(255, 99, 132)',
      borderWidth: 1
    }, {
      label: 'Average lbs of recycled by other users',
      data: compareUser2,
      backgroundColor: 'rgba(255, 159, 64, 0.2)',
      borderColor: 'rgb(255, 159, 64)',
      borderWidth: 1
    }]
  };

  const compareConfig = {
    type: 'bar',
    data: compareData,
    options: {
      scales: {
        x: {
          type: 'category', // Use a category scale for the x-axis
          barThickness: 'flex',
          barPercentage: 0.5, // Adjust the bar width (0.5 means 50% of the available space)
          offset: true, // Set offset to true to center the bars
          ticks: {
            display: false,  // Set display to false to hide x-axis labels
          }
        },
        y: {
          beginAtZero: true
        }
      }
    }
  };



const chartRegBar = document.getElementById('compare-bar').getContext('2d');

new Chart(chartRegBar, compareConfig);
}