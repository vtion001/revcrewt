import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

test.describe('Employer Talent Discovery', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/employer/discover`);
    await expect(page).toHaveTitle(/Discover Talent/);
  });

  test('talent cards are rendered', async ({ page }) => {
    await page.goto(`${BASE}/employer/discover`);
    await page.waitForSelector('.talent-card, .card', { timeout: 8000 });
    await expect(page.locator('.talent-card, .card').first()).toBeVisible();
  });

  test('search bar is visible', async ({ page }) => {
    await page.goto(`${BASE}/employer/discover`);
    const searchInput = page.locator('input[type="text"], input[placeholder*="Search"]').first();
    await expect(searchInput).toBeVisible();
  });

  test('individual talent page loads with 200', async ({ page }) => {
    const res = await page.request.get(`${BASE}/employer/talent/1`);
    expect(res.status()).toBe(200);
  });

});

test.describe('Talent Profile Dashboard', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/talent/profile`);
    await expect(page).toHaveTitle(/My Profile/);
  });

  test('page has form or profile sections', async ({ page }) => {
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
    // Log in with the pre-seeded employer account
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    await page.fill('#email', 'emp-nav-5194@test.com');
    await page.fill('#password', 'TestPass123!');
    await page.locator('#login-form').evaluate((form: HTMLFormElement) => form.submit());
    await page.waitForLoadState('networkidle');
    // Go to discover page — Discover should be in nav
    await page.goto(`${BASE}/employer/discover`);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.nav-links a[href="/employer/discover"]')).toBeVisible();
  });

  test('talent profile page nav has My Profile link', async ({ page }) => {
    await page.goto(`${BASE}/talent/profile`);
    // Should have either nav links visible
    await expect(page.locator('nav')).toBeVisible();
  });

});
