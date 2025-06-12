document.addEventListener('DOMContentLoaded', function () {
 
  // ===== Ocultar/mostrar logo na navbar =====
  const navLogoSmall = document.querySelector('.nav-logo-small');
  function toggleNavLogo() {
    if (window.scrollY <= 300) {
      navLogoSmall.style.opacity = '0';
      navLogoSmall.style.visibility = 'hidden';
    } else {
      navLogoSmall.style.opacity = '1';
      navLogoSmall.style.visibility = 'visible';
    }
  }
  toggleNavLogo();
  window.addEventListener('scroll', toggleNavLogo);

  // ===== Exibir logo ao rolar até o footer =====
  const logo = document.querySelector('.nav-logo-small');
  const footer = document.querySelector('footer');
  window.addEventListener('scroll', function () {
    const footerPosition = footer.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;
    if (footerPosition < windowHeight) {
      logo.classList.add('show');
    } else {
      logo.classList.remove('show');
    }
  });

  // ===== Envio do formulário =====
  const form = document.getElementById("formContato");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const dados = new FormData(form);
      fetch("URL_DO_SEU_SCRIPT", {
        method: "POST",
        body: dados
      })
        .then(() => document.getElementById("resposta").innerText = "Mensagem enviada com sucesso!")
        .catch(() => document.getElementById("resposta").innerText = "Erro ao enviar a mensagem.");
    });
  }

  // ===== Ativar link da navbar =====
  const navLinks = document.querySelectorAll('.nav a');
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // ===== Slider/carrossel =====
  const items = document.querySelectorAll('.carousel-item');
  const dots = document.querySelectorAll('.dot');
  let currentIndex = 0;

  function showSlide(index) {
    items.forEach((item, i) => {
      item.classList.toggle('active', i === index);
      dots[i].classList.toggle('active', i === index);
    });
    currentIndex = index;
  }

  if (items.length && dots.length) {
    setInterval(() => {
      const nextIndex = (currentIndex + 1) % items.length;
      showSlide(nextIndex);
    }, 10000);

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => showSlide(i));
    });
  }
});
