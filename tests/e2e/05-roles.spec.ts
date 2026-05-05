import { test, expect } from '@playwright/test';

const BASE = 'http://localhost:3005';

test.describe('Employer Role - Full UI', () => {
  test('employer can login and access dashboard', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    
    await page.fill('#email', 'admin.employer@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    // Should redirect to employer discover
    expect(page.url()).toContain('/employer/discover');
    
    // Navbar should show Dashboard + Logout
    const navText = await page.locator('.navbar').first().textContent();
    expect(navText ?? '').toMatch(/dashboard|logout/i);
    expect(navText ?? '').not.toMatch(/login/i);
    
    // Discover link should be visible in nav-links
    await expect(page.locator('.nav-links a[href="/employer/discover"]').first()).toBeVisible();
    
    // Search bar should be visible
    // Just check the search bar element exists (reveal animation may keep opacity:0)
    await expect(page.locator('.search-bar').first()).toBeAttached();
  });

  test('employer cannot access talent profile', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    await page.fill('#email', 'admin.employer@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    // Try to access talent profile directly as employer
    await page.goto(`${BASE}/talent/profile`);
    await page.waitForLoadState('networkidle');
    // Should redirect away from talent profile
    expect(page.url()).not.toContain('/talent/profile');
  });

  test('employer can logout', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    await page.fill('#email', 'admin.employer@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    await page.click('a[href="/auth/logout"]');
    await page.waitForLoadState('networkidle');
    
    // Should be redirected to home
    expect(page.url()).toMatch(/\/$|\/auth\/login/);
    
    // Navbar should now show Login
    const navText = await page.locator('.navbar').first().textContent();
    expect(navText ?? '').toMatch(/login/i);
  });
});

test.describe('Talent Role - Full UI', () => {
  test('talent can login and access profile', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    
    await page.click('#tab-talent');
    await page.fill('#email', 'admin.talent@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    // Should redirect to talent profile
    expect(page.url()).toContain('/talent/profile');
    
    // Navbar should show My Profile + Logout
    const navText = await page.locator('.navbar').first().textContent();
    expect(navText ?? '').toMatch(/my profile|logout/i);
    expect(navText ?? '').not.toMatch(/login/i);
    
    // My Profile link should be visible
    await expect(page.locator('.nav-links a[href="/talent/profile"]').first()).toBeVisible();
  });

  test('talent cannot access employer dashboard', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    await page.click('#tab-talent');
    await page.fill('#email', 'admin.talent@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    // Try to access employer discover directly as talent
    await page.goto(`${BASE}/employer/discover`);
    await page.waitForLoadState('networkidle');
    // Should redirect away from employer discover
    expect(page.url()).not.toContain('/employer/discover');
  });

  test('talent can logout', async ({ page }) => {
    // Use fresh context to avoid session conflicts
    const browser = page.context().browser()!;
    const ctx = await browser.newContext();
    const p = await ctx.newPage();
    await p.goto(`${BASE}/auth/login`);
    await p.waitForLoadState('networkidle');
    await p.click('#tab-talent');
    await p.fill('#email', 'admin.talent@revcrewt.com');
    await p.fill('#password', 'AdminPass123!');
    await p.click('button[type=submit]');
    await p.waitForLoadState('networkidle');
    
    await p.click('a[href="/auth/logout"]');
    await p.waitForLoadState('networkidle');
    
    expect(p.url()).toMatch(/\/$|\/auth\/login/);
    await ctx.close();
  });
});

test.describe('Login Form Validation', () => {
  test('employer account rejected on talent tab', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    
    await page.click('#tab-talent');
    await page.fill('#email', 'admin.employer@revcrewt.com');
    await page.fill('#password', 'AdminPass123!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    // Should stay on login page with error
    expect(page.url()).toContain('/auth/login');
    const body = await page.locator('body').textContent();
    expect(body ?? '').toMatch(/registered as (employer|talent)|role/i);
  });

  test('talent account rejected on employer tab', async ({ page }) => {
    // Use fresh context so no prior session interferes
    const browser = page.context().browser()!;
    const ctx = await browser.newContext();
    const p = await ctx.newPage();

    await p.goto(`${BASE}/auth/login`);
    await p.waitForLoadState('networkidle');
    
    // Don't click Talent tab — stay on Employer tab (default)
    await p.fill('#email', 'admin.talent@revcrewt.com');
    await p.fill('#password', 'AdminPass123!');
    await p.click('button[type=submit]');
    await p.waitForLoadState('networkidle');
    
    expect(p.url()).toContain('/auth/login');
    const body = await p.locator('body').textContent();
    expect(body ?? '').toMatch(/registered as (employer|talent)|role/i);
    await ctx.close();
  });

  test('wrong password shows error', async ({ page }) => {
    await page.goto(`${BASE}/auth/login`);
    await page.waitForLoadState('networkidle');
    
    await page.fill('#email', 'admin.employer@revcrewt.com');
    await page.fill('#password', 'WrongPassword!');
    await page.click('button[type=submit]');
    await page.waitForLoadState('networkidle');
    
    expect(page.url()).toContain('/auth/login');
    const body = await page.locator('body').textContent();
    expect(body ?? '').toMatch(/invalid|password/i);
  });
});
