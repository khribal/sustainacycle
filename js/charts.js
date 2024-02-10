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

