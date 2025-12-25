# PrimeDoctors — Healthcare Directory & NPI Ingestion Platform

PrimeDoctors is a Laravel 12 + Livewire 3 application that ingests the official NPI Registry (CMS/HHS) data set and turns it into a polished, mobile‑first directory of doctors, organizations, and specialties. It ships with production-grade import commands, rich search/filters, responsive UI shells, and legal/about pages tailored for healthcare.

---

## Table of Contents
- Vision & Value Proposition
- Architecture & Tech Stack
- Data Model & Source of Truth
- Data Import Commands (Artisan)
- Public Pages & Flows (URLs)
- Blog Section (Detailed)
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
- **Blog content**: Multi-source article aggregation (NewsAPI, RSS feeds, local database) via `blog:fetch-articles` command.
- **Database**: Laravel default (SQLite checked in for convenience) but works with MySQL/PostgreSQL.
- **Testing/quality**: PHPUnit 11, Laravel Pint (code style), Laravel Pail (logging/observability).

---

## Data Model & Source of Truth
- **Doctors** (`App\Models\Doctor`): NPI-1 providers with name, taxonomy (specialty), gender, city, state, organization_name, NPI, and relationships to Reviews.
- **Organizations** (`App\Models\Organization`): NPI-2 entities with name, city, state, phone; linked to doctors by organization_name.
- **Specialties** (`App\Models\Specialty`): taxonomy codes/descriptions harvested during doctor/org imports.
- **Reviews** (`App\Models\Review`): simple user-submitted feedback per doctor (rating, comment, name).
- **BlogPosts** (`App\Models\BlogPost`): medical articles with title, slug, content, excerpt, image, author, topic, read_time, and optional doctor relationship.
- Data provenance: all entities originate from the NPI Registry API via purpose-built Artisan commands (below). Blog posts are aggregated from NewsAPI, RSS feeds, and local database via `blog:fetch-articles`.

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

### `blog:fetch-articles`
- **Signature**: `php artisan blog:fetch-articles {--limit=100 : Maximum number of articles to fetch}`
- **Purpose**: Fetch medical articles from multiple online sources and store them in the database. This command aggregates articles from NewsAPI, RSS feeds, and includes a comprehensive local article database as fallback.
- **Location**: `app/Console/Commands/FetchMedicalArticles.php`
- **Default Limit**: 100 articles (use `--limit=0` for unlimited, or specify a number)

#### How It Works

**1. Multi-Source Article Fetching**
The command attempts to fetch articles from three primary sources in order:

**a) NewsAPI Integration** (Optional)
- **Requirement**: Requires `NEWS_API_KEY` environment variable in `.env`
- **Process**:
  - Searches for articles using 20+ medical keywords (cardiology, oncology, pediatrics, mental health, diabetes, cancer, nutrition, fitness, prevention, vaccine, surgery, therapy, diagnosis, pharmaceutical, clinical trial, public health, epidemiology, immunology, etc.)
  - Fetches up to 5 pages per keyword (100 articles per page, max allowed by NewsAPI)
  - Applies 1-second rate limiting between pages and keywords
  - Extracts: title, description, content, image URL, author, publication date
  - Automatically categorizes articles based on title keywords
- **Fallback**: If API key is not configured, skips NewsAPI and continues with other sources

**b) RSS Feed Aggregation**
- **Sources**: Fetches from 30+ medical and health RSS feeds including:
  - WHO (World Health Organization)
  - ScienceDaily Health & Medicine
  - BBC Health
  - WebMD
  - NPR Health
  - CNN Health
  - The Guardian Health
  - Medical Xpress
  - EurekAlert Health
  - News Medical
  - Healio
  - MedPage Today
  - STAT News
  - Health.com
  - Verywell Health
  - Everyday Health
  - Prevention
  - Men's Health
  - Women's Health
  - Runner's World
  - Yoga Journal
  - MindBodyGreen
  - Psychology Today
  - Mayo Clinic
  - NIH (National Institutes of Health)
  - And more
