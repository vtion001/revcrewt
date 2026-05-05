import { test, expect } from '@playwright/test';

const BASE = process.env.BASE_URL || 'http://localhost:3005';

test.describe('Auth Flow', () => {

  test('login page loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await expect(page).toHaveTitle(/Login/);
    await expect(page.locator('h1, .headline-xl')).toContainText(/Login|welcome|sign/i);
  });

  test('register page loads with correct title', async ({ page }) => {
    await page.goto(`${BASE}/auth/register`);
    await expect(page).toHaveTitle(/Register/);
  });

  test('login form shows error on empty fields', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    // Bypass HTML5 required validation to test server-side validation
    await page.evaluate(() => {
      const form = document.querySelector('form') as HTMLFormElement;
      if (form) { form.noValidate = true; form.submit(); }
    });
    await page.waitForLoadState('networkidle');
    await expect(page.locator('body')).toContainText(/required|error|required/i, { ignoreCase: true });
  });

  test('register form shows error on password mismatch', async ({ page }) => {
    await page.goto(`${BASE}/auth/register`);
    // Switch to talent tab and fill talent form
    await page.click('#tab-talent');
    await page.waitForLoadState('networkidle');
    await page.fill('#tal-name', 'Test User');
    await page.fill('#tal-email', 'authtest2@example.com');
    await page.fill('#tal-password', 'testpass123');
    await page.fill('#tal-confirm', 'wrongpass');
    await page.fill('#tal-headline', 'Software Engineer');
    // Bypass HTML5 required validation
    await page.evaluate(() => {
      const form = document.querySelector('#register-form') as HTMLFormElement;
      if (form) { form.noValidate = true; form.submit(); }
    });
    await page.waitForLoadState('networkidle');
    await expect(page.locator('body')).toContainText(/match|mismatch|do not match|passwords/i, { ignoreCase: true });
  });

  test('login page has register link', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await expect(page.locator('a[href="/auth/register"]')).toBeVisible();
  });

  test('register page has login link', async ({ page }) => {
    await page.goto(`${BASE}/auth/register`);
    await expect(page.locator('a[href="/auth/login"]')).toBeVisible();
  });

  test('logout redirects to home', async ({ page }) => {
    await page.goto(`${BASE}/auth/logout`);
    await expect(page).toHaveURL(/\/$/);
  });

  test('unauthenticated user cannot access /api/offers/incoming', async ({ page }) => {
    const response = await page.goto(`${BASE}/api/offers/incoming`);
    expect(response?.status()).toBe(401);
  });

  test('unauthenticated user cannot access /api/offers/sent', async ({ page }) => {
    const response = await page.goto(`${BASE}/api/offers/sent`);
    expect(response?.status()).toBe(401);
  });

  test('unauthenticated user cannot access /api/notifications', async ({ page }) => {
    const response = await page.goto(`${BASE}/api/notifications`);
    expect(response?.status()).toBe(401);
  });
});
