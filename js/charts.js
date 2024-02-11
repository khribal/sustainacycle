//HORIZONTAL BAR CHART
export function createHorizontalBarChart(labels, dataset) {
  // Set up data for the chart
  const data = {
      labels: labels,
      datasets: [
          {
              label: `Lbs of textile donated:`,
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
                  display: true,
                  text: 'Top Manufacturers and Lbs of Accepted Textiles'
              }
          }
      },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById('chart-space').getContext('2d');
  new Chart(chartCanvas, config);
}


// PIE CHART

// Define a function to create a pie chart
export function createPieChart(quantity, materialName) {
  const data = {
    labels: materialName,
    datasets: [
      {
        label: 'Dataset 1',
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