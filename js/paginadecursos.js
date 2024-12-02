// Aguarda o carregamento completo do conteúdo da página (DOM)
document.addEventListener('DOMContentLoaded', function () {
    // Seleciona todos os itens de vídeo com a classe 'video-item'
    const videoItems = document.querySelectorAll('.video-item');

    // Itera sobre cada item de vídeo
    videoItems.forEach(item => {
        // Seleciona a pergunta (pergunta do vídeo) e a resposta do item de vídeo
        const question = item.querySelector('.video-question');
        const answer = item.querySelector('.video-answer');

        // Adiciona um ouvinte de evento para o clique na pergunta
        question.addEventListener('click', () => {
            // Verifica se a resposta já está aberta (tem a classe 'show')
            const isOpen = answer.classList.contains('show');

            // Fecha todas as respostas removendo a classe 'show' e adicionando a classe 'hide'
            document.querySelectorAll('.video-answer').forEach(ans => {
                ans.classList.remove('show');
                ans.classList.add('hide');
            });

            // Remove a classe 'openn' de todas as perguntas
            document.querySelectorAll('.video-question').forEach(q => {
                q.classList.remove('openn');
            });

            // Se a resposta não estava aberta, abre a resposta e adiciona a classe 'openn' à pergunta
            if (!isOpen) {
                answer.classList.remove('hide');
                answer.classList.add('show');
                question.classList.add('openn');
            }
        });

        // Adiciona um ouvinte de evento para quando a tecla Enter ou Espaço for pressionada na pergunta
        question.addEventListener('keydown', (e) => {
            // Se a tecla pressionada for 'Enter' ou 'Espaço', simula o clique na pergunta
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault(); // Impede o comportamento padrão
                question.click();  // Executa o clique no evento da pergunta
            }
        });
    });
});

// Seleciona todos os botões com a classe 'concluir-video'
document.querySelectorAll('.concluir-video').forEach(button => {
    // Adiciona um ouvinte de evento para o clique no botão
    button.addEventListener('click', () => {
        // Aguarda 500ms após o clique e então recarrega a página
        setTimeout(() => {
            window.location.reload(); // Recarrega a página após o atraso
        }, 500); // Tempo de espera de 500ms
    });
});