- **Process**:
  - Parses XML/RSS feeds using PHP's `simplexml_load_string()`
  - Extracts: title, description, link, author, publication date
  - Extracts images from Media RSS namespaces when available
  - Applies 1-second delay between feed requests
  - Handles errors gracefully (continues if a feed fails)
  - User-Agent header: `Mozilla/5.0 (compatible; MedicalArticleBot/1.0)`
  - 15-second timeout per feed

**c) Medical Websites** (Placeholder)
- Currently a placeholder for future web scraping functionality
- Designed to respect robots.txt and terms of service

**2. Comprehensive Local Article Database**
If online sources fail or don't provide enough articles, the command includes a built-in database of 20+ comprehensive medical articles covering:
- Heart Disease: Prevention and Early Detection
- Regular Health Screenings
- Diabetes Management
- Mental Health and Wellness
- Nutrition for Optimal Health
- Exercise and Physical Activity
- Cancer: Prevention, Detection, and Treatment
- Pediatric Health
- Sleep Health
- Women's Health
- Hypertension Management
- Asthma Management
- Arthritis Treatment
- Thyroid Health
- Migraine Management
- Osteoporosis Prevention
- Allergy Management
- Digestive Health
- Skin Health
- Eye Health
- Stress Management
- Cholesterol Management
- Common Cold Prevention
- Weight Management

Each local article includes:
- Detailed, medically accurate content (500-2000+ words)
- Proper HTML formatting
- Author attribution
- Topic categorization
- Read time calculation
- Featured image URLs (Unsplash)

**3. Article Variation Generation**
If the target limit isn't reached after fetching from all sources, the command generates additional article variations:
- Uses template-based titles (e.g., "Latest Research on {topic}", "Understanding {topic}: A Comprehensive Guide")
- Combines 20+ health topics with 10+ title templates
- Ensures unique titles (adds numeric suffixes if duplicates detected)
- Uses base articles for content structure
- Generates appropriate excerpts and metadata

**4. Article Processing & Storage**
For each article (from any source), the command:
- **Validates**: Skips articles with empty title or content
- **Slug Generation**: Creates URL-friendly slug from title using `Str::slug()`
- **Upsert Logic**: Uses `updateOrCreate()` to prevent duplicates (based on slug)
- **Excerpt Generation**: Auto-generates 200-character excerpt if not provided
- **Image Handling**: 
  - Uses provided image URL if valid
  - Falls back to random Unsplash medical image if missing/invalid
  - Validates image URLs to ensure they're not just domain names
- **Author Assignment**:
  - Uses provided author name
  - Falls back to random doctor name from predefined list (14 doctors)
  - Format: "Dr. [First Name] [Last Name]"
- **Topic Categorization**:
  - Analyzes title for medical keywords
  - Maps to appropriate category (Cardiology, Oncology, Mental Health, etc.)
  - Falls back to "General Health" if no match
  - Categories include: Cardiology, Oncology, Mental Health, Pediatrics, Endocrinology, Nutrition, Fitness, Preventive Care, Women's Health, Sleep Medicine
- **Read Time Calculation**:
  - Calculates based on word count (200 words per minute)
  - Clamps between 3-20 minutes
  - Uses provided read_time if available
- **Publication Date**:
  - Uses actual publication date from source if available
  - Falls back to random date within last 90 days for local articles
  - Can be up to 180 days ago for variations

**5. Progress Tracking**
- Displays progress bar during article import
- Shows count of articles fetched from each source
- Reports total articles imported/updated
- Provides warnings for failed sources (continues execution)

#### Command Output Example
```
Fetching medical articles from the internet...
Attempting to fetch articles from online sources...
Attempting to fetch from NewsAPI...
NewsAPI key not configured. Skipping NewsAPI fetch.
Attempting to fetch from RSS feeds...
Fetching from: https://www.who.int/rss-feeds/news-english.xml
  ✓ Fetched 15 articles from www.who.int
Fetching from: https://www.sciencedaily.com/rss/health_medicine.xml
  ✓ Fetched 20 articles from www.sciencedaily.com
...
Successfully fetched 150 articles from RSS feeds.
Using comprehensive article database...
Generating additional article variations to reach target (50 needed)...
[Progress Bar: █████████████████████████████████████████] 100%
Successfully imported/updated 200 medical articles.
```

