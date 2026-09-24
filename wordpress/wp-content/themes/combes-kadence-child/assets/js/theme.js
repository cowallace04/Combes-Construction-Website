(function () {
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function initCounters() {
    const counters = document.querySelectorAll("[data-counter]");
    if (!counters.length) return;

    const animateCounter = (el) => {
      const target = parseInt(el.getAttribute("data-counter-target"), 10) || 0;
      const duration = parseInt(el.getAttribute("data-counter-duration"), 10) || 1200;
      const start = 0;
      const startTime = performance.now();

      if (prefersReducedMotion) {
        el.textContent = target.toLocaleString();
        return;
      }

      const step = (now) => {
        const elapsed = now - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const value = Math.floor(start + (target - start) * progress);
        el.textContent = value.toLocaleString();
        if (progress < 1) {
          requestAnimationFrame(step);
        }
      };

      requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    counters.forEach((el) => observer.observe(el));
  }

  function initParallax() {
    const elements = document.querySelectorAll("[data-parallax]");
    if (!elements.length || prefersReducedMotion) return;

    let ticking = false;

    const update = () => {
      const scrollY = window.scrollY || window.pageYOffset;

      elements.forEach((el) => {
        const speed = parseFloat(el.getAttribute("data-parallax-speed")) || 0.2;
        const rect = el.getBoundingClientRect();
        const offset = (scrollY + rect.top) * speed * -1;
        el.style.backgroundPosition = `center ${offset}px`;
      });

      ticking = false;
    };

    const onScroll = () => {
      if (!ticking) {
        window.requestAnimationFrame(update);
        ticking = true;
      }
    };

    window.addEventListener("scroll", onScroll, { passive: true });
    update();
  }

  function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    if (!links.length) return;

    links.forEach((link) => {
      link.addEventListener("click", (e) => {
        const targetId = link.getAttribute("href").slice(1);
        const target = document.getElementById(targetId);
        if (!target) return;

        e.preventDefault();
        target.scrollIntoView({
          behavior: prefersReducedMotion ? "auto" : "smooth",
          block: "start"
        });
      });
    });
  }

  function initProjectHover() {
    const cards = document.querySelectorAll(".card--project img");
    if (!cards.length) return;

    cards.forEach((img) => {
      img.style.transition = "transform 220ms ease-out";
      const parent = img.closest(".card--project");
      if (!parent) return;

      parent.addEventListener("mouseenter", () => {
        img.style.transform = "scale(1.03)";
      });
      parent.addEventListener("mouseleave", () => {
        img.style.transform = "scale(1)";
      });
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    initCounters();
    initParallax();
    initSmoothScroll();
    initProjectHover();
  });
})();
