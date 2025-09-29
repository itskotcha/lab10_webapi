<h1>Lab 10 – Web API</h1>

<hr>

<h2>ข้อมูลนักศึกษา</h2>
<table border="1" cellspacing="0" cellpadding="8">
  <tr>
    <th>ชื่อจริง</th>
    <th>รหัสนักศึกษา</th>
    <th>GitHub Username</th>
    <th>อีเมล</th>
  </tr>
  <tr>
    <td>นางสาวกชพร วงศ์ใหญ่</td>
    <td>67543210067-4</td>
    <td>itskotcha</td>
    <td>kotchaporn_wo67@live.rmutl.ac.th</td>
  </tr>
</table>

<hr>

<h2>รายละเอียดโปรเจ็กต์</h2>
<p>โปรเจ็กต์นี้เป็นการสร้าง <b>RESTful Web API</b> สำหรับจัดการข้อมูลสินค้า (<code>products</code>) โดยใช้ภาษา <b>PHP</b> เชื่อมต่อกับฐานข้อมูล <b>MySQL</b> ผ่าน <b>XAMPP</b> และส่งข้อมูลในรูปแบบ <b>JSON</b> เพื่อรองรับการทำงาน CRUD (Create, Read, Update, Delete)</p>

<p>รูปแบบการทำงานคล้ายกับ <a href="https://fakestoreapi.com/docs#tag/Products" target="_blank">FakeStoreAPI (Products)</a></p>

<hr>

<h2>โครงสร้างโปรเจ็กต์</h2>
<pre>
lab10-webapi/
├── api/
│   ├── .htaccess
│   ├── config.php
│   ├── helpers.php
│   └── products.php
├── db.sql
└── README.md
</pre>

<hr>

<h2>ขั้นตอนการติดตั้งและใช้งาน</h2>
<ol>
  <li><b>เปิด XAMPP</b><br>Start <code>Apache</code> และ <code>MySQL</code></li>

  <li><b>คัดลอกโฟลเดอร์โปรเจ็กต์ไปไว้ใน htdocs</b><br>
  <code>/Applications/XAMPP/htdocs/lab10-webapi</code> (macOS) <br>
  หรือ <code>C:\xampp\htdocs\lab10-webapi</code> (Windows)</li>

  <li><b>นำเข้าฐานข้อมูล</b> ผ่าน <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a><br>
    - คลิกแท็บ <b>Import</b><br>
    - เลือกไฟล์ <code>db_mariadb_friendly.sql</code><br>
    - กด <b>Go</b><br>
    จะได้ฐานข้อมูลชื่อ <code>lab10_webapi</code> และตาราง <code>products</code> พร้อมข้อมูล 20 แถว
  </li>

  <li><b>ตรวจสอบการเชื่อมต่อฐานข้อมูล</b><br>
  เปิดไฟล์ <code>api/config.php</code> ตรวจสอบให้แน่ใจว่าข้อมูลถูกต้อง:
  <pre>
  $DB_HOST = '127.0.0.1';
  $DB_NAME = 'lab10_webapi';
  $DB_USER = 'root';
  $DB_PASS = '';
  </pre>
  </li>

  <li><b>ทดสอบ API</b> ผ่าน Postman หรือ Browser<br>
  <ul>
    <li>ดูสินค้าทั้งหมด: <code>GET http://localhost/lab10-webapi/api/products</code></li>
    <li>ดูสินค้ารายการเดียว: <code>GET http://localhost/lab10-webapi/api/products?id=1</code></li>
    <li>เพิ่มสินค้าใหม่ (POST)</li>
  </ul>
  </li>
</ol>

<hr>

<h2>การใช้งาน API</h2>

<h3>1. แสดงสินค้าทั้งหมด (GET)</h3>
<pre>
GET http://localhost/lab10-webapi/api/products
</pre>

<h3>2. แสดงสินค้ารายการเดียว (GET by ID)</h3>
<pre>
GET http://localhost/lab10-webapi/api/products?id=1
</pre>

<h3>3. เพิ่มสินค้าใหม่ (POST)</h3>
<pre>
POST http://localhost/lab10-webapi/api/products
Content-Type: application/json

{
  "title": "New Tee",
  "price": 15.99,
  "description": "Nice tee",
  "category": "clothing",
  "image": "https://picsum.photos/seed/new/400/400",
  "rating": { "rate": 4.1, "count": 10 }
}
</pre>

<h3>4. แก้ไขสินค้าทั้งหมด (PUT)</h3>
<pre>
PUT http://localhost/lab10-webapi/api/products?id=1
Content-Type: application/json

{
  "title": "Updated Product",
  "price": 19.99,
  "description": "Updated description",
  "category": "clothing",
  "image": "https://picsum.photos/seed/update/400/400",
  "rating": { "rate": 4.5, "count": 200 }
}
</pre>

<h3>5. แก้ไขบางฟิลด์ (PATCH)</h3>
<pre>
PATCH http://localhost/lab10-webapi/api/products?id=1
Content-Type: application/json

{
  "price": 17.49,
  "rating": { "count": 222 }
}
</pre>

<h3>6. ลบสินค้า (DELETE)</h3>
<pre>
DELETE http://localhost/lab10-webapi/api/products?id=1
</pre>

<hr>

<h2>ผลลัพธ์ (ตัวอย่าง)</h2>
<p>Response ที่ได้จะอยู่ในรูปแบบ JSON เช่น:</p>
<pre>
{
  "id": 21,
  "title": "New Tee",
  "price": 15.99,
  "description": "Nice tee",
  "category": "clothing",
  "image": "https://picsum.photos/seed/new/400/400",
  "rating": {
    "rate": 4.1,
    "count": 10
  }
}
</pre>

<hr>

<h2>ภาพประกอบ (Screenshots)</h2>

<ul>
  <li>
    <p><b>GET /products</b> – แสดงสินค้าทั้งหมด</p>
    <img src="image/Get all products.png" alt="Get all products" width="700">
  </li>

  <li>
    <p><b>GET /products?id=1</b> – แสดงสินค้ารายการเดียว</p>
    <img src="image/Get a single product.png" alt="Get a single product" width="700">
  </li>

  <li>
    <p><b>POST /products</b> – เพิ่มสินค้าใหม่</p>
    <img src="image/Add a new product.png" alt="Add a new product" width="700">
  </li>

  <li>
    <p><b>PUT /products?id=1</b> – แก้ไขข้อมูลสินค้า</p>
    <img src="image/Update a product.png" alt="Update a product" width="700">
  </li>

  <li>
    <p><b>DELETE /products?id=1</b> – ลบสินค้า</p>
    <img src="image/Delete a product.png" alt="Delete a product" width="700">
  </li>
</ul>


<hr>

<h2>วิธีใช้งาน</h2>
<p><b>1. Clone repository</b></p>
<pre>
git clone git@github.com:itskotcha/lab10_webapi.git
