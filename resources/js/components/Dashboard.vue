<template>
  <main class="main">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Escritorio</a>
      </li>
    </ol>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-chart">
                <div class="car-header">
                  <h4>Ingresos</h4>
                </div>
                <div class="card-content">
                  <div class="ct-chart">
                    <canvas id="ingresos"></canvas>
                  </div>
                </div>
                <div class="card-footer">
                  <p>Compras de los últimos meses.</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-chart">
                <div class="car-header">
                  <h4>Ventas</h4>
                </div>
                <div class="card-content">
                  <div class="ct-chart">
                    <canvas id="ventas"></canvas>
                  </div>
                </div>
                <div class="card-footer">
                  <p>ventas de los últimos meses.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
export default {
  data() {
    return {
      varIngreso: null,
      charIngreso: null,
      ingresos: [],
      varTotalIngreso: [],
      varMesIngreso: [],

      varVenta: null,
      charVenta: null,
      ventas: [],
      varTotalVenta: [],
      varMesVenta: []
    };
  },
  methods: {
    getIngresos() {
      let me = this;
      let url = "/dashboard";
      axios
        .get(url)
        .then(response => {
          let respuesta = response.data;
          me.ingresos = respuesta.ingresos;
          me.loadIngresos();
        })
        .catch(error => {
          console.log("Mensaje : getIngresos -> error", error);
        });
    },
    getVentas() {
      let me = this;
      let url = "/dashboard";
      axios
        .get(url)
        .then(response => {
          let respuesta = response.data;
          me.ventas = respuesta.ventas;
          me.loadVentas();
        })
        .catch(error => {
          console.log("Mensaje : getVenta -> error", error);
        });
    },
    loadIngresos() {
      let me = this;
      me.ingresos.map(x => {
        me.varMesIngreso.push(x.mes);
        me.varTotalIngreso.push(x.total);
      });
      me.varIngreso = document.getElementById("ingresos").getContext("2d");
      me.charIngreso = new Chart(me.varIngreso, {
        type: "bar",
        data: {
          labels: me.varMesIngreso,
          datasets: [
            {
              label: "Ingresos",
              data: me.varTotalIngreso,
              backgroundColor: ["rgba(255, 99, 132, 1)"],
              borderColor: ["rgba(255, 99, 132, 1)"],
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true
                }
              }
            ]
          }
        }
      });
    },
    loadVentas() {
      let me = this;
      me.ventas.map(x => {
        me.varMesVenta.push(x.mes);
        me.varTotalVenta.push(x.total);
      });
      me.varVenta = document.getElementById("ventas").getContext("2d");
      me.charVenta = new Chart(me.varVenta, {
        type: "bar",
        data: {
          labels: me.varMesVenta,
          datasets: [
            {
              label: "Ventas",
              data: me.varTotalVenta,
              backgroundColor: ["rgba(54, 162, 235, 1)"],
              borderColor: ["rgba(54, 162, 235, 1)"],
              borderWidth: 1
            }
          ]
        },
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true
                }
              }
            ]
          }
        }
      });
    }
  },
  mounted() {
    this.getIngresos();
    this.getVentas();
  }
};
</script>
