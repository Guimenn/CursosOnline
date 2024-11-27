document.addEventListener("DOMContentLoaded", function() {
    // Define o formulário de registro como padrão
    const container = document.getElementById('container');
    container.classList.add("right-panel-active"); // Adiciona a classe ao carregar a página

    // Seleciona os botões de alternância
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');

    // Alterna para o formulário de registro ao clicar em "Registre-se"
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    // Alterna para o formulário de login ao clicar em "Login"
    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
});