# revcrewt — Reverse Recruiting Platform
## Implementation Guidelines v1.0

**Based on:** Strategic Concept Deck + Visual Identity documents
**Stack:** CodeIgniter 4 (PHP 8+) • MySQL • Playwright

---

## 1. Concept & Vision

**What it is:** A hiring platform where employers initiate and compete for talent — talent decides which opportunities to engage.

**Core problem solved:**
- Talents: No more repeated applications across platforms — one profile, opportunities come to you
- Employers: No more filtering unqualified applicants — directly identify, track, and engage structured talent

**Tagline:** "Discover better. Match Smarter."
**Crew slogan:** "Your reverse-recruiting crew."

---

## 2. Brand Identity

### Logo Variations
- `rev` — minimal text mark
- `revcrewt` — full wordmark
- `crewt` — split color emphasis (experimental)

### Color Palette
| Name | Hex | Usage |
|---|---|---|
| Black | `#000000` | Primary text |
| Dark Blue | `#1e3a5f` | Headers, nav |
| Cobalt Blue | `#004aad` | Primary buttons, links |
| Bright Red | `#ff3131` | Alerts, accent |
| Grass Green | `#7ed957` | Success states |
| Salmon | `#ff751f` | Warnings, highlights |

### Gradients
| Direction | Colors |
|---|---|
| Linear 180° | `#7b2d9f` → `#fdd82e` (purple-gold) |
| Linear 90° | `#8c52ff` → `#00bf63` (violet-green) |
| Linear 90° | `#ff66c4` → `#ffde59` (pink-yellow) |

### Typography
**Font Family:** Poppins
- Regular (400) — body text
- Light (300) — captions, subtitles
- SemiBold (600) — subheadings
- Bold (700) — headings
- ExtraBold (800) — hero text

---

## 3. User Roles & Flows

### Role: TALENT
**Profile Structure:**
```
CORE PROFILE
├── AI-assisted resume (structured + optimized)
├── Introduction video (communication & personality)
├── Discovery profile
│   ├── Skills
│   ├── Experience
│   ├── Work style
│   └── Preferences
└── Status & Availability
    ├── Open to work
    ├── Exploring
    └── Currently employed but receptive
```

**Engagement Model:**
- Receive inbound requests from employers:
  - Free interview requests
  - Paid interview requests
  - Paid assessments (pre-screening tasks)
- Evaluate opportunities by:
  - Relevance
  - Alignment
  - Value (compensation for time)
  - Assessment results

**Talent Tiers:**
| Feature | Free | Premium ($1/mo) |
|---|---|---|
| Create & maintain full profile | ✅ | ✅ |
| AI profile optimization | ❌ | ✅ |
| Receive employer requests | ✅ | ✅ |
| Verified/trusted badge | ❌ | ✅ |
| Profile visibility boost | ❌ | ✅ |
| Analytics (profile views, demand insights) | ❌ | ✅ |
| Priority opportunity access | ❌ | ✅ |

---

### Role: EMPLOYER
**Profile Structure:**
```
EMPLOYER PROFILE
├── Organization name & branding
├── Work environment & expectations
├── Engagement preferences
│   ├── Free interactions
│   └── Paid interactions
├── Hiring intent & priorities
└── Payment tier (signal of seriousness)
```

**Engagement Model:**
- Browse structured talent profiles
- Filter by skills, preferences, assessments
- Track candidates over time
- Initiate interaction via:
  - Free interview requests
  - Paid interview requests (priority signal)
  - Paid assessments

**Employer Tiers:**
| Feature | Free | Premium ($10/mo) |
|---|---|---|
| Limited profile views | 10/mo | Unlimited |
| Limited outreach | 5/mo | Unlimited |
| Basic browsing & engagement | ✅ | ✅ |
| Advanced filtering & tracking | ❌ | ✅ |
| Paid interaction capabilities | ✅ | ✅ |
| Featured employer status | ❌ | ✅ |
| Priority engagement options | ❌ | ✅ |

---

## 4. Revenue Model

### Current
- **Talent premium:** $1/month
- **Employer premium:** $10/month
- **Service fee:** 2–5% on paid interactions (interviews, assessments)

### Future (Phase 3+)
- Featured placements
- Advanced analytics
- Managed hiring service

---

## 5. Platform Phases

### Phase 1 — Build the Talent Base (Days 1–40)
- Create social media channels
- Daily content posting
- Invite talents to pre-register (target: 100–300 users)
- Build platform: profile system + basic onboarding
- Soft launch to talents, test UX, gather feedback

### Phase 2 — Activate Employers (Days 41–60)
- Invite employers to explore available talent
- Limited free access to encourage adoption
- Enable free + paid interactions
- Test request flows
- Observe behavior, refine matching

