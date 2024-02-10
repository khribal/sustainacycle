import Chart from 'chart.js/auto'

//   const data = [
//     { year: 2010, count: 10 },
//     { year: 2011, count: 20 },
//     { year: 2012, count: 15 },
//     { year: 2013, count: 25 },
//     { year: 2014, count: 22 },
//     { year: 2015, count: 30 },
//     { year: 2016, count: 28 },
//   ];

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

 
