// Função que controla a exibição do menu em dispositivos móveis
function menuShow() {
    // Seleciona o elemento com a classe 'mobile-menu' (menu mobile)
    let menuMobile = document.querySelector('.mobile-menu');

    // Verifica se o menu já está aberto, verificando se a classe 'open' está presente
    if (menuMobile.classList.contains('open')) {
        // Se o menu estiver aberto, remove a classe 'open' para fechá-lo
        menuMobile.classList.remove('open');

        // Altera o ícone do menu para o ícone de menu padrão
        document.querySelector('.icon').src = "img/menu-icon.svg";
    } else {
        // Se o menu não estiver aberto, adiciona a classe 'open' para abri-lo
        menuMobile.classList.add('open');

        // Altera o ícone do menu para o ícone de fechar menu
        document.querySelector('.icon').src = "img/close-menu.svg";
    }
}
