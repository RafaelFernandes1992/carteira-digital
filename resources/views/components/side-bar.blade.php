<div class="sidebar col-sm-4 col-md-3 col-lg-2 p-0">

    <div class="d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">

        <h3 class="navbar-brand me-0 px-3 p-2">
            Carteira Digital
        </h3>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('index.home') }}">                   
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('competencia.index') }}">                    
                    <i class="bi bi-wallet2"></i>
                    <span>Carteira</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('alerta-notificacao.index') }}">                   
                    <i class="bi bi-bell"></i>
                    <span>Alertas e Notificações</span>
                </a>
            </li>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                <span>Gerenciar</span>
            </h6>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('tipo-lancamento.index') }}">
                    <i class="bi bi-currency-dollar"></i>
                    <span>Tipos de Lançamento</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('carro.index') }}">
                    <i class="bi bi-car-front"></i>
                    <span>Carros</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('cartao-credito.index') }}">
                    <i class="bi bi-credit-card-2-back"></i> 
                    <span>Cartões de Crédito</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('usuario.index') }}">
                    <i class="bi bi-person"></i> 
                    <span>Usuários</span>  
                </a>
            </li>

        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
            <span>Relatórios</span>
        </h6>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    Lançamentos da Carteira
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    Receitas, Despesas e Investimentos
                </a>
            </li>

        </ul>
    </div>
    <form action="{{ route('usuario.logout') }}" method="post">
        <div class="d-flex justify-content-center py-3">
            <button type="submit" class="btn btn-secondary"> 
                <i class="bi bi-power"></i> 
                <span>Sair</span>
            </button>
        </div>
    </form>

</div>