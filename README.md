
![Laracom Dashboard](screenshots/dashboard.png)

# 🛍️ Laracom

Laravel FREE E-Commerce Software. A full-featured, modular e-commerce platform built on Laravel, designed for rapid deployment and scalable management of products, inventory, and orders.


## ✨ Key Features

| Feature | Description |
|---------|-------------|
| 🏪 **Products** | Full product management with categories, attributes, and inventory tracking |
| 🛒 **Shopping Cart** | Persistent cart functionality with guest checkout support |
| 💳 **Checkout** | Streamlined multi-step checkout process |
| 📦 **Order Management** | Complete order processing and management |
| 👥 **Customer System** | Customer accounts, profiles, and order history |
| 💰 **Payment Integration** | Multiple payment gateway support |
| 🚚 **Shipping** | Courier integration and shipping management |
| 👔 **Admin Dashboard** | Comprehensive admin interface for store management |

## 🏗️ System Architecture

```mermaid
graph TD
    subgraph "Client Layer"
        A[Web Browser]
        B[Mobile App]
    end
    
    subgraph "Load Balancer"
        C[NGINX]
    end
    
    subgraph "Application Layer"
        D[Laravel Application]
        E[API Endpoints]
        F[Authentication]
    end
    
    subgraph "Services"
        G[Payment Processing]
        H[Order Processing]
        I[Inventory Management]
        J[Email Service]
    end
    
    subgraph "Data Layer"
        K[(MySQL Database)]
        L[(Redis Cache)]
        M[(File Storage)]
    end
    
    A --> C
    B --> C
    C --> D
    D --> E
    D --> F
    D --> G
    D --> H
    D --> I
    D --> J
    
    D --> K
    D --> L
    D --> M
    
    style A fill:#e1f5fe,stroke:#039be5
    style B fill:#e1f5fe,stroke:#039be5
    style C fill:#e8f5e9,stroke:#43a047
    style D fill:#e8eaf6,stroke:#3949ab
    style E fill:#e8eaf6,stroke:#3949ab
    style F fill:#e8eaf6,stroke:#3949ab
    style G fill:#f3e5f5,stroke:#9c27b0
    style H fill:#f3e5f5,stroke:#9c27b0
    style I fill:#f3e5f5,stroke:#9c27b0
    style J fill:#f3e5f5,stroke:#9c27b0
    style K fill:#fce4ec,stroke:#e91e63
    style L fill:#fce4ec,stroke:#e91e63
    style M fill:#fce4ec,stroke:#e91e63
```

## 🔄 System Flow

### Customer Workflow

```mermaid
graph TD
    A[Visitor] -->|Browse| B[Product Catalog]
    B --> C[Product Details]
    C --> D[Add to Cart]
    D --> E{Checkout}
    E -->|Guest| F[Register/Login]
    E -->|Logged In| G[Shipping Info]
    F --> G
    G --> H[Payment]
    H --> I[Order Confirmation]
    I --> J[Order Tracking]
    
    style A fill:#9f9,stroke:#333
    style I fill:#9f9,stroke:#333
```

### Admin Workflow

```mermaid
graph TD
    A[Admin Login] --> B[Dashboard]
    B --> C[Products]
    B --> D[Orders]
    B --> E[Customers]
    C --> C1[Add/Edit Products]
    D --> D1[Process Orders]
    E --> E1[Manage Customers]
    
    style A fill:#9cf,stroke:#333
    style B fill:#c9f,stroke:#333
```

## 🏗️ System Architecture

