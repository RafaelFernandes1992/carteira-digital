let anoAtual = new Date().getFullYear();
let chart;
const anoDashboard = document.getElementById('dashboard-year');

const totalCompetencia = document.getElementById('total_competencias');
const totalReceitas = document.getElementById('total_receitas');
const totalDespesas = document.getElementById('total_despesas');
const totalInvestimentos = document.getElementById('total_investimentos');
const btn = document.getElementById('btn-search');

document.addEventListener("DOMContentLoaded", async function () {
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    await getQuantitativosCards();
    await getTotalizarPorCompetenciaAnual();

    btn.innerHTML = '<i class="bi bi-search"></i>';
    btn.disabled = false;
    handleBtnClicked();
});

function handleBtnClicked() {
    const yearInput = document.getElementById('search-input');

    btn.addEventListener('click', async function () {
        anoAtual = yearInput.value;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        await getQuantitativosCards();
        await getTotalizarPorCompetenciaAnual();
        btn.innerHTML = '<i class="bi bi-search"></i>';
        btn.disabled = false;
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
async function getQuantitativosCards() {
    try {
        const response = await axios.get('/dashboard/cards', {
            params: {
                year: anoAtual
            }
        });

        anoDashboard.innerHTML = anoAtual
        totalCompetencia.innerHTML = response.data.data.total_competencias;
        totalReceitas.innerHTML = response.data.data.total_receitas;
        totalDespesas.innerHTML = response.data.data.total_despesas;
        totalInvestimentos.innerHTML = response.data.data.total_investimentos;

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