#### Configuration

**Environment Variables**:
- `NEWS_API_KEY` (optional): Your NewsAPI.org API key for fetching news articles
  - Get a free key at: https://newsapi.org/
  - Free tier: 100 requests/day, 1,000 articles/month

**Rate Limiting**:
- 1-second delay between NewsAPI pages
- 1-second delay between NewsAPI keywords
- 1-second delay between RSS feed requests
- 10-second timeout for NewsAPI requests
- 15-second timeout for RSS feed requests

#### Article Quality Features
- **Content Validation**: Only stores articles with valid title and content
- **Duplicate Prevention**: Slug-based deduplication ensures no duplicate articles
- **Image Validation**: Validates image URLs to prevent broken images
- **HTML Sanitization**: Uses Laravel's `e()` helper for safe HTML output
- **Automatic Categorization**: Intelligent topic assignment based on content analysis
- **SEO Optimization**: Slug-based URLs, proper meta data, structured content

#### Use Cases
- **Initial Setup**: Run `php artisan blog:fetch-articles --limit=200` to populate blog with initial content
- **Regular Updates**: Schedule via cron to fetch new articles daily/weekly
- **Content Refresh**: Re-run to update existing articles or add new ones
- **Testing**: Use `--limit=10` for quick testing without overwhelming the database

#### Integration with Doctor Profiles
Articles can be linked to doctor profiles via the `doctor_id` foreign key:
- When a doctor is set as author, the article shows on their profile
- Author pages (`/blog/authors/{doctor}`) display all articles by that doctor
- Articles without `doctor_id` use the `author` string field as fallback

### Operational notes
- Progress bars are rendered in the console; failures are logged with HTTP status.
- Upserts prevent duplicates across runs (idempotent refreshes).
- Pagination: uses `skip` increments of `limit` until results are exhausted.
- Blog articles: `blog:fetch-articles` command handles rate limiting, error handling, and graceful fallbacks to ensure reliable content ingestion.

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
- Styled legal pages with current "Last updated" date, clear sections on data use, rights, cookies, disclaimers, and governing law.

### `/blog` — Medical Blog Section
The blog section provides a comprehensive medical articles platform with topic-based filtering, author pages, and rich content management. It's designed to showcase health-related articles, medical insights, and wellness tips from healthcare professionals.

#### Blog Routes & Pages

**`GET /blog`** — Blog Index Page
- **Purpose**: Main blog listing page displaying all published articles
- **Features**:
  - Hero section with gradient background and title
  - Topic filter section with visual topic cards (up to 5 topics shown, with "View All" link)
  - Responsive article grid (12 articles per page)
  - Pagination with query string preservation
  - Topic filtering via `?topic=Cardiology` query parameter
  - Mobile-optimized 2-column grid for topic cards
  - Desktop-optimized multi-column layout
  - Each article card displays:
    - Featured image (with fallback to Unsplash medical images)
    - Title and excerpt
    - Author name (can be linked to doctor profile if `doctor_id` is set)
    - Topic/category badge
    - Read time estimate
    - Publication date
- **Controller**: `App\Http\Controllers\BlogController@index`
- **View**: `resources/views/blog/index.blade.php`
- **Data**: Only shows posts where `published_at` is not null and is in the past

**`GET /blog/topics`** — All Topics Page
- **Purpose**: Comprehensive listing of all blog topics with article counts
- **Features**:
  - Grid layout showing all unique topics
  - Each topic card displays the topic name and post count
  - Links to filtered blog index (`/blog?topic=TopicName`)
  - Similar to healthline.com/wellness structure
- **Controller**: `App\Http\Controllers\BlogController@topics`
- **View**: `resources/views/blog/topics.blade.php`

