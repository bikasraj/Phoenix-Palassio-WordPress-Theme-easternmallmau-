# Phoenix Palassio WordPress Theme

A complete, custom WordPress theme for Phoenix Palassio Mall, Lucknow.

---

## Theme Pages Included

| Page | Template File | Description |
|------|--------------|-------------|
| Home | `index.php` | Hero slider, fashion brands carousel, food section, brands marquee, blogs |
| Brands | `page-templates/page-brands.php` | Filterable brands grid with search |
| Dine | `page-templates/page-dine.php` | All restaurants with veg/non-veg filters |
| Entertainment | `page-templates/page-entertainment.php` | Movies + Fun & Games sections |
| Fun & Games | `page-templates/page-fun-games.php` | Games listing page |
| Offers & Packages | `page-templates/page-offers.php` | Offers and packages grid |
| Events | `page-templates/page-events.php` | Upcoming events with date/price |
| Concierge Services | `page-templates/page-concierge.php` | Mall services with tab navigation |
| Gift Card | `page-templates/page-gift-card.php` | Gift card info, FAQs, corporate enquiry |

---

## Installation

1. Upload the `phoenix-palassio` folder to `/wp-content/themes/`
2. Activate the theme from **Appearance → Themes**
3. Go to **Appearance → Customize** to set:
   - Mall timings
   - Phone number
   - Location name
   - Social media links
   - OLA/UBER links
   - Google Maps embed URL
   - Mall addresses
4. Upload your logo at **Appearance → Customize → Site Identity**

---

## Creating Pages

After activation, create these WordPress Pages and assign the template:

| Page Title | Template to Assign |
|-----------|-------------------|
| Home | (Set as front page in Settings → Reading) |
| Brands | Brands Page |
| Dine | Dine Page |
| Entertainment | Entertainment Page |
| Fun & Games | Fun and Games Page |
| Offers and Packages | Offers and Packages Page |
| Events | Events Page |
| Concierge Services | Concierge Services Page |
| Gift Card | Gift Card Page |

---

## Adding Content

### Brands
Go to **Brands → Add New**
- Title = Brand name
- Featured Image = Brand logo/photo
- Brand Details meta box: Phone, Floor, Category (display text)
- Taxonomy: Brand Categories (Women's Fashion, Men's Fashion, etc.)

### Restaurants (Dine)
Go to **Restaurants → Add New**
- Title = Restaurant name
- Featured Image = Restaurant photo
- Restaurant Details: Timing, Floor, Type, Veg/Non-Veg checkboxes

### Entertainment / Fun & Games
Go to **Entertainment → Add New**
- Title = Venue name
- Entertainment Details: Timing, Type (Movies or Fun & Games)

### Events
Go to **Events → Add New**
- Title = Event name
- Event Details: Date, Timing, Price, Category

### Offers & Packages
Go to **Offers & Packages → Add New**
- Title = Offer/Package name
- Offer Details: Price, Validity, Type (Offer or Package)

### Hero Slides
Go to **Hero Slides → Add New**
- Title = Slide identifier
- Featured Image = Slide image (left side)
- Slide Details: Headline, Offer Text, Offer Period, Link URL, Layout

### Blog Posts
Go to **Posts → Add New** (standard WordPress posts)

---

## Navigation Setup

Go to **Appearance → Menus** and create/assign menus for:
- **Primary Menu** — Main navigation (Brands, Dine, Entertainment, Offers & Packages, Events, Concierge Services, Gift Card)
- **Who We Are** — Footer column
- **Get Involved** — Footer column
- **Latest** — Footer column

---

## Images Needed

Place in `/images/` directory inside the theme:
- `logo.png` — Main logo (color, ~200px wide)
- `logo-white.png` — White version for footer
- `logo-black.png` — Black version for hero slides

---

## Color Scheme

| Variable | Color | Usage |
|---------|-------|-------|
| `--gold` | #C9A84C | Primary brand color |
| `--black` | #0A0A0A | Dark backgrounds, text |
| `--red` | #E63946 | Accents, view more links, active tabs |
| `--white` | #FFFFFF | Backgrounds |
| `--off-white` | #F8F6F2 | Section backgrounds |

---

## Dependencies

- Google Fonts: Playfair Display, Montserrat, Cormorant Garamond
- Font Awesome 6.4.0 (CDN)
- jQuery (bundled with WordPress)

---

## Customization

All colors are defined as CSS variables in `style.css` under `:root {}`.  
To change the gold color: update `--gold: #C9A84C;` to your preferred hex.

---

*Theme developed for Phoenix Palassio, Lucknow — Destiny Retail Mall Developers Private Limited.*
