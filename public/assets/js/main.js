// Scroll reveal animation
const revealElements = document.querySelectorAll('.reveal');

// Scroll reveal — triggers every time element enters viewport
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    } else {
      entry.target.classList.remove('visible');
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Hero cursor glow effect
const hero = document.getElementById('hero');
const heroGlow = document.getElementById('heroGlow');

if (hero && heroGlow) {
  hero.addEventListener('mousemove', (e) => {
    const rect = hero.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    heroGlow.style.left = x + 'px';
    heroGlow.style.top = y + 'px';
  });
}

// Password toggle
const togglePassword = document.getElementById('togglePassword');
if (togglePassword) {
  togglePassword.addEventListener('click', () => {
    const input = document.getElementById('password');
    const icon = togglePassword.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('ti-eye', 'ti-eye-off');
    } else {
      input.type = 'password';
      icon.classList.replace('ti-eye-off', 'ti-eye');
    }
  });
}
const mobileMenuBtn = document.getElementById('mobileMenuToggle');
const navLinks = document.querySelector('.nav-links');

if (mobileMenuBtn && navLinks) {
  mobileMenuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    navLinks.classList.toggle('open');
    const icon = mobileMenuBtn.querySelector('i');
    if (icon) {
      icon.classList.toggle('ti-menu-2');
      icon.classList.toggle('ti-x');
    }
  });

  // Close when clicking outside
  document.addEventListener('click', (e) => {
    if (!navLinks.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
      navLinks.classList.remove('open');
      const icon = mobileMenuBtn.querySelector('i');
      if (icon) {
        icon.classList.add('ti-menu-2');
        icon.classList.remove('ti-x');
      }
    }
  });
}