**`GET /blog/{post:slug}`** — Individual Article Page
- **Purpose**: Full article view with complete content
- **Features**:
  - Full article content with HTML formatting
  - Author information (with link to doctor profile if available)
  - Publication date and read time
  - Topic/category display
  - Related articles section (optional)
  - Social sharing capabilities (optional)
  - SEO-optimized meta tags
- **Controller**: `App\Http\Controllers\BlogController@show`
- **View**: `resources/views/blog/show.blade.php`
- **Route Model Binding**: Uses `slug` as the route key (not `id`)
- **Security**: Only shows published articles (404 for unpublished or future-dated posts)

**`GET /blog/authors/{doctor}`** — Author Page
- **Purpose**: Display all blog posts by a specific doctor author
- **Features**:
  - Doctor profile information
  - Grid of all articles written by the doctor
  - Pagination (12 articles per page)
  - Similar to vsevrachizdes.ru/blog/authors structure
- **Controller**: `App\Http\Controllers\BlogController@author`
- **View**: `resources/views/blog/author.blade.php`
- **Relationship**: Uses `doctor_id` foreign key to link posts to doctors

#### Blog Data Model

**`App\Models\BlogPost`** — Blog Post Model
- **Database Table**: `blog_posts`
- **Fields**:
  - `id` (primary key)
  - `title` (string, required)
  - `slug` (string, unique, auto-generated from title if not provided)
  - `excerpt` (text, nullable) — Short summary for listings
  - `content` (longText, required) — Full article HTML content
  - `image_url` (string, nullable) — Featured image URL
  - `author` (string, default: 'Medical Team') — Author name (fallback if no doctor_id)
  - `topic` (string, default: 'General') — Category/topic classification
  - `read_time` (integer, default: 5) — Estimated reading time in minutes
  - `published_at` (timestamp, nullable) — Publication date (null = draft)
  - `doctor_id` (foreign key, nullable) — Links to `doctors` table if authored by a doctor
  - `timestamps` (created_at, updated_at)
- **Relationships**:
  - `doctor()` — Belongs to `App\Models\Doctor` (optional)
- **Route Key**: Uses `slug` instead of `id` for SEO-friendly URLs
- **Auto-slugging**: Automatically generates slug from title on creation if not provided
- **Image Validation**: `getValidImageUrlAttribute()` accessor validates image URLs to ensure they're not just domain names

#### Blog Topics/Categories
The blog supports multiple medical topics including:
- Cardiology
- Oncology
- Mental Health
- Pediatrics
- Endocrinology
- Nutrition
- Fitness
- Preventive Care
- Women's Health
- Sleep Medicine
- General Health
- And more (dynamically categorized based on article content)

#### Blog UI Features
- **Responsive Design**: Mobile-first approach with breakpoints for tablet and desktop
- **Topic Cards**: Visual topic selection with custom images (stored in `/public/img/topics/`)
- **Gradient Backgrounds**: Modern emerald/teal gradient theme matching the site design
- **Image Fallbacks**: Automatic fallback to Unsplash medical images if article image is invalid
- **Read Time Calculation**: Automatically calculated based on word count (200 words/minute)
- **Pagination**: Laravel pagination with query string preservation for filters
- **SEO-Friendly URLs**: Slug-based routing for better search engine optimization

---

## API / AJAX Endpoints
- **`GET /api/search/doctors`** — Lightweight autocomplete for doctors. Returns up to 10 items with relevance ordering (prefix boosts on name/taxonomy, contains on org/city/state).
- **`GET /api/search/autocomplete`** — Unified autocomplete for doctors, organizations, specialties (tagged by type, URL included).
- **`GET /search` (JSON)** — Returns rendered HTML for search results + canonical URL.
- **`GET /doctors` (JSON)** and **`GET /organizations` (JSON)** — Return rendered list partials, refreshed city options, pagination info, and canonical URL for filters.
- **`POST /doctors/{doctor}/reviews`** — Create a review; AJAX responses return refreshed reviews HTML plus status message.
- **`GET /blog` (JSON)** — Returns rendered HTML for blog article listings with pagination and topic filtering.
- **`GET /blog/{post:slug}`** — Individual article page with full content, author info, and related articles.

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
