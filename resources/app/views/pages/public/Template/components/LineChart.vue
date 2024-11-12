<template>
  <Line :chartData="chartData" :options="chartOptions" />
</template>

<script>
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, LineElement, PointElement, LinearScale, Title, Tooltip, CategoryScale } from 'chart.js';
import { computed } from 'vue';

ChartJS.register(LineElement, PointElement, LinearScale, Title, Tooltip, CategoryScale);

export default {
  components: { Line },
  props: {
    increase: {
      type: Boolean,
      required: true,
    },
    datasets: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    // Definición de chartData basado en las props
    const chartData = computed(() => ({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Data',
          borderColor: props.increase ? '#28C165' : '#F4574D', // Verde si increase es true, rojo si es false
          backgroundColor: props.increase ? 'rgba(40, 193, 101, 0.2)' : 'rgba(244, 87, 77, 0.2)', // Fondo semitransparente
          data: props.datasets,
          fill: true,
          tension: 0.3, // Hace la línea suave
        },
      ],
    }));

    // Configuración básica para el gráfico
    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false, // Oculta la leyenda
        },
        tooltip: {
          callbacks: {
            label: (tooltipItem) => `${tooltipItem.raw}`, // Muestra el valor directamente
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true, // Comienza el eje Y en 0
        },
      },
    };

    return {
      chartData,
      chartOptions,
    };
  },
};
</script>
