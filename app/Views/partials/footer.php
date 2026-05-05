
<!-- CTA BAR -->
<section style="background:var(--gray-50);border-top:1px solid var(--gray-100);padding:5rem 2rem">
  <div class="container" style="text-align:center">
    <h2 class="headline-lg" style="margin-bottom:0.75rem">Ready to get started?</h2>
    <p class="body-lg" style="margin-bottom:2rem;max-width:400px;margin-left:auto;margin-right:auto">Join 1,200+ professionals already on the waitlist.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="/#waitlist" class="btn btn-primary btn-lg">Join the Waitlist</a>
      <a href="/pricing" class="btn btn-outline-navy btn-lg">View Pricing</a>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">rev<span>crewt</span></div>
    <div class="footer-copy">2026 revcrewt. All rights reserved.</div>
    <div class="footer-links">
      <a href="/">Home</a>
      <a href="/how-it-works">How It Works</a>
      <a href="/for-employers">For Employers</a>
      <a href="/for-talent">For Talent</a>
      <a href="/pricing">Pricing</a>
      <a href="/#waitlist">Join Waitlist</a>
    </div>
  </div>
</footer>

<script>
  window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
  });
  const reveals = document.querySelectorAll('.reveal');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.1 });
  reveals.forEach(el => obs.observe(el));
</script>
</body>
</html>
