# PrimeDoctors — Healthcare Directory & NPI Ingestion Platform

PrimeDoctors is a Laravel 12 + Livewire 3 application that ingests the official NPI Registry (CMS/HHS) data set and turns it into a polished, mobile‑first directory of doctors, organizations, and specialties. It ships with production-grade import commands, rich search/filters, responsive UI shells, and legal/about pages tailored for healthcare.

---

## Table of Contents
- Vision & Value Proposition
- Architecture & Tech Stack
- Data Model & Source of Truth
- Data Import Commands (Artisan)
- Public Pages & Flows (URLs)
- API/AJAX Endpoints
- Local Development & Build
- Ownership & Contact
- Hashtags

---

## Vision & Value Proposition
PrimeDoctors bridges raw NPI registry data with a consumer-grade experience:
- Automated data pulls keep providers, clinics, and specialties fresh.
- Discoverability is driven by full-text and facet filters (city/state/specialty/gender).
- Mobile-first UX: thumb-friendly filters, full-screen mobile search, accessible cards, gradients.
- Trust & compliance: privacy/terms pages, transparent ownership, and clear data provenance.

---

## Architecture & Tech Stack
- **Backend**: Laravel 12 (PHP 8.2), Eloquent ORM, route/controllers for pages + JSON endpoints.
- **Realtime/Reactive UI**: Livewire 3 components for doctor/organization directories (`app/Livewire/DoctorsDirectory.php`, `app/Livewire/OrganizationsDirectory.php`).
- **Frontend tooling**: Vite 7, Tailwind CSS 4, Alpine.js, Axios for AJAX interactions.
- **Build scripts**: `npm run dev` (Vite dev server), `npm run build` (production build), `composer setup` (one-shot project bootstrap with env, key, migrate, npm build).
- **Styling**: Tailwind utility-first design, custom gradients and cards, accessibility-friendly controls.
- **Data source**: NPI Registry API v2.1 (CMS/HHS) with enforced two-filter rule to stay compliant.
- **Database**: Laravel default (SQLite checked in for convenience) but works with MySQL/PostgreSQL.
- **Testing/quality**: PHPUnit 11, Laravel Pint (code style), Laravel Pail (logging/observability).

---

## Data Model & Source of Truth
- **Doctors** (`App\Models\Doctor`): NPI-1 providers with name, taxonomy (specialty), gender, city, state, organization_name, NPI, and relationships to Reviews.
- **Organizations** (`App\Models\Organization`): NPI-2 entities with name, city, state, phone; linked to doctors by organization_name.
- **Specialties** (`App\Models\Specialty`): taxonomy codes/descriptions harvested during doctor/org imports.
- **Reviews** (`App\Models\Review`): simple user-submitted feedback per doctor (rating, comment, name).
- Data provenance: all entities originate from the NPI Registry API via purpose-built Artisan commands (below).

---

## Data Import Commands (Artisan)
All commands live in `app/Console/Commands` and call `https://npiregistry.cms.hhs.gov/api/` with pagination and validation. The NPI API requires **at least two filters** (e.g., state + taxonomy or state + city). Each command enforces this and respects the API’s `limit` (max 200) and `skip` pagination pattern; a 1-second sleep is applied between pages to stay polite.

### `import:doctors`
- **Signature**: `php artisan import:doctors --state=CA --taxonomy="family medicine,cardiology" --city="Los Angeles" --limit=200`
- **Purpose**: Pull NPI-1 providers. Upserts Doctors and any taxonomies into Specialties.
- **Defaults**: If `--taxonomy` is omitted, uses a curated starter set (family medicine, cardiology, pediatrics, internal medicine, dermatology).
- **Filters required**: `--state` + `--taxonomy` (or `--state` + `--city`).

### `import:organizations`
- **Signature**: `php artisan import:organizations --state=CA --city="Los Angeles,San Francisco" --limit=200`
- **Purpose**: Pull NPI-2 organizations. Upserts Organizations and their taxonomies into Specialties.
- **Filters required**: both `--state` and at least one `--city` (two-filter rule).

### `import:specialties`
- **Signature**: `php artisan import:specialties --state=CA --taxonomy="family medicine,cardiology" --city="Los Angeles" --limit=50`
- **Purpose**: Lightweight pull that focuses on taxonomy harvesting. Upserts Specialties only.
- **Filters required**: same two-filter rule (state+taxonomy or state+city).