```mermaid
graph TD
    subgraph "Laravel E-commerce System"
        A[Web Browser] -->|HTTP/HTTPS| B[Nginx Web Server]
        B -->|PHP-FPM| C[Laravel Application]
        
        subgraph "Application Layer"
            C --> D[Controllers]
            C --> E[Models]
            C --> F[Views]
            C --> G[Middleware]
        end
        
        subgraph "Services"
            C --> H[Authentication]
            C --> I[Authorization]
            C --> J[Payment Processing]
            C --> K[Order Processing]
            C --> L[Inventory Management]
        end
        
        subgraph "Data Layer"
            M[(MySQL Database)]
            N[(Redis Cache)]
            O[(File Storage)]
        end
        
        D --> M
        E --> M
        H --> M
        I --> M
        J --> M
        K --> M
        L --> M
        
        C --> N
        C --> O
    end
    
    style A fill:#e1f5fe,stroke:#039be5,stroke-width:2px
    style B fill:#e8f5e9,stroke:#43a047,stroke-width:2px
    style C fill:#e8eaf6,stroke:#3949ab,stroke-width:2px
    style M fill:#fce4ec,stroke:#e91e63,stroke-width:2px
    style N fill:#f3e5f5,stroke:#9c27b0,stroke-width:2px
    style O fill:#e8f5e9,stroke:#4caf50,stroke-width:2px
```

### Key Components:
- **Frontend**: Responsive web interface built with Blade templates and JavaScript
- **Web Server**: Nginx handling HTTP requests and serving static assets
- **Application**: Laravel framework with MVC architecture
- **Authentication**: Secure user authentication and authorization
- **Services**: Modular services for business logic
- **Database**: MySQL for data persistence
- **Cache**: Redis for improved performance
- **Storage**: Local file storage for uploads and media



# Installation Process

## Step 1: Clone the repository

```bash
git clone https://github.com/jsdecena/laracom.git
cd laracom
```

## Step 2: Docker Setup

### For standard systems:
```bash
docker-compose up -d --build
```

### For Apple Silicon (M1/M2) systems:
```bash
docker-compose -f docker-compose-m1.yml up -d --build
```

### Access the container:
```bash
docker exec -it app bash
```

### Inside the container, run these commands:
```bash
# Install dependencies and set permissions
composer install && chmod -R 777 storage/ bootstrap/cache/

# Run database migrations and seed initial data
php artisan migrate --seed

# Install and compile frontend assets
npm i && npm run dev

# Create storage link for images
php artisan storage:link
```

## Step 3: Access the Application

Open your browser and navigate to:
```
http://localhost:8000
```

## Optional: MailHog Setup

1. Create a `mails` directory in your project root:
   ```bash
   mkdir -p mails
   ```

2. Update your `.env` file with these mail settings:
   ```
   MAIL_DRIVER=smtp
   MAIL_HOST=mailhog
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="test@example.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

3. Verify MailHog is running by accessing the web interface at:
   ```
   http://localhost:8025
   ```
   You should see the MailHog web interface where you can view all outgoing emails.

## 🖥️ UI Showcase

### 1. User Authentication
Secure and intuitive authentication system for both customers and administrators.

<div align="center">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/login.png" alt="Login Page" width="45%" style="margin: 5px;">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/register.png" alt="Registration Page" width="45%" style="margin: 5px;">
</div>

### 2. Shopping Experience
Seamless shopping experience from product selection to checkout.

<div align="center">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/shoppingcart.png" alt="Shopping Cart" width="30%" style="margin: 5px;">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/shoppingcart1.png" alt="Cart Items" width="30%" style="margin: 5px;">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/shoppingcart2.png" alt="Checkout Process" width="30%" style="margin: 5px;">
</div>

### 3. Order Management
Efficient order processing and management system.

<div align="center">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/shippingaddress.png" alt="Shipping Address" width="45%" style="margin: 5px;">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/shippingaddress1.png" alt="Order Confirmation" width="45%" style="margin: 5px;">
</div>

### 4. Admin Dashboard
Comprehensive dashboard for managing your e-commerce store.

<div align="center">
  <img src="https://raw.githubusercontent.com/rane-ella/prefinal-laracom/master/screenshots/dashboard.png" alt="Admin Dashboard" width="90%" style="margin: 10px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
</div>
