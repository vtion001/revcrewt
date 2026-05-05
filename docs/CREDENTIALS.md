# revcrewt — Admin Credentials

> **All accounts share the same password.** Update this file immediately if shared.

---

## Test / Admin Accounts

| Role     | Email                        | Password      | Notes                                         |
|----------|------------------------------|---------------|-----------------------------------------------|
| Employer | admin.employer@revcrewt.com  | AdminPass123! | Admin employer account, full dashboard access  |
| Talent   | admin.talent@revcrewt.com    | AdminPass123! | Admin talent account, full profile access     |

---

## How to Use

1. Go to `http://localhost:3005/auth/login`
2. Enter email and password from the table above
3. Select the correct role tab (Employer / Talent) before logging in

---

## Seeding New Accounts

If you need to create more accounts directly in the database:

```bash
# Generate a bcrypt hash (requires PHP)
php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_BCRYPT) . PHP_EOL;"

# Then insert via Python:
python3 << 'PYEOF'
import sqlite3
conn = sqlite3.connect('database/revcrewt.db')
cur = conn.cursor()
ts = '2026-05-06 05:35:00'
cur.execute("""
  INSERT INTO users (email, password_hash, name, role, status, created_at, updated_at)
  VALUES (?, ?, ?, ?, ?, ?, ?)
""", ('your@email.com', 'YOUR_HASH_HERE', 'Display Name', 'employer', 'active', ts, ts))
user_id = cur.lastrowid
# Create employer profile
cur.execute("""
  INSERT INTO employer_profiles (user_id, org_name, created_at, updated_at)
  VALUES (?, ?, ?, ?)
""", (user_id, 'Company Name', ts, ts))
conn.commit()
conn.close()
PYEOF
```

---

## Database

- **Path:** `database/revcrewt.db` (SQLite)
- **Tables:** `users`, `employer_profiles`, `talent_profiles`, `waitlist`, `tracked_talents`, `interaction_requests`, `notifications`, `migrations`

---

_Last updated: May 6, 2026 — Yuri_
