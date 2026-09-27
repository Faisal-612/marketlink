# MarketLink – Farm Fresh Just a Click Away
**Farmers Market Pre-Order Platform | End-to-End Web Solution**  
**Theme:** eGreen Basket  
**Platform Architecture:** Laravel 11+ / PHP 8.3 / SQLite & MySQL / Bootstrap 5 / Leaflet.js (OpenStreetMap) / Chart.js  

---

## 1. Problem Definition
Local weekend farmers markets are rapidly growing as consumers seek fresh, seasonal, chemical-free produce. However, customers rarely know in advance which farmers will attend on a given weekend, what stock they have, or at what pricing. This results in wasted travel trips, popular items getting sold out early, and smallholder farmers experiencing unpredictable demand and post-harvest food waste.

**MarketLink** bridges this gap by providing a full-stack, multi-role web platform where:
- **Farmers** publish their weekly harvest stock, set order cutoff windows, and manage pre-orders for scheduled market pickups.
- **Shoppers / Customers** discover nearby farmers markets on an interactive map, browse live produce availability, reserve items without payment friction, and settle payments directly in person at the stall.
- **Administrators** verify and approve farmers, manage market locations/coordinates, broadcast platform announcements, and monitor gross revenue analytics.

---

## 2. Mandatory User Credentials (For Evaluation & Testing)

| Role | Email Address | Password | Role Description & Capabilities |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@marketlink.com` | `password` | SuperAdmin dashboard, farmer stall verifications/approvals, manage markets, categories, platform revenue reports. |
| **Farmer (Approved)** | `greenfarms@marketlink.com` | `password` | Stall manager (*Green Valley Organics*), weekly produce inventory, incoming pre-orders processing (accept/ready/complete), pickup schedule. |
| **Farmer 2 (Approved)** | `orchards@marketlink.com` | `password` | Stall manager (*Sunshine Orchards & Pure Honey*), fruit & honey catalog, customer reviews & replies. |
| **Farmer (Pending)** | `hydroponics@marketlink.com` | `password` | Newly registered farmer account pending Admin approval (test Admin approval workflow). |
| **Customer 1** | `ali.khan@gmail.com` | `password` | Shopper account with active order history, pickup slot checkout, ratings & reviews. |
| **Customer 2** | `sara.ahmed@gmail.com` | `password` | Shopper account with pre-orders and saved favorites. |

---

## 3. Key Functional Modules & Features

### A. Public & Customer Experience
1. **Produce Catalog & Smart Filters:** Filter by category (Vegetables, Fruits, Dairy, Bakery, Herbs, Honey), price range, market location, and sort by price/latest.
2. **Interactive Farmers Markets Map (Leaflet.js & OpenStreetMap):** Interactive map showing weekend market locations, GPS coordinates, operating days, and list of attending farmer stalls with popup cards.
3. **Weekly Pre-Order Basket:** Cart system grouped by farmer stall to guarantee order integrity.
4. **Scheduled Pickup Time Slots:** Customers select available market day dates and pickup time windows within the farmer's operating schedule.
5. **Real-time Order Tracker:** 4-stage visual progress timeline: `Placed` ➔ `Accepted` ➔ `Ready for Pickup` ➔ `Completed`.
6. **AI Harvest Assistant (Chatbot):** Intelligent assistant on every page to answer FAQ queries, lookup produce prices, check market timings, and guide pre-orders.
7. **Accessibility Features:** Top toolbar with font size adjustments (A-, A, A+) and instant Dark/Light mode switcher.
8. **Application Sitemap:** Complete visual sitemap link located on homepage and footer.

### B. Farmer / Vendor Portal
1. **Stall Dashboard:** Real-time KPI counters for total pre-orders, pending pickups, gross revenue, best-selling harvest items, and customer reviews.
2. **Produce Stock Management:** CRUD operations on produce items, price per unit (`kg`, `dozen`, `bunch`, `piece`, `box`, `jar`), stock levels, and instant Sold Out toggle.
3. **Weekly Stock Template:** One-click template replenish feature to restore recurring stock for upcoming weekend markets.
4. **Pre-Order Processing:** Accept orders, add packaging notes, mark "Ready for Pickup", and record completion upon payment collection.
5. **Customer Feedback & Replies:** Direct dialogue to reply to shopper reviews.

### C. Administrator Portal
1. **Farmer Approvals:** Review new grower registrations, verify stall information, approve or suspend accounts.
2. **Market Locations Manager:** Add and edit farmers markets with city, address, operating schedules, and map latitude/longitude pins.
3. **Category Master Data:** Manage produce classifications and icon tags.
4. **Revenue & Analytics Reports:** Period-based financial metrics with interactive Chart.js revenue bars and order status distribution charts.
5. **System Announcements:** Broadcast targeted notices to all shoppers or farmers.

---

## 4. Project Installation & Setup Instructions (MANDATORY)

### Prerequisites:
- PHP 8.2 or PHP 8.3 (with `pdo_sqlite`, `pdo_mysql`, `curl`, `mbstring`, `fileinfo`, `gd`, `zip` extensions enabled)
- Composer
- Web Browser (Chrome, Edge, Firefox)

### Step 1: Open Terminal in Project Directory
```powershell
cd C:\Users\Developers\Downloads\Poject\marketlink
```

### Step 2: Configure Environment & Database
The project is configured to run out-of-the-box with SQLite (`database/database.sqlite`) or MySQL (via `.env`).

To reset and seed the fresh database with test data:
```powershell
php artisan migrate:fresh --seed
```

### Step 3: Run the Development Server
```powershell
php artisan serve
```

The application will be live at:
**`http://127.0.0.1:8000`**

### Step 4: Run Automated Tests
```powershell
php artisan test
```
All feature and unit test assertions will execute with 100% pass rate.

---

## 5. Assumptions Made
1. **Payment Model:** In accordance with the SRS specifications, all pre-orders are reserved without online credit card gateway processing. Payment is settled in person at the farmer's stall upon pickup.
2. **Mapping Service:** OpenStreetMap with Leaflet.js was utilized for mapping to ensure 100% free, reliable, offline-capable map rendering without requiring paid third-party API key configurations.
3. **Order Grouping:** Because customers pick up pre-orders directly from individual stalls, each pre-order checkout is scoped to a single farmer stall.

---
*MarketLink - eGreen Basket Farmers Market Pre-Order Platform.*
