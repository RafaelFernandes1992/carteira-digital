let anoAtual = new Date().getFullYear();
let chart;

document.addEventListener("DOMContentLoaded", async function () {
    await getTotalizarPorCompetenciaAnual();
    handleBtnClicked();
});

function handleBtnClicked() {
    const btn = document.getElementById('search-graph');
    const yearInput = document.getElementById('search-input');

    btn.addEventListener('click', async function (e) {
        e.preventDefault();
        anoAtual = yearInput.value;
        await getTotalizarPorCompetenciaAnual();
    });
}

async function getTotalizarPorCompetenciaAnual() {
    try {
        const response = await axios.get('/dashboard/competencia', {
            params: {
                year: anoAtual
            }
        });

        const options = defineOptionsToGraphCompetencia(anoAtual);
        options.series = [
            {
                name: 'Receita',
                data: response.data.data.receita
            },
            {
                name: 'Despesa',
                data: response.data.data.despesa
            },
            {
                name: 'Investimento',
                data: response.data.data.investimento
            }
        ];

        await renderGraphCompetencia(options);

    } catch (e) {
        console.log(e);
    }
}

function defineOptionsToGraphCompetencia(anoAtual) {
    return  {
        chart: {
            type: 'line',
            height: 400,
        },
        colors: ['deepskyblue', 'lightsalmon', 'mediumseagreen'],
        xaxis: {
            categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
        },
        yaxis: {
            title: {
                text: 'Valores'
            },
            tickAmount: 7 // Ajuste o número de ticks no eixo Y
        },
        title: {
            text: `Totalizadores por Competência (${anoAtual})`,
            align: 'center'
        },
        legend: {
            position: 'top'
        }
    };
}

async function renderGraphCompetencia(options) {
    if (chart) {
        chart.updateOptions(options); // Atualiza o gráfico existente
    } else {
        chart = new ApexCharts(document.querySelector("#chart"), options);
        await chart.render();
    }
}
