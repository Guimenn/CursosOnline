<?php

function Footer() {
    echo'    <footer class="footer">
  <div class="container">
    <div class="section desenvolvedores">
      <h4>Desenvolvedores</h4>
      <p>Desenvolvido por <a href="#">EstudoMind</a></p>
      <p><a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a></p>
    </div>

    <div class="section contato">
      <h4>Contato</h4>
      <p>Telefone: (11) 4002-8922</p>
      <p>Email: <a href="mailto:contato@estudomind.com.br">contato@estudomind.com.br</a></p>
    </div>

    <div class="section newsletter">
      <h4>Newsletter</h4>
      <p>Receba nossas novidades:</p>
      <form>
        <input type="email" placeholder="Seu e-mail" required>
        <button type="submit">Inscrever-se</button>
      </form>
    </div>

    <div class="section parceiros">
      <h4>Parceiros</h4>
      <ul>
        <li><a href="#">Guimen</a></li>
        <li><a href="#">libre000</a></li>
        <li><a href="#">Vini100365</a></li>
      </ul>
    </div>
  </div>

  <div class="social-icons">
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-linkedin-in"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>

  <div class="copyright">
    <p>&copy; 2024 EstudoMind. Todos os direitos reservados.</p>
  </div>
</footer>';
}
?>