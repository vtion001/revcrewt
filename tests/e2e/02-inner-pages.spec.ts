import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

test.describe('How It Works Page', () => {

  test('loads with correct title and content', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveTitle(/How It Works/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('accordion FAQ opens and closes', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await page.locator('.accordion-header').first().scrollIntoViewIfNeeded();
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-item.open').first()).toBeVisible({ timeout: 5000 });
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-item.open').first()).toHaveCount(0);
  });

  test('How It Works nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/how-it-works"]')).toHaveClass(/active/);
  });

  test('For Employers card links correctly', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await page.locator('a[href="/for-employers"]').first().click();
    await expect(page).toHaveURL(/\/for-employers/);
  });

  test('For Talent card links correctly', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await page.locator('a[href="/for-talent"]').first().click();
    await expect(page).toHaveURL(/\/for-talent/);
  });

  test('page hero is below fixed navbar', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    const heroTop = await page.locator('.page-hero').evaluate(el => el.getBoundingClientRect().top);
    expect(heroTop).toBeGreaterThan(70);
  });

  test('CTA footer Join Waitlist scrolls to form', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await page.locator('a[href="/#waitlist"]').last().click();
    await page.waitForTimeout(800);
    // The waitlist section should be visible after scrolling
    await expect(page.locator('#waitlist')).toBeVisible();
  });

});

test.describe('For Employers Page', () => {

  test('loads with correct title and hero', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveTitle(/For Employers/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('stat bar is visible with values', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.stat-bar')).toBeVisible();
    await expect(page.locator('.stat-value').first()).toBeVisible();
    await expect(page.locator('.stat-label').first()).toBeVisible();
  });

  test('feature cards are rendered', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.card').first()).toBeVisible();
    expect(await page.locator('.card').count()).toBeGreaterThan(1);
  });

  test('For Employers nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/for-employers"]')).toHaveClass(/active/);
  });

  test('check list items render correctly', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    const checkItems = page.locator('.check-item');
    expect(await checkItems.count()).toBeGreaterThan(0);
    await expect(checkItems.first()).toBeVisible();
  });

  test('CTA button links to waitlist section', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForLoadState('networkidle');
    await page.locator('a[href="/#waitlist"]').first().click();
    await page.waitForTimeout(800);
    await expect(page.locator('#waitlist')).toBeVisible();
  });

});

test.describe('For Talent Page', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveTitle(/For Talent/);
  });

  test('stat bar is visible', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.stat-bar')).toBeVisible();
  });

  test('For Talent nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/for-talent"]')).toHaveClass(/active/);
  });

  test('section images are visible', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await page.waitForLoadState('networkidle');
    const images = page.locator('.section-image img');
    expect(await images.count()).toBeGreaterThan(0);
  });

  test('cards are rendered', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.card').first()).toBeVisible();
    expect(await page.locator('.card').count()).toBeGreaterThan(0);
  });

});

test.describe('Pricing Page', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    await expect(page).toHaveTitle(/Pricing/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('three pricing plans are displayed', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    await page.waitForSelector('.grid-3 > div', { timeout: 5000 });
    const plans = page.locator('.grid-3 > div');
    await expect(plans.nth(0)).toContainText('Starter');
    await expect(plans.nth(1)).toContainText('Pro');
    await expect(plans.nth(2)).toContainText('Enterprise');
  });

  test('pricing toggle switches monthly/annual', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    const monthlyPrice = await page.locator('#pro-price').innerText();
    expect(monthlyPrice).toContain('1,499');
    await page.locator('#btn-a').click();
    await page.waitForTimeout(300);
    const annualPrice = await page.locator('#pro-price').innerText();
    expect(annualPrice).toContain('1,199');
    await page.locator('#btn-m').click();
    await page.waitForTimeout(300);
    const backPrice = await page.locator('#pro-price').innerText();
    expect(backPrice).toContain('1,499');
  });

  test('accordion FAQ opens and closes', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    await page.locator('.accordion-header').first().scrollIntoViewIfNeeded();
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-item.open').first()).toBeVisible({ timeout: 5000 });
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-item.open').first()).toHaveCount(0);
  });

  test('Pricing nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/pricing"]')).toHaveClass(/active/);
  });

  test('all plan cards have at least a CTA element', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForLoadState('networkidle');
    const planCards = page.locator('.grid-3 > div');
    const count = await planCards.count();
    expect(count).toBe(3);
    for (let i = 0; i < count; i++) {
      const linksOrButtons = await planCards.nth(i).locator('a, button').count();
      expect(linksOrButtons).toBeGreaterThanOrEqual(1);
    }
  });

});

test.describe('Navbar Consistency', () => {

  test('all inner pages show same core nav-links items for anonymous users', async ({ page }) => {
    // Use a fresh context to ensure no session from other tests
    const freshPage = await page.context().newPage();
    await freshPage.goto(`${BASE}/how-it-works`);
    await freshPage.waitForLoadState('networkidle');
    const navLinks = await freshPage.locator('.nav-links a').allInnerTexts();
    expect(navLinks).toContain('How It Works');
    expect(navLinks).toContain('For Employers');
    expect(navLinks).toContain('For Talent');
    expect(navLinks).toContain('Pricing');
    // No Discover for anonymous users (only shown to logged-in employers)
    expect(navLinks).not.toContain('Discover');
    
  });

  test('nav-links are visible on desktop width', async ({ page }) => {
    await page.setViewportSize({ width: 1280, height: 800 });
    await page.goto(`${BASE}/how-it-works`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links')).toBeVisible();
    await expect(page.locator('.nav-links a').first()).toBeVisible();
  });

  test('logo links back to home on all pages', async ({ page }) => {
    for (const url of ['/how-it-works', '/for-employers', '/for-talent', '/pricing']) {
      await page.goto(`${BASE}${url}`);
      await page.waitForLoadState('networkidle');
      await page.locator('.nav-logo').click();
      await expect(page).toHaveURL(`${BASE}/`);
    }
  });

  test('footer renders on all inner pages', async ({ page }) => {
    for (const url of ['/how-it-works', '/for-employers', '/for-talent', '/pricing']) {
      await page.goto(`${BASE}${url}`);
      await page.waitForLoadState('networkidle');
      await expect(page.locator('footer')).toBeVisible();
      await expect(page.locator('.footer-links a').first()).toBeVisible();
    }
  });

});

test.describe('API Endpoints', () => {

  test('GET /api/talents returns 200 and JSON', async ({ page }) => {
    const res = await page.request.get(`${BASE}/api/talents`);
    expect(res.status()).toBe(200);
    const body = await res.json();
    expect(body.talents).toBeDefined();
    expect(Array.isArray(body.talents)).toBe(true);
  });

  test('GET /api/talents/1 returns a talent profile', async ({ page }) => {
    const res = await page.request.get(`${BASE}/api/talents/1`);
    expect(res.status()).toBe(200);
    const body = await res.json();
    expect(body.headline).toBeDefined();
  });

  test('GET /api/waitlist/stats returns stats', async ({ page }) => {
    const res = await page.request.get(`${BASE}/api/waitlist/stats`);
    expect(res.status()).toBe(200);
    const body = await res.json();
    expect(body.total).toBeDefined();
  });

});
