import Chart from 'chart.js/auto'

function createChart(data){
  new Chart(
    document.getElementById('chart-space'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.donator),
        datasets: [
          {
            label: 'Acquisitions by year',
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

 
