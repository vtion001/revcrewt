// ── Navbar scroll ──────────────────────────────────────────────
window.addEventListener('scroll', () => {
  var navbar = document.getElementById('navbar');
  if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// ── Scroll reveal ───────────────────────────────────────────────
(function() {
  var reveals = document.querySelectorAll('.reveal');
  if (!reveals.length) return;
  var obs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(function(el) { obs.observe(el); });
})();

// ── Pricing toggle ─────────────────────────────────────────────
(function() {
  var btnM = document.getElementById('btn-m');
  var btnA = document.getElementById('btn-a');
  var proPrice = document.getElementById('pro-price');
  var proSub = document.getElementById('pro-sub');
  if (!btnM || !btnA) return;
  btnM.addEventListener('click', function() {
    btnM.classList.add('active');
    btnA.classList.remove('active');
    if (proPrice) proPrice.innerHTML = '\u20b11,499<small>/mo</small>';
    if (proSub) proSub.style.display = 'block';
  });
  btnA.addEventListener('click', function() {
    btnA.classList.add('active');
    btnM.classList.remove('active');
    if (proPrice) proPrice.innerHTML = '\u20b11,199<small>/mo</small>';
    if (proSub) proSub.style.display = 'none';
  });
})();

// ── Waitlist form ───────────────────────────────────────────────
(function() {
  var form = document.querySelector('.wl-form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    var name = document.getElementById('wl-name') ? document.getElementById('wl-name').value : '';
    var email = document.getElementById('wl-email') ? document.getElementById('wl-email').value : '';
    var role = document.getElementById('wl-role') ? document.getElementById('wl-role').value : '';
    var submitBtn = form.querySelector('button[type=submit]') || form.querySelector('input[type=submit]');
    if (submitBtn) submitBtn.disabled = true;
    fetch('/api/waitlist', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ name: name, email: email, role: role })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
      if (data.success || data.message) {
        form.style.display = 'none';
        var success = document.getElementById('wl-success');
        if (success) {
          success.style.display = 'block';
          success.textContent = (data.message || 'You\'re on the list!') + ' We will be in touch soon.';
        }
      } else {
        alert(data.message || 'Something went wrong. Please try again.');
        if (submitBtn) submitBtn.disabled = false;
      }
    })
    .catch(function(err) {
      alert('Network error. Please try again.');
      if (submitBtn) submitBtn.disabled = false;
    });
  });
})();

// ── Accordion toggle ──────────────────────────────────────────
function toggleAcc(btn) {
  var item = btn.closest('.accordion-item');
  var isOpen = item.classList.contains('open');
  // Close all
  document.querySelectorAll('.accordion-item.open').forEach(function(el) {
    el.classList.remove('open');
  });
  // Toggle current
  if (!isOpen) {
    item.classList.add('open');
  }
}
