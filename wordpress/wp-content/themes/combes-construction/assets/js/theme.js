(function () {
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /**
   * Scroll-triggered animations driven by CSS classes:
   *  - animate-fade-up
   *  - animate-fade-in
   *  - animate-slide-left
   *  - animate-slide-right
   *  - animate-zoom-in
   *
   * Optional stagger using:
   *  - animate-delay-1
   *  - animate-delay-2
   *  - animate-delay-3
   */
  function initScrollAnimations() {
    const selector = [
      ".animate-fade-up",
      ".animate-fade-in",
      ".animate-slide-left",
      ".animate-slide-right",
      ".animate-zoom-in"
    ].join(",");

    const elements = document.querySelectorAll(selector);
    if (!elements.length) return;

    if (prefersReducedMotion) {
      elements.forEach((el) => el.classList.add("in-view"));
      return;
    }

    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("in-view");
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.25 }
    );

    elements.forEach((el) => observer.observe(el));
  }

  /**
   * Animated counters
   * Usage: <span class="stat-counter animate-fade-up" data-counter data-counter-target="50">0</span>
   */
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

  /**
   * Parallax backgrounds
   * Usage: add class "has-parallax-bg" to a Kadence Row with a background image.
   */
  function initParallax() {
    const elements = document.querySelectorAll(".has-parallax-bg");
    if (!elements.length || prefersReducedMotion) return;

    let ticking = false;

    const update = () => {
      const scrollY = window.scrollY || window.pageYOffset;

      elements.forEach((el) => {
        const speedAttr = el.getAttribute("data-parallax-speed");
        const speed = speedAttr ? parseFloat(speedAttr) : 0.2;
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

  /**
   * Smooth scroll for internal anchors
   */
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

  /**
   * Slight hover zoom on project card images
   */
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
    initScrollAnimations();
    initCounters();
    initParallax();
    initSmoothScroll();
    initProjectHover();
  });
})();
