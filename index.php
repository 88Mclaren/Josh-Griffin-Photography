<?php require_once __DIR__ . '/config.php'; $pageTitle='Home'; require __DIR__.'/includes/header.php'; ?>
<section class="hero">
  <div class="hero-copy">
    <p class="eyebrow">JOSH GRIFFIN PHOTOGRAPHY</p>
    <h1>Honest moments.<br><em>Beautifully captured.</em></h1>
    <p>Event and portrait photography focused on real connections, meaningful details, and the moments worth remembering.</p>
    <a class="button" href="<?= e(url('contact.php')) ?>">Get in touch</a>
  </div>
  <div class="hero-image" role="img" aria-label="Featured photography image"></div>
</section>
<section class="section intro">
  <p class="eyebrow">THE PHOTOGRAPHY</p><h2>Images that feel like you.</h2>
  <p class="narrow">From the energy of an event to the personality in a portrait, my goal is to create photographs that feel natural, thoughtful, and timeless.</p>
</section>
<section class="section">
  <div class="section-heading"><div><p class="eyebrow">PORTFOLIO</p><h2>Explore my work</h2></div></div>
  <div class="portfolio-grid">
    <a class="portfolio-card" href="<?= e(url('events.php')) ?>"><div class="image-placeholder event-image"></div><h3>Events</h3><p>Meaningful moments and the atmosphere of the day.</p></a>
    <a class="portfolio-card" href="<?= e(url('portraits.php')) ?>"><div class="image-placeholder portrait-image"></div><h3>Portraits</h3><p>Personal, expressive portraits that tell your story.</p></a>
  </div>
</section>
<section class="about-strip"><div><p class="eyebrow">A LITTLE ABOUT ME</p><h2>Photography with intention.</h2><p>I believe the best photographs come from genuine moments and a comfortable experience.</p><a class="text-link" href="<?= e(url('about.php')) ?>">Learn more about me →</a></div><div class="about-placeholder"></div></section>
<section class="cta"><p class="eyebrow">LET'S CREATE SOMETHING</p><h2>Have a date or an idea in mind?</h2><a class="button button-light" href="<?= e(url('contact.php')) ?>">Contact me</a></section>
<?php require __DIR__.'/includes/footer.php'; ?>
