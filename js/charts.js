export function createChart(data){
  new Chart(
    document.getElementById('chart-space'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => `${row.donator} - ${row.materialName}`), // Concatenate donator and material name
        datasets: [
          {
            label: 'Pounds of material donated',
            data: data.map(row => row.quantity),
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set the color here
            borderColor: 'rgba(75, 192, 192, 1)', // Border color (if needed)
            borderWidth: 1, // Border width (if needed)
          }
        ]
      }
    }
  );
}

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
                  text: 'Horizontal Bar Chart'
              }
          }
      },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById('chart-space').getContext('2d');
  new Chart(chartCanvas, config);
}


export function createPieChart(data) {
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
          text: 'Chart.js Pie Chart',
        },
      },
    },
  };

  // Create the chart instance
  const chartCanvas = document.getElementById('chart-pie').getContext('2d');
  new Chart(chartCanvas, config);
}
