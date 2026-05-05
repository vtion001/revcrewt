<?php if (session()->getFlashdata('success')): ?>
  <div style="background:#d1fae5;color:#065f46;padding:0.75rem 1rem;border-radius:10px;margin-bottom:1rem;font-size:0.9rem">
    <?= esc(session()->getFlashdata('success')) ?>
  </div>
<?php endif ?>
<?php if (session()->getFlashdata('error')): ?>
  <div style="background:#fee2e2;color:#991b1b;padding:0.75rem 1rem;border-radius:10px;margin-bottom:1rem;font-size:0.9rem">
    <?= esc(session()->getFlashdata('error')) ?>
  </div>
<?php endif ?>
