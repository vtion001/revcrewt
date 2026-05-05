import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

test.describe('How It Works Page', () => {

  test('loads with correct title and content', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await expect(page).toHaveTitle(/How It Works/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('accordion FAQ opens', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.locator('.accordion-item').first().scrollIntoViewIfNeeded();
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-body.open').first()).toBeVisible();
  });

  test('How It Works nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await expect(page.locator('.nav-links a[href="/how-it-works"]')).toHaveClass(/active/);
  });

  test('For Employers card links correctly', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.locator('a[href="/for-employers"]').first().click();
    await expect(page).toHaveURL(/\/for-employers/);
  });

  test('For Talent card links correctly', async ({ page }) => {
    await page.goto(`${BASE}/how-it-works`);
    await page.locator('a[href="/for-talent"]').first().click();
    await expect(page).toHaveURL(/\/for-talent/);
  });

});

test.describe('For Employers Page', () => {

  test('loads with correct title and hero', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await expect(page).toHaveTitle(/For Employers/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('stat bar is visible', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await expect(page.locator('.stat-bar')).toBeVisible();
  });

  test('feature cards are rendered', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await page.waitForSelector('.card', { timeout: 5000 });
    await expect(page.locator('.card').first()).toBeVisible();
  });

  test('For Employers nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/for-employers`);
    await expect(page.locator('.nav-links a[href="/for-employers"]')).toHaveClass(/active/);
  });

});

test.describe('For Talent Page', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await expect(page).toHaveTitle(/For Talent/);
  });

  test('stat bar is visible', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await expect(page.locator('.stat-bar')).toBeVisible();
  });

  test('For Talent nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/for-talent`);
    await expect(page.locator('.nav-links a[href="/for-talent"]')).toHaveClass(/active/);
  });

});

test.describe('Pricing Page', () => {

  test('loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await expect(page).toHaveTitle(/Pricing/);
    await expect(page.locator('.page-hero h1')).toBeVisible();
  });

  test('three pricing plans are displayed', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.waitForSelector('.grid-3 > div', { timeout: 5000 });
    const plans = page.locator('.grid-3 > div');
    await expect(plans.nth(0)).toContainText('Starter');
    await expect(plans.nth(1)).toContainText('Pro');
    await expect(plans.nth(2)).toContainText('Enterprise');
  });

  test('pricing toggle switches monthly/annual', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    // Click annual toggle
    await page.locator('#btn-a').click();
    // After clicking, the pro price should update (annual = 1199)
    await page.waitForTimeout(300);
    const priceText = await page.locator('#pro-price').innerText();
    expect(priceText).toContain('1,199');
    // Switch back to monthly
    await page.locator('#btn-m').click();
    await page.waitForTimeout(300);
    const priceText2 = await page.locator('#pro-price').innerText();
    expect(priceText2).toContain('1,499');
  });

  test('accordion FAQ opens', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await page.locator('.accordion-header').first().scrollIntoViewIfNeeded();
    await page.locator('.accordion-header').first().click();
    await expect(page.locator('.accordion-body.open').first()).toBeVisible();
  });

  test('Pricing nav link is active', async ({ page }) => {
    await page.goto(`${BASE}/pricing`);
    await expect(page.locator('.nav-links a[href="/pricing"]')).toHaveClass(/active/);
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
