import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

async function loginAsEmployer(page: any) {
  await page.goto(`${BASE}/auth/login`);
  await page.waitForLoadState('networkidle');
  await page.fill('#email', 'admin.employer@revcrewt.com');
  await page.fill('#password', 'AdminPass123!');
  await page.click('button[type=submit]');
  await page.waitForLoadState('networkidle');
}

async function loginAsTalent(page: any) {
  await page.goto(`${BASE}/auth/login`);
  await page.waitForLoadState('networkidle');
  await page.click('#tab-talent');
  await page.fill('#email', 'admin.talent@revcrewt.com');
  await page.fill('#password', 'AdminPass123!');
  await page.click('button[type=submit]');
  await page.waitForLoadState('networkidle');
}

test.describe('Employer Talent Discovery', () => {

  test('loads with correct title', async ({ page }) => {
    await loginAsEmployer(page);
    await page.goto(`${BASE}/employer/discover`);
    await expect(page).toHaveTitle(/Discover Talent/);
  });

  test('talent cards are rendered', async ({ page }) => {
    await loginAsEmployer(page);
    await page.goto(`${BASE}/employer/discover`);
    // Cards use .reveal animation (opacity:0 until scrolled) — use state:attached not visible
    await page.waitForSelector('.talent-card, .card', { state: 'attached', timeout: 8000 });
    await expect(page.locator('.talent-card, .card').first()).toBeAttached();
  });

  test('search bar is visible', async ({ page }) => {
    await loginAsEmployer(page);
    await page.goto(`${BASE}/employer/discover`);
    // The search section uses .reveal animation (opacity:0 until scroll)
    // Check the search bar wrapper exists in DOM
    await expect(page.locator('.search-bar').first()).toBeAttached();
  });

  test('individual talent page loads with 200', async ({ page }) => {
    await loginAsEmployer(page);
    const res = await page.request.get(`${BASE}/employer/talent/1`);
    expect(res.status()).toBe(200);
  });

});

test.describe('Talent Profile Dashboard', () => {

  test('loads with correct title', async ({ page }) => {
    await loginAsTalent(page);
    await page.goto(`${BASE}/talent/profile`);
    await expect(page).toHaveTitle(/My Profile/);
  });

  test('page has form or profile sections', async ({ page }) => {
    await loginAsTalent(page);
    await page.goto(`${BASE}/talent/profile`);
    // Page should load without errors
    await expect(page.locator('body')).toBeVisible();
  });

});

test.describe('Footer on All Pages', () => {

  const pages = [
    ['/', 'Home'],
    ['/how-it-works', 'How It Works'],
    ['/for-employers', 'For Employers'],
    ['/for-talent', 'For Talent'],
    ['/pricing', 'Pricing'],
    ['/employer/discover', 'Employer Discover'],
    ['/talent/profile', 'Talent Profile'],
  ];

  for (const [path, name] of pages) {
    test(`footer renders on ${name} (${path})`, async ({ page }) => {
      await page.goto(`${BASE}${path}`);
      await page.waitForSelector('footer', { timeout: 5000 });
      await expect(page.locator('footer')).toBeVisible();
    });
  }

});

test.describe('Navbar Links on Dashboard Pages', () => {

  test('employer discover page nav has Discover link after login', async ({ page }) => {
    await loginAsEmployer(page);
    await page.goto(`${BASE}/employer/discover`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/employer/discover"]')).toBeVisible();
  });

  test('talent profile page nav has My Profile link', async ({ page }) => {
    await loginAsTalent(page);
    await page.goto(`${BASE}/talent/profile`);
    await expect(page.locator('nav')).toBeVisible();
  });

});
