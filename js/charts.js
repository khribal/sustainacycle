//HORIZONTAL BAR CHART
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
                  position: 'right',
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


// PIE CHART

// Define a function to create a pie chart
export function createPieChart(quantity, materialName) {
  const data = {
    labels: materialName,
    datasets: [
      {
        label: 'Quantity (lbs)',
        data: quantity,
        backgroundColor: ['#FF6347', '#FFD700', '#ADFF2F', '#87CEEB', '#8A2BE2'],
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
          display: true,
          text: 'Donated Textiles by Type',
        },
      },
    },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById('chart-pie').getContext('2d');
  new Chart(chartCanvas, config);
}


//LINE CHART

export function createLine(quantity, labels){

const dataForChart = {
    labels: labels,
    datasets: [{
    label: 'lbs of materials donated',
    data: quantity,
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
    }]
};
const lineChartConfig = {
type: 'line',
data: dataForChart,
};

const lineChartCanvas = document.getElementById('lineChartCanvas').getContext('2d');

// Create the line chart
new Chart(lineChartCanvas, lineChartConfig);
}




//BAR CHART for material types
export function materialBar(user_data, user_labels){
 
  const matData = {
    labels: user_labels,
    datasets: [{
      label: 'Material',
      data: user_data,
    }]
  };
 
 
  const configuringBar = {
    type: 'bar',
    data: matData,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };
  
const materialCanvas = document.getElementById('matCanv').getContext('2d');

// Create the bar chart
new Chart(materialCanvas, configuringBar);
}



//MIXED CHART  
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