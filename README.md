## การติดตั้ง (Installation)

1. โคลนรีโพซิทอรี:
    ```bash
    git clone https://github.com/thelosechanathip/dashboard.git
    ```

2. เข้าไปยังไดเรกทอรีของโปรเจกต์:
    ```bash
    cd dashboard
    ```

3. ติดตั้งแพ็กเกจที่จำเป็น:
    ```bash
    npm install
    ```

## โครงสร้างไฟล์หลักๆ (File Structure)

```
/dashboard
|-- routes/web.php #เก็บการ routes ของ Program ทั้งหมด
|-- resources/views #เก็บการแสดงผลทั้งหมดของ Program
|-- app/Models #เก็บการทำงานของ BackEnd หรือเกี่ยวกับ Database
|-- app/Http/Controllers #เก็บการควมคุมการทำงานของ Program
```

## การใช้งาน (Usage)

1. เริ่มการทำงานของเซิร์ฟเวอร์:
   ```bash
   php artisan serve
   ```

## การกำหนดค่า (Configuration)

สร้างไฟล์ `.env` ในไดเรกทอรีหลักและกำหนดค่าต่อไปนี้:

```
# Database HoSXP
DB_CONNECTION=mysql
DB_HOST=root
DB_PORT=3306
DB_DATABASE=hos
DB_USERNAME=root
DB_PASSWORD=root

# Database Webserver
DB_CONNECTION_2=mysql
DB_HOST_2=root
DB_PORT_2=3306
DB_DATABASE_2=dashboard_setting
DB_USERNAME_2=root
DB_PASSWORD_2=root
```

## ความต้องการของระบบ (Requirements)

- Node.js (v22.14.0 หรือใหม่กว่า)
- MarieDB (v5.7 หรือใหม่กว่า)
- PHP (v8 หรือใหม่กว่า)

## การสนับสนุน (Support)

หากพบปัญหาหรือต้องการความช่วยเหลือ กรุณาเปิด Issue ใน GitHub repository

## ใบอนุญาต (License)

ลิขสิทธิ์ © 2025 - Dashboard