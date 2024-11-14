document.addEventListener('DOMContentLoaded', function() {
    const videoItems = document.querySelectorAll('.video-item');

    videoItems.forEach(item => {
        const question = item.querySelector('.video-question');
        const answer = item.querySelector('.video-answer');

        question.addEventListener('click', () => {
            const isOpen = answer.classList.contains('show');

            // Fecha todas as respostas
            document.querySelectorAll('.video-answer').forEach(ans => {
                ans.classList.remove('show');
                ans.classList.add('hide');
            });
            document.querySelectorAll('.video-question').forEach(q => {
                q.classList.remove('open');
            });
            if (!isOpen) {
                answer.classList.remove('hide');
                answer.classList.add('show');
                question.classList.add('open');
            }
        });
        question.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                question.click();
            }
        });
    });
});

