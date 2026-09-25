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
          block: "start",
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

  // NEW: scroll-triggered reveal for .animate-* classes
  function initScrollAnimations() {
    const animated = document.querySelectorAll(
      ".animate-fade-up, .animate-fade-in, .animate-slide-left, .animate-slide-right, .animate-zoom-in"
    );
    if (!animated.length) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("in-view");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );

    animated.forEach((el) => observer.observe(el));
  }

  // NEW: hero slideshow rotation + Ken Burns trigger
  function initHeroSlideshow() {
    const slidesContainer = document.querySelector(".hero-slideshow__slides");
    if (!slidesContainer) return;

    const slides = Array.from(slidesContainer.querySelectorAll(".hero-slideshow__slide"));
    if (slides.length <= 1) return;

    const interval = prefersReducedMotion ? 12000 : 8000;
    let current = 0;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        const isActive = i === index;
        slide.classList.toggle("is-active", isActive);
        slide.classList.toggle("is-animate", isActive && !prefersReducedMotion);
      });
    }

    // initial state
    showSlide(current);

    setInterval(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, interval);
  }

    // NEW: Build With Combes multi-step wizard
    // Build With Combes multi-step wizard
  function initBuildWizard() {
    const form = document.querySelector('#build-with-combes-form');
    if (!form) return;

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const steps = Array.from(form.querySelectorAll('.build-step'));
    const progressFill = document.querySelector('.build-progress__bar-fill');
    const totalSteps = steps.length;
    let currentIndex = 0;

    const groupToField = {
      project_type: 'bw_project_type',
      services: 'bw_services',
      budget: 'bw_budget_range',
      timeline: 'bw_timeline',
    };

    function updateProgress() {
      if (!progressFill) return;
      const pct = (currentIndex / (totalSteps - 1)) * 100;
      progressFill.style.width = pct + '%';
    }

    function showStep(index) {
      if (index < 0 || index >= totalSteps) return;
      steps.forEach((step, i) => {
        step.classList.toggle('is-active', i === index);
      });
      currentIndex = index;
      updateProgress();

      if (!prefersReducedMotion) {
        const active = steps[currentIndex];
        if (active) {
          active.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }

      // Populate review on final step
      if (currentIndex === totalSteps - 1) {
        populateReview();
      }
    }

    function populateReview() {
      const reviewTargets = form.querySelectorAll('[data-review]');
      reviewTargets.forEach((el) => {
        const key = el.getAttribute('data-review');
        if (!key) return;
        const input = form.querySelector(`[name="${key}"]`);
        if (!input) return;
        let value = '';

        if (input.tagName === 'TEXTAREA' || input.tagName === 'INPUT') {
          value = input.value;
        } else {
          value = input.textContent || '';
        }

        el.textContent = value || '—';
      });
    }

    // Card selection groups (project type, services, budget, timeline)
    form.addEventListener('click', (e) => {
      const card = e.target.closest('.build-card--select');
      if (!card) return;
      e.preventDefault();

      const group = card.getAttribute('data-group');
      const value = card.getAttribute('data-value');
      if (!group || !value) return;

      // deselect siblings
      const siblings = form.querySelectorAll(`.build-card--select[data-group="${group}"]`);
      siblings.forEach((el) => el.classList.remove('is-selected'));
      card.classList.add('is-selected');

      const fieldName = groupToField[group];
      if (!fieldName) return;

      const hidden = form.querySelector(`[name="${fieldName}"]`);
      if (hidden) {
        hidden.value = value;
      }
    });

    // Next / Back buttons with basic validation
    form.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-role]');
      if (!btn) return;

      e.preventDefault();
      const role = btn.getAttribute('data-role');

      if (role === 'next') {
        const activeStep = steps[currentIndex];
        if (activeStep) {
          const required = activeStep.querySelectorAll('[required]');
          for (const input of required) {
            if (!input.value) {
              input.focus();
              return;
            }
          }
        }
        showStep(currentIndex + 1);
      } else if (role === 'back') {
        showStep(currentIndex - 1);
      }
    });

    // Initialize
    showStep(currentIndex);
  }



      document.addEventListener("DOMContentLoaded", () => {
    initCounters();
    initParallax();
    initSmoothScroll();
    initProjectHover();
    initScrollAnimations();
    initHeroSlideshow();
    initBuildWizard();    // keep this
  });


})();
