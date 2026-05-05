import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

test.describe('Homepage', () => {

  test('loads without errors', async ({ page }) => {
    const errors: string[] = [];
    page.on('console', msg => {
      if (msg.type() === 'error') errors.push(msg.text());
    });
    await page.goto(`${BASE}/`);
    await expect(page).toHaveTitle(/revcrewt/);
    expect(errors.filter(e => !e.includes('favicon'))).toHaveLength(0);
  });

  test('navbar links navigate correctly', async ({ page }) => {
    await page.goto(`${BASE}/`);

    await page.locator('.nav-links a[href="/how-it-works"]').click();
    await expect(page).toHaveURL(/\/how-it-works/);
    await expect(page).toHaveTitle(/How It Works/);

    await page.locator('.nav-links a[href="/for-employers"]').click();
    await expect(page).toHaveURL(/\/for-employers/);
    await expect(page).toHaveTitle(/For Employers/);

    await page.locator('.nav-links a[href="/for-talent"]').click();
    await expect(page).toHaveURL(/\/for-talent/);
    await expect(page).toHaveTitle(/For Talent/);

    await page.locator('.nav-links a[href="/pricing"]').click();
    await expect(page).toHaveURL(/\/pricing/);
    await expect(page).toHaveTitle(/Pricing/);

    await page.locator('.nav-logo').click();
    await expect(page).toHaveURL(`${BASE}/`);
  });

  test('hero section is visible', async ({ page }) => {
    await page.goto(`${BASE}/`);
    await expect(page.locator('.hero h1, h1.headline-xl')).toContainText('Stop Applying');
    await expect(page.locator('.hero-ctas')).toBeVisible();
    await expect(page.locator('.nav-links a[href="/how-it-works"]').first()).toBeVisible();
  });

  test('waitlist form submits successfully', async ({ page }) => {
    await page.goto(`${BASE}/#waitlist`);
    await page.fill('#wl-name', 'Test User');
    await page.fill('#wl-email', `test-${Date.now()}@example.com`);
    await page.selectOption('#wl-role', 'jobseeker');
    await page.click('.wl-submit');
    await expect(page.locator('#wl-success')).toBeVisible({ timeout: 5000 });
  });

  test('waitlist form handles duplicate email', async ({ page }) => {
    await page.goto(`${BASE}/#waitlist`);
    page.on('dialog', async dialog => {
      expect(dialog.message()).toMatch(/already|list/i);
      await dialog.dismiss();
    });
    await page.fill('#wl-name', 'Vincent Rodriguez');
    await page.fill('#wl-email', 'vjrodriguez1994@gmail.com');
    await page.selectOption('#wl-role', 'jobseeker');
    await page.click('.wl-submit');
  });

  test('all sections render without missing content', async ({ page }) => {
    await page.goto(`${BASE}/`);
    await expect(page.locator('.hero')).toBeVisible();
    await expect(page.locator('.logos-bar')).toBeVisible();
    await expect(page.locator('#how-it-works')).toBeVisible();
    await expect(page.locator('#for-employers')).toBeVisible();
    await expect(page.locator('#for-talent')).toBeVisible();
    await expect(page.locator('#pricing')).toBeVisible();
    await expect(page.locator('#waitlist')).toBeVisible();
    await expect(page.locator('footer')).toBeVisible();
  });

});