### Operational notes
- Progress bars are rendered in the console; failures are logged with HTTP status.
- Upserts prevent duplicates across runs (idempotent refreshes).
- Pagination: uses `skip` increments of `limit` until results are exhausted.

---

## Public Pages & Flows (URLs)
All main routes are defined in `routes/web.php`.

### `/` — Home
- Hero with mobile/full-screen specialty picker and desktop autocomplete search.
- Stats counters for specialties, doctors, organizations.
- Featured doctors and organizations cards with avatars, locations, tags.
- Popular specialties grid linking directly to filtered doctor searches.
- Testimonial, articles, offer, mobile-app promo, and partner sections.

### `/search`
- Unified search across doctors, organizations, specialties.
- AJAX-enabled form (`ajax-filter-form`) renders results into `#search-results`.
- Graceful empty states; preserves querystring for shareable URLs.

### `/doctors`
- Faceted directory with filters: `q` (name/taxonomy/org), `state`, `city`, `specialty`, `gender`.
- AJAX mode returns HTML partials plus pagination metadata for dynamic list updates; JSON responses also return updated city options.
- Supports quick-filter chips (e.g., Cardiology, Dermatology) and mobile-friendly form layout.
- Pagination at 20 per page; ordered by name with dynamic relevance when searching.

### `/doctors/{doctor}`
- Doctor profile: taxonomy, location, organization, gender, NPI, and “quick facts”.
- Booking and question modals (Alpine.js driven) for UX demo purposes.
- Review submission form (AJAX aware) with rating + comment; re-renders reviews list on success.
- Related doctors block (same city + specialty) for discovery.

### `/organizations`
- Directory of clinics/groups with filters: `q`, `state`, `city`, `specialty`.
- AJAX responses mirror the doctors page (HTML list, updated city options, pagination data).
- Cards display name, city/state, phone (if present), and specialty affinities inferred from linked doctors.

### `/organizations/{organization}`
- Organization profile with location/contact, specialties (from linked doctors), clinic gallery, booking/question modals, nearby clinics and doctors, and “doctors at this organization”.
- Mobile bottom action bar for quick booking on small screens.

### `/specialties`
- Paginated grid (36 per page) of taxonomy descriptions and codes; each card links into `/doctors?specialty=...`.
- Summary counters for total specialties and page count; responsive, tap-friendly layout.

### `/about`
- Owner intro (Inna Tarasyan), stack highlights, and project scope cards.
- Explains ingestion + directory focus, transparency, and solo ownership.

### `/privacy-policy` and `/terms-of-use`
- Styled legal pages with current “Last updated” date, clear sections on data use, rights, cookies, disclaimers, and governing law.

---

## API / AJAX Endpoints
- **`GET /api/search/doctors`** — Lightweight autocomplete for doctors. Returns up to 10 items with relevance ordering (prefix boosts on name/taxonomy, contains on org/city/state).
- **`GET /api/search/autocomplete`** — Unified autocomplete for doctors, organizations, specialties (tagged by type, URL included).
- **`GET /search` (JSON)** — Returns rendered HTML for search results + canonical URL.
- **`GET /doctors` (JSON)** and **`GET /organizations` (JSON)** — Return rendered list partials, refreshed city options, pagination info, and canonical URL for filters.
- **`POST /doctors/{doctor}/reviews`** — Create a review; AJAX responses return refreshed reviews HTML plus status message.

---

## Local Development & Build
1) **Install PHP deps**: `composer install`
2) **Bootstrap env**: `cp .env.example .env` then `php artisan key:generate`
3) **Database**: use bundled `database/database.sqlite` or configure MySQL/PostgreSQL; run `php artisan migrate`
4) **Front-end deps**: `npm install`
5) **Run dev stack**: `npm run dev` (Vite) and `php artisan serve`
6) **Build assets**: `npm run build`
7) **Optional one-liner**: `composer setup` (installs, seeds env, migrates, npm build)

---

## Ownership & Contact
- Built and maintained solely by **Inna Tarasyan** (Armenia). No external company involvement; full accountability for code, content, and data handling.
- Email: [innatarasyancryptotrading@gmail.com](mailto:innatarasyancryptotrading@gmail.com)

---

## Hashtags
#PrimeDoctors #Laravel #Livewire #TailwindCSS #AlpineJS #Vite #NPIRegistry #HealthcareData #DoctorDirectory #ClinicSearch #Specialties #ArtisanCommands #PHP #Accessibility #MobileFirst #APIDriven
