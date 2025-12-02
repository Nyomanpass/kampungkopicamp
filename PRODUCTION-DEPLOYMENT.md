# 🚀 Production Deployment Guide - Kampung Kopi Camp

## 📋 Table of Contents
- [Pre-Deployment Checklist](#pre-deployment-checklist)
- [Server Requirements](#server-requirements)
- [Environment Configuration](#environment-configuration)
- [Database Setup](#database-setup)
- [File Storage & Permissions](#file-storage--permissions)
- [Security Setup](#security-setup)
- [Performance Optimization](#performance-optimization)
- [Third-Party Services](#third-party-services)
- [Monitoring & Logging](#monitoring--logging)
- [Backup Strategy](#backup-strategy)
- [Post-Deployment Tasks](#post-deployment-tasks)
- [Troubleshooting](#troubleshooting)

---

## 🔍 Pre-Deployment Checklist

### Code Quality
- [ ] All features tested thoroughly in staging environment
- [ ] No debug code (`dd()`, `dump()`, `var_dump()`) left in codebase
- [ ] All console.log() removed from JavaScript
- [ ] Code reviewed and optimized
- [ ] All TODOs addressed or documented

### Testing
- [ ] Run all unit tests: `php artisan test`
- [ ] Test booking flow end-to-end
- [ ] Test payment gateway (Midtrans sandbox → production)
- [ ] Test email notifications
- [ ] Test all reports (Revenue, Bookings, Customers, Financial)
- [ ] Test admin panel functionality
- [ ] Test user registration & login
- [ ] Mobile responsiveness verified
- [ ] Cross-browser testing completed

### Version Control
- [ ] All changes committed to git
- [ ] Create production release tag: `git tag -a v1.0.0 -m "Production Release"`
- [ ] Push to repository: `git push origin main --tags`

---

## 💻 Server Requirements

### Minimum Specifications
```
PHP: >= 8.1
MySQL/MariaDB: >= 8.0 / 10.4
Composer: Latest version
Node.js: >= 18.x
NPM: >= 9.x
```

### Required PHP Extensions
```
BCMath
Ctype
DOM
Fileinfo
JSON
Mbstring
OpenSSL
PDO
PDO_MySQL
Tokenizer
XML
GD (for image manipulation)
ZIP
```

### Server Software (Choose One)
- **Option 1**: Apache + mod_rewrite enabled
- **Option 2**: Nginx + PHP-FPM
- **Option 3**: Laravel Forge (Recommended)
- **Option 4**: Cloudways / DigitalOcean App Platform

---

## ⚙️ Environment Configuration

### 1. Create Production `.env` File

```bash
# Copy from example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Configure `.env` Variables

```env
# Application
APP_NAME="Kampung Kopi Camp"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false  # ⚠️ MUST BE FALSE IN PRODUCTION
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kampungkopicamp_prod
DB_USERNAME=your_db_user
DB_PASSWORD=your_strong_password_here

# Mail Configuration (Choose one provider)
# Option 1: Gmail SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Option 2: Mailgun (Recommended for production)
# MAIL_MAILER=mailgun
# MAILGUN_DOMAIN=mg.yourdomain.com
# MAILGUN_SECRET=your-mailgun-key

# Option 3: SendGrid
# MAIL_MAILER=sendgrid
# SENDGRID_API_KEY=your-sendgrid-key

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your_production_server_key
MIDTRANS_CLIENT_KEY=your_production_client_key
MIDTRANS_IS_PRODUCTION=true  # ⚠️ SET TO TRUE FOR PRODUCTION
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Session & Cache
SESSION_DRIVER=file  # or 'redis' for better performance
CACHE_DRIVER=file    # or 'redis' for better performance
QUEUE_CONNECTION=database  # or 'redis' for better performance

# Filesystem
FILESYSTEM_DISK=public

# Logging
LOG_CHANNEL=daily
LOG_LEVEL=error  # Only log errors in production

# Security
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true  # HTTPS only
SESSION_SAME_SITE=lax
```

### 3. Important Security Notes
- ⚠️ **NEVER** commit `.env` to git
- ⚠️ Use strong database passwords (minimum 16 characters)
- ⚠️ Keep `APP_DEBUG=false` in production
- ⚠️ Use HTTPS (SSL Certificate required)

---

## 🗄️ Database Setup

### 1. Create Production Database
```sql
CREATE DATABASE kampungkopicamp_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'kopi_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON kampungkopicamp_prod.* TO 'kopi_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Run Migrations
```bash
# Fresh migration (for new database)
php artisan migrate --force

# If migrating from existing data
php artisan migrate --force
```

### 3. Seed Initial Data (Admin User)
```bash
# Create admin user
php artisan db:seed --class=UserSeeder --force

# Or manually via Tinker
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->name = 'Admin';
>>> $user->email = 'admin@kampungkopicamp.com';
>>> $user->password = bcrypt('your_admin_password');
>>> $user->role = 'admin';
>>> $user->email_verified_at = now();
>>> $user->save();
```

### 4. Database Backup Script
Create automated daily backups:
```bash
# Create backup script
nano /home/scripts/backup-db.sh

#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/backups/database"
DB_NAME="kampungkopicamp_prod"
DB_USER="kopi_user"
DB_PASS="your_password"

mkdir -p $BACKUP_DIR
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/backup_$DATE.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +30 -delete

# Make executable
chmod +x /home/scripts/backup-db.sh

# Add to crontab (daily at 2 AM)
crontab -e
0 2 * * * /home/scripts/backup-db.sh
```

---

## 📁 File Storage & Permissions

### 1. Create Storage Link
```bash
php artisan storage:link
```

### 2. Set Correct Permissions
```bash
# For Apache/Nginx user (usually www-data)
sudo chown -R www-data:www-data /path/to/kampungkopicamp
sudo chmod -R 755 /path/to/kampungkopicamp
sudo chmod -R 775 /path/to/kampungkopicamp/storage
sudo chmod -R 775 /path/to/kampungkopicamp/bootstrap/cache
```

### 3. Storage Directories
Ensure these directories exist and are writable:
```bash
storage/app/public/
storage/app/public/certificates/
storage/app/public/products/
storage/app/public/blogs/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
storage/logs/
```

---

## 🔒 Security Setup

### 1. SSL Certificate (HTTPS)
```bash
# Option 1: Let's Encrypt (Free)
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Option 2: Cloudflare (Free + CDN)
# Use Cloudflare SSL/TLS encryption mode: "Full (strict)"
```

### 2. Security Headers (Nginx)
Add to nginx config:
```nginx
# Prevent clickjacking
add_header X-Frame-Options "SAMEORIGIN" always;

# Prevent MIME sniffing
add_header X-Content-Type-Options "nosniff" always;

# XSS Protection
add_header X-XSS-Protection "1; mode=block" always;

# Force HTTPS
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

# CSP (Content Security Policy)
add_header Content-Security-Policy "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://app.midtrans.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; frame-src https://app.midtrans.com;" always;
```

### 3. Hide Server Information
```nginx
# Nginx
server_tokens off;

# Apache (.htaccess)
ServerSignature Off
ServerTokens Prod
```

### 4. Rate Limiting
Laravel already has throttling in `RouteServiceProvider`:
```php
// routes/web.php - Already configured
RateLimiter::for('web', function (Request $request) {
    return Limit::perMinute(60)->by($request->ip());
});
```

### 5. Block Common Attack Vectors
```nginx
# Block access to sensitive files
location ~ /\.(env|git|htaccess) {
    deny all;
    return 404;
}

# Block PHP execution in uploads directory
location ~* ^/storage/.*\.(php|php3|php4|php5|phtml)$ {
    deny all;
    return 404;
}
```

---

## ⚡ Performance Optimization

### 1. Optimize Application
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache events
php artisan event:cache
```

### 2. Compile Assets
```bash
# Production build
npm run build

# Or if using Vite
npm run build
```

### 3. Enable OPcache (php.ini)
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=1
```

### 4. Database Optimization
```sql
-- Index frequently queried columns (already done in migrations)
-- Run ANALYZE to update statistics
ANALYZE TABLE bookings;
ANALYZE TABLE payments;
ANALYZE TABLE products;
ANALYZE TABLE users;
```

### 5. Redis Setup (Optional but Recommended)
```bash
# Install Redis
sudo apt install redis-server

# Configure Laravel to use Redis
# In .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 6. Queue Workers
```bash
# Install Supervisor
sudo apt install supervisor

# Create worker config
sudo nano /etc/supervisor/conf.d/kampungkopi-worker.conf

[program:kampungkopi-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/kampungkopicamp/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/path/to/kampungkopicamp/storage/logs/worker.log
stopwaitsecs=3600

# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kampungkopi-worker:*
```

---

## ⏰ Automated Scheduled Tasks (Cron Jobs)

Laravel menggunakan task scheduler untuk menjalankan tugas otomatis. Sistem ini memerlukan **satu cron job** untuk menjalankan semua scheduled tasks.

### 1. Setup Laravel Scheduler (WAJIB)

#### Untuk Linux Server
```bash
# Edit crontab
crontab -e

# Tambahkan baris ini (jalankan scheduler setiap menit)
* * * * * cd /path/to/kampungkopicamp && php artisan schedule:run >> /dev/null 2>&1

# Atau dengan logging untuk monitoring
* * * * * cd /path/to/kampungkopicamp && php artisan schedule:run >> /path/to/kampungkopicamp/storage/logs/scheduler.log 2>&1
```

#### Untuk Windows Server (Task Scheduler)
```powershell
# Buat file batch: C:\scripts\laravel-scheduler.bat
@echo off
cd C:\laragon\www\kampungkopicamp
php artisan schedule:run

# Kemudian di Task Scheduler:
# 1. Buka Task Scheduler
# 2. Create Basic Task
# 3. Trigger: Daily, repeat every 1 minute
# 4. Action: Start a program
# 5. Program: C:\scripts\laravel-scheduler.bat
```

### 2. Scheduled Tasks yang Berjalan Otomatis

Berdasarkan project ini, tasks berikut akan berjalan otomatis:

#### A. **Pembersihan Booking Expired** (Setiap Jam)
```php
// File: app/Console/Kernel.php
// Membersihkan booking yang sudah expired (> 24 jam tanpa pembayaran)
$schedule->call(function () {
    $expiredBookings = Booking::where('status', 'pending')
        ->where('created_at', '<', now()->subHours(24))
        ->get();
    
    foreach ($expiredBookings as $booking) {
        $booking->update(['status' => 'expired']);
    }
})->hourly();
```

#### B. **Pengingat Pembayaran** (Setiap 6 Jam)
```php
// Mengirim email reminder untuk booking yang belum dibayar
$schedule->call(function () {
    $pendingBookings = Booking::where('status', 'pending')
        ->where('created_at', '>', now()->subHours(20))
        ->where('created_at', '<', now()->subHours(4))
        ->get();
    
    foreach ($pendingBookings as $booking) {
        // Kirim email reminder
        Mail::to($booking->email)->send(new PaymentReminder($booking));
    }
})->everySixHours();
```

#### C. **Backup Database Otomatis** (Setiap Hari Jam 2 Pagi)
```php
$schedule->command('backup:run')->dailyAt('02:00');
```

#### D. **Cleanup Log Files** (Setiap Minggu)
```php
$schedule->command('log:clear')->weekly();
```

#### E. **Generate Reports** (Setiap Hari Jam 6 Pagi)
```php
// Generate daily report untuk admin
$schedule->call(function () {
    // Generate statistik harian
    $dailyStats = [
        'bookings' => Booking::whereDate('created_at', today())->count(),
        'revenue' => Payment::whereDate('created_at', today())->sum('amount'),
    ];
    
    // Kirim ke admin
    Mail::to('admin@kampungkopicamp.com')->send(new DailyReport($dailyStats));
})->dailyAt('06:00');
```

### 3. Verifikasi Scheduler Berjalan

#### Test Manual
```bash
# Jalankan scheduler sekali untuk test
php artisan schedule:run

# Lihat daftar scheduled tasks
php artisan schedule:list

# Output akan menampilkan:
# 0 2 * * *  php artisan backup:run ......... Next Due: 10 hours from now
# 0 */6 * * * Payment Reminder ............... Next Due: 3 hours from now
```

#### Monitoring Scheduler
```bash
# Buat log file untuk monitoring
touch storage/logs/scheduler.log

# Update crontab dengan logging
* * * * * cd /path/to/kampungkopicamp && php artisan schedule:run >> /path/to/kampungkopicamp/storage/logs/scheduler.log 2>&1

# Monitor real-time
tail -f storage/logs/scheduler.log
```

### 4. Scheduled Tasks untuk Project Ini

Buat file: `app/Console/Kernel.php` dan pastikan berisi:

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Booking;
use App\Mail\PaymentReminder;
use App\Mail\PaymentExpired;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // 1. Expire booking yang tidak dibayar dalam 24 jam
        $schedule->call(function () {
            $expiredBookings = Booking::where('status', 'pending')
                ->where('created_at', '<', now()->subHours(24))
                ->get();
            
            foreach ($expiredBookings as $booking) {
                $booking->update(['status' => 'expired']);
                
                // Kirim email notifikasi
                try {
                    Mail::to($booking->email)->send(new PaymentExpired($booking));
                } catch (\Exception $e) {
                    \Log::error('Failed to send expired email: ' . $e->getMessage());
                }
            }
            
            \Log::info('Expired ' . $expiredBookings->count() . ' bookings');
        })->hourly()->name('expire-bookings');

        // 2. Kirim reminder pembayaran (4 jam sebelum expired)
        $schedule->call(function () {
            $reminderBookings = Booking::where('status', 'pending')
                ->whereBetween('created_at', [
                    now()->subHours(20),
                    now()->subHours(19)
                ])
                ->get();
            
            foreach ($reminderBookings as $booking) {
                try {
                    Mail::to($booking->email)->send(new PaymentReminder($booking));
                } catch (\Exception $e) {
                    \Log::error('Failed to send reminder: ' . $e->getMessage());
                }
            }
            
            \Log::info('Sent ' . $reminderBookings->count() . ' payment reminders');
        })->hourly()->name('payment-reminders');

        // 3. Cleanup old notifications (> 30 hari)
        $schedule->call(function () {
            \DB::table('notifications')
                ->where('created_at', '<', now()->subDays(30))
                ->delete();
            
            \Log::info('Cleaned up old notifications');
        })->daily()->name('cleanup-notifications');

        // 4. Generate daily report untuk admin
        $schedule->call(function () {
            $stats = [
                'date' => today()->toDateString(),
                'bookings' => Booking::whereDate('created_at', today())->count(),
                'confirmed' => Booking::whereDate('created_at', today())->where('status', 'confirmed')->count(),
                'revenue' => \DB::table('payments')
                    ->whereDate('created_at', today())
                    ->where('status', 'success')
                    ->sum('amount'),
            ];
            
            \Log::info('Daily Stats: ' . json_encode($stats));
            
            // Uncomment untuk kirim email ke admin
            // Mail::to('admin@kampungkopicamp.com')->send(new DailyReport($stats));
        })->dailyAt('06:00')->name('daily-report');

        // 5. Cleanup Laravel logs (keep 14 days)
        $schedule->command('log:clear')->daily()->name('cleanup-logs');

        // 6. Database optimization
        $schedule->call(function () {
            \DB::statement('OPTIMIZE TABLE bookings');
            \DB::statement('OPTIMIZE TABLE payments');
            \DB::statement('OPTIMIZE TABLE booking_items');
            
            \Log::info('Database optimized');
        })->weekly()->sundays()->at('03:00')->name('optimize-database');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
```

### 5. Custom Artisan Commands (Optional)

Untuk tugas yang lebih kompleks, buat custom command:

```bash
# Generate command
php artisan make:command CleanupExpiredBookings
```

```php
<?php
// app/Console/Commands/CleanupExpiredBookings.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class CleanupExpiredBookings extends Command
{
    protected $signature = 'bookings:cleanup-expired';
    protected $description = 'Cleanup expired bookings and send notifications';

    public function handle()
    {
        $this->info('Starting cleanup...');
        
        $expired = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->get();
        
        $count = $expired->count();
        
        foreach ($expired as $booking) {
            $booking->update(['status' => 'expired']);
        }
        
        $this->info("Cleaned up {$count} expired bookings");
        
        return Command::SUCCESS;
    }
}
```

Kemudian jadwalkan di `Kernel.php`:
```php
$schedule->command('bookings:cleanup-expired')->hourly();
```

### 6. Queue Workers (Background Jobs)

Untuk proses yang berat (email, report generation), gunakan queue:

```bash
# Install Supervisor (Linux)
sudo apt install supervisor

# Buat config
sudo nano /etc/supervisor/conf.d/kampungkopi-worker.conf
```

```ini
[program:kampungkopi-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/kampungkopicamp/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/kampungkopicamp/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Start worker
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kampungkopi-worker:*

# Check status
sudo supervisorctl status
```

### 7. Monitoring & Debugging

#### Check Cron is Running
```bash
# Linux - Check cron service
sudo systemctl status cron

# View cron logs
sudo tail -f /var/log/syslog | grep CRON

# List current user's crontab
crontab -l
```

#### Laravel Scheduler Log
```bash
# Monitor scheduler activity
tail -f storage/logs/scheduler.log

# Check Laravel application log
tail -f storage/logs/laravel.log
```

#### Test Scheduled Tasks
```bash
# Run scheduler manually
php artisan schedule:run

# Run specific command
php artisan bookings:cleanup-expired

# Test with verbose output
php artisan schedule:run -v
```

### 8. Production Checklist

- [ ] Cron job setup dan berjalan setiap menit
- [ ] `php artisan schedule:list` menampilkan semua tasks
- [ ] Test manual: `php artisan schedule:run`
- [ ] Monitor logs: `tail -f storage/logs/scheduler.log`
- [ ] Queue workers running (jika menggunakan queue)
- [ ] Email notifications terkirim
- [ ] Booking expired otomatis setelah 24 jam
- [ ] Database optimization berjalan mingguan

### 9. Troubleshooting Scheduler

#### Scheduler tidak jalan:
```bash
# 1. Cek cron service
sudo systemctl status cron

# 2. Cek permission
ls -la /path/to/kampungkopicamp/artisan

# 3. Test manual
php artisan schedule:run

# 4. Cek crontab
crontab -l

# 5. Add logging
* * * * * cd /path/to/kampungkopicamp && php artisan schedule:run >> /tmp/scheduler.log 2>&1
```

#### Tasks tidak execute:
```bash
# 1. Cek timezone di .env
APP_TIMEZONE=Asia/Makassar

# 2. Cek timezone server
date
timedatectl

# 3. Cek scheduled tasks list
php artisan schedule:list

# 4. Run dengan verbose
php artisan schedule:run -vvv
```

---

## 🔌 Third-Party Services

### 1. Midtrans Payment Gateway
- [ ] Switch from **Sandbox** to **Production** environment
- [ ] Update credentials in `.env`
- [ ] Test payment flow with real transaction
- [ ] Configure webhook URL: `https://yourdomain.com/midtrans/notification`
- [ ] Whitelist your server IP in Midtrans dashboard
- [ ] Set up payment notification handling

**Midtrans Production Setup:**
1. Login to https://dashboard.midtrans.com/
2. Switch to Production mode
3. Go to Settings → Access Keys
4. Copy Production Server Key and Client Key
5. Update `.env` file
6. Go to Settings → Notification URL
7. Set: `https://yourdomain.com/midtrans/notification`

### 2. Email Service
Choose one provider:

**Option 1: Gmail SMTP** (Good for testing, may have limits)
- Enable 2FA on Google Account
- Create App-Specific Password
- Use in `.env` MAIL_PASSWORD

**Option 2: Mailgun** (Recommended)
- Sign up at mailgun.com
- Verify your domain
- Add DNS records (SPF, DKIM)
- Get API credentials

**Option 3: SendGrid**
- Sign up at sendgrid.com
- Verify sender identity
- Create API key

### 3. Google Maps API (for Contact Section)
- [ ] Create API key at Google Cloud Console
- [ ] Restrict API key by HTTP referrer
- [ ] Enable Maps JavaScript API and Places API

---

## 📊 Monitoring & Logging

### 1. Error Tracking - Laravel Telescope (Development Only)
If you want error tracking in production, use external services:

**Recommended Services:**
- **Sentry.io** (Free tier available)
- **Bugsnag**
- **Rollbar**

### 2. Application Monitoring
```bash
# Install Laravel Horizon for queue monitoring (optional)
composer require laravel/horizon
php artisan horizon:install
php artisan horizon:publish

# Access at: https://yourdomain.com/horizon
```

### 3. Server Monitoring
**Free Tools:**
- **UptimeRobot** - Monitor uptime (free 50 monitors)
- **Google Analytics** - Track visitor behavior
- **Cloudflare Analytics** - Traffic analysis

### 4. Log Rotation
```bash
# Configure logrotate
sudo nano /etc/logrotate.d/kampungkopi

/path/to/kampungkopicamp/storage/logs/*.log {
    daily
    rotate 14
    compress
    delaycompress
    notifempty
    missingok
    create 0640 www-data www-data
}
```

### 5. Application Health Check
Create monitoring endpoint:
```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
    ]);
});
```

---

## 💾 Backup Strategy

### 1. Database Backups
- **Frequency**: Daily at 2 AM
- **Retention**: 30 days
- **Location**: Off-server storage (AWS S3, Google Cloud, etc.)

### 2. File Backups
```bash
# Create backup script
nano /home/scripts/backup-files.sh

#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/backups/files"
APP_DIR="/path/to/kampungkopicamp"

mkdir -p $BACKUP_DIR

# Backup storage directory
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz $APP_DIR/storage/app/public

# Keep only last 30 days
find $BACKUP_DIR -name "storage_*.tar.gz" -mtime +30 -delete

# Make executable
chmod +x /home/scripts/backup-files.sh

# Add to crontab (daily at 3 AM)
0 3 * * * /home/scripts/backup-files.sh
```

### 3. Automated Backup Service
Consider using:
- **Laravel Backup Package** (spatie/laravel-backup)
- **Server backup** (Cloudways, Forge built-in)
- **AWS S3** versioning

---

## ✅ Post-Deployment Tasks

### 1. Immediate Checks (First Hour)
- [ ] Test homepage loads correctly
- [ ] Test user registration
- [ ] Test login functionality
- [ ] Test booking flow from start to finish
- [ ] Test payment with small amount (Rp 10,000)
- [ ] Verify email notifications are sent
- [ ] Check admin panel access
- [ ] Test all reports generate correctly
- [ ] Verify SSL certificate is working (HTTPS)
- [ ] Test on mobile devices

### 2. First 24 Hours
- [ ] Monitor error logs: `tail -f storage/logs/laravel.log`
- [ ] Check database performance
- [ ] Monitor server resources (CPU, RAM, Disk)
- [ ] Verify scheduled tasks are running
- [ ] Test payment webhook from Midtrans

### 3. First Week
- [ ] Review application logs daily
- [ ] Check backup success
- [ ] Monitor user feedback
- [ ] Test all user-reported issues
- [ ] Update documentation if needed

### 4. Ongoing Maintenance
- [ ] Weekly security updates: `composer update`
- [ ] Monthly review of error logs
- [ ] Quarterly performance optimization
- [ ] Regular backup testing (restore test)

---

## 🚨 Troubleshooting

### Common Issues & Solutions

#### 1. White Screen / 500 Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Common fixes:
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### 2. Database Connection Error
```bash
# Verify credentials
php artisan tinker
>>> DB::connection()->getPdo();

# Check .env file
cat .env | grep DB_

# Test MySQL connection
mysql -u username -p -h hostname database_name
```

#### 3. Storage Files Not Loading
```bash
# Recreate symbolic link
php artisan storage:link

# Check permissions
ls -la public/storage
ls -la storage/app/public
```

#### 4. Midtrans Webhook Not Working
- Check Midtrans dashboard for notification logs
- Verify webhook URL is correct
- Check server firewall allows Midtrans IPs
- Review `storage/logs/laravel.log` for webhook errors

#### 5. Emails Not Sending
```bash
# Test email configuration
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('your-email@example.com')->subject('Test'); });

# Check mail queue
php artisan queue:work --once
```

#### 6. Performance Issues
```bash
# Clear all caches
php artisan optimize:clear

# Re-optimize
php artisan optimize

# Check slow queries
# Enable MySQL slow query log in my.cnf
```

---

## 📞 Emergency Contacts

### Key Personnel
- **Developer**: [Your Name] - [Email/Phone]
- **Server Admin**: [Name] - [Email/Phone]
- **Business Owner**: [Name] - [Email/Phone]

### Service Providers
- **Hosting Provider**: [Provider Name] - [Support URL/Phone]
- **Domain Registrar**: [Registrar] - [Support Contact]
- **Midtrans Support**: https://midtrans.com/support
- **Email Service**: [Provider Support]

---

## 📝 Deployment Checklist Summary

### Pre-Launch
- [ ] All testing completed
- [ ] Production `.env` configured
- [ ] SSL certificate installed
- [ ] Database migrated and seeded
- [ ] Storage permissions set
- [ ] Assets compiled
- [ ] Caching enabled
- [ ] Backups configured
- [ ] Monitoring setup
- [ ] Payment gateway switched to production
- [ ] Cron job configured (Laravel Scheduler)
- [ ] Queue workers running (if using queues)
- [ ] Scheduled tasks tested

### Launch Day
- [ ] Deploy code to server
- [ ] Run migrations
- [ ] Clear and rebuild cache
- [ ] Test critical flows
- [ ] Monitor logs for errors
- [ ] Announce launch

### Post-Launch
- [ ] Monitor performance
- [ ] Address user feedback
- [ ] Daily log review
- [ ] Backup verification

---

## 🎉 Production Launch Command Sequence

```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm ci
npm run build

# 3. Run migrations
php artisan migrate --force

# 4. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 5. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Create storage link
php artisan storage:link

# 7. Set permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# 8. Setup Cron Job (One-time setup)
# Edit crontab
crontab -e
# Add this line:
# * * * * * cd /path/to/kampungkopicamp && php artisan schedule:run >> /dev/null 2>&1

# 9. Verify scheduler
php artisan schedule:list

# 10. Test scheduler manually
php artisan schedule:run

# 11. Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
# or
sudo systemctl restart apache2

# 12. Start queue worker (if using Supervisor)
sudo supervisorctl restart kampungkopi-worker:*

# 13. Monitor logs
tail -f storage/logs/laravel.log
```

### Quick Verification Commands
```bash
# Check application is running
curl -I https://yourdomain.com

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Check scheduled tasks
php artisan schedule:list

# Check storage link
ls -la public/storage

# Check permissions
ls -la storage/

# Check queue workers (if using)
sudo supervisorctl status

# Monitor real-time logs
tail -f storage/logs/laravel.log
```

---

## 📚 Additional Resources

- [Laravel Deployment Documentation](https://laravel.com/docs/10.x/deployment)
- [Midtrans Documentation](https://docs.midtrans.com/)
- [Laravel Security Best Practices](https://laravel.com/docs/10.x/security)
- [PHP Production Best Practices](https://www.php.net/manual/en/tutorial.php)

---

## 🔄 Version History

- **v1.0.0** - Initial Production Release - December 2025

---

**Last Updated**: December 1, 2025  
**Author**: Development Team  
**Status**: Ready for Production Deployment

---

> ⚠️ **IMPORTANT**: Keep this document updated with any changes to the production environment. Review and update quarterly.

> 🔒 **SECURITY**: Never commit sensitive credentials to git. Use environment variables and secure secret management.

> 💡 **TIP**: Test the entire deployment process in a staging environment first before going to production.
