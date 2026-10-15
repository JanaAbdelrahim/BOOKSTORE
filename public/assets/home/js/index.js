if (window.AOS) {
    AOS.init({ duration: 800, once: true, offset: 80 });
}

if (window.Swiper) {
    new Swiper(".reviewsSwiper", {
        loop: true,
        grabCursor: true,
        spaceBetween: 24,
        autoplay: { delay: 4500, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
    });
}

(function () {
    let counters = document.querySelectorAll(".counter");
    if (!counters.length) return;

    let run = (e) => {
        let target = +e.dataset.target;
        let duration = 1800;
        let start = performance.now();
        let tick = (now) => {
            let p = Math.min((now - start) / duration, 1);
            let eased = 1 - Math.pow(1 - p, 3);
            e.textContent = Math.floor(target * eased).toLocaleString();
            if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    };

    let io = new IntersectionObserver((entries, obs) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                run(e.target);
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.4 });

    counters.forEach((c) => io.observe(c));
})();
