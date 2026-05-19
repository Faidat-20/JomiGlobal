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