### Phase 3 — Revenue & Optimize (Days 61–90+)
- Introduce premium features (both sides)
- Activate service fee on paid interactions
- Gather feedback, refine pricing
- Improve matching algorithm + UX
- Monitor engagement patterns

---

## 6. Database Schema (Key Tables)

```sql
-- Users (both talent and employer)
users (
  id, email, password_hash, role ('talent'|'employer'),
  status, created_at, updated_at
)

-- Talent Profiles
talent_profiles (
  id, user_id, headline, summary,
  video_url, profile_photo,
  skills JSON, experience JSON,
  work_style, preferences JSON,
  availability_status, is_premium,
  verified_badge, created_at
)

-- Employer Profiles
employer_profiles (
  id, user_id, org_name, org_logo,
  work_environment, expectations,
  engagement_prefs JSON,
  hiring_priorities, is_premium,
  featured_status, created_at
)

-- Interaction Requests
interaction_requests (
  id, employer_id, talent_id,
  type ('free_interview'|'paid_interview'|'paid_assessment'),
  status ('pending'|'accepted'|'declined'|'completed'),
  amount_paid, service_fee,
  created_at, responded_at
)

-- Assessments
assessments (
  id, request_id, talent_id, employer_id,
  task_description, submitted_answer,
  score, created_at
)

-- Transactions (for revenue tracking)
transactions (
  id, user_id, type, amount,
  service_fee, net_amount,
  created_at
)

-- Premium Subscriptions
subscriptions (
  id, user_id, plan ('talent_premium'|'employer_premium'),
  status, started_at, expires_at
)
```

---

## 7. Page Structure

### Public Pages
- `/` — Landing page (hero, value props, how it works)
- `/about` — About the concept
- `/register` — Role selection (Talent / Employer)
- `/login` — Auth page
- `/pricing` — Free vs Premium comparison

### Talent Dashboard
- `/talent/profile` — Build & edit profile
- `/talent/discover` — View matching employers
- `/talent/requests` — Incoming employer requests
- `/talent/analytics` — Profile views, demand insights (Premium)

### Employer Dashboard
- `/employer/discover` — Browse & filter talent pool
- `/employer/requests` — Sent requests & responses
- `/employer/tracked` — Saved/tracked candidates
- `/employer/analytics` — Engagement metrics (Premium)

### Shared
- `/settings` — Account settings
- `/notifications` — All notifications

---

## 8. Tech Stack Details

### Backend
- **Framework:** CodeIgniter 4.x
- **PHP Version:** 8.0+
- **Database:** MySQL 8.0
- **Auth:** CodeIgniter shield (or custom with JWT)
- **File Storage:** Local (`public/uploads/`) or S3

### Frontend
- **Design System:** Custom (Poppins font, brand colors)
- **CSS Framework:** Bootstrap 5 or Tailwind
- **JS:** Vanilla JS or Alpine.js
- **Video:** Embedded (YouTube/Vimeo) or direct upload

### Testing
- **E2E:** Playwright
- **Unit:** PHPUnit (built into CI4)
- **CI:** Run Playwright after every significant change

### Cron Jobs
- Daily build/deploy (see `docs/CRON_SETUP.md`)
- Monthly subscription renewal checks
- Analytics aggregation (nightly)

---

## 9. Implementation Priority

### Week 1 — Foundation
- [ ] CI4 project setup with brand theme
- [ ] Database schema + migrations
- [ ] Auth system (register/login for both roles)
- [ ] Landing page with brand design applied

### Week 2 — Core Talent Flow
- [ ] Talent profile builder (multi-step form)
- [ ] Profile viewing + AI resume assist mockup
- [ ] Availability status toggle

### Week 3 — Core Employer Flow
- [ ] Employer profile setup
- [ ] Talent discovery + filter system
- [ ] Candidate tracking

### Week 4 — Engagement + Requests
- [ ] Request system (free/paid interview, assessment)
- [ ] Notification system (email + in-app)
- [ ] Playwright tests for core flows

### Week 5-6 — Premium + Refinement
- [ ] Premium upgrade flow
- [ ] Service fee calculation
- [ ] Dashboard analytics

### Phase 2-3 — Scale
- [ ] Matching algorithm
- [ ] Social media integration
- [ ] Payment gateway (Stripe/PayPal)

---

## 10. Key Principles

1. **Single profile, infinite opportunities** — Never ask talent to re-enter info
2. **Employer seriousness signal** — Payment = quality signal
3. **Value alignment first** — Match on values, skills, culture fit before compensation
4. **Free-first experience** — Core experience never compromised by premium
5. **Progressive profiling** — Profile deepens over time, not a form to fill once
