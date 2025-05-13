<h1>Interests Calculator v.1</h1>
<p>This project consist in a simple interests calculator for compound interests. It works as a handy tool to keep track of personal finances in case borrowing is not stranger for you.</p>
<p>It was made for my personal use and I plan to expand it base in my needs. I may later migrate it to Laravel for scalability and increased features.</p>
<h2>Directoy Structure:</h2>
<pre>
Interests-Calculator/
├── assets/
│   ├── css/
│   │   └── stylesheet.css
│   ├── images/
│   │   ├── bg_alt_1.png
│   │   ├── bg_alt_2.png
│   │   ├── doodles-background.png
│   │   ├── doodles-background-2.png
│   │   └── patterns.png
│   └── js/
│       ├── ajax-unset.js
│       ├── all_payments.js
│       ├── script.js
│       └── validation.js
├── config/
│   └── model.sql
├── html/
│   └── navbar
├── php/
│   ├── actions/
│   │   ├── add_account.php
│   │   ├── add_payment.php
│   │   ├── create_csv.php
│   │   ├── delete_account.php
│   │   ├── delete_account_def.php
│   │   ├── delete_payment.php
│   │   ├── download_all_csv.php
│   │   └── function_payment_history.php
│   ├── connection.php
│   └── unset.php
├── history.php
├── index.php
├── LICENSE.txt
├── README.md
└── trash_bin.php
</pre>
<h2>Technologies:</h2>
<ul>
  <li>PHP 8.2.12</li>
  <li>XAMPP (Apache + MySQL + PHP)</li>
  <li>MySQL 15.1</li>
  <li>HTML/CSS/JavaScript</li>
</ul>
<h2>Installation:</h2>
<ol>
  <li>Clone the repository: <code>git clone https://github.com/Ginazai/Interests-Calculator.git</code></li>
   <li>Copy the folder to the directory <code>htdocs/</code> in XAMPP.</li>
   <li>Create the database in phpMyAdmin using the <code>config/model.sql</code> file.</li>
   <li><code>Start</code> Apache and MySQL from XAMPP control panel.</li>
   <li>Access the application at <code>http://localhost/Interests-Calculator/index.html</code>.</li>
</ol>
<h2>Use case diagram:</h2>
[pending]
<h2>Project State:</h2>
<table>
  <tr>
    <th>Current</th>
    <th>Future</th>
  </tr>
  <tr>
    <td>Handling basic CRUD operations towards payments.</td>
    <td>Implement fixed interests.</td>
  </tr>

  <tr>
    <td>Perform interests calculations based in the data stored and the cycle selected (every 15/30 days).</td>
    <td>Receipt generation in <code>.pdf</code> format.</td>
  </tr>

  <tr>
    <td>Perform Automatic dates calculations based on cycle.</td>
    <td><code>.csv</code> importing support.</td>
  </tr>
  <tr>
  	<td>the current data model consist in the structure above (pending image).</td>
  	<td>Improve <code>.csv</code> data outputs for managing accountabiliy</td>
  </tr>
  <tr>
  	<td></td>
    <td>Better <code>.csv</code> integration to support more accounting features.</td>
  </tr>
  <tr>
    <td></td>
    <td>implement more efficient queries throughout code.</td>
  </tr>
  <tr>
    <td></td>
    <td>Better <code>.csv</code> integration to support more accounting features.</td>
  </tr>
</table>
<table>
  <tr>
    <th>Outside the scope of this version</th>
  </tr>
  <tr>
    <td><code>.csv</code> importing support.</td>
  </tr>
  <tr>
  	<td>Improve <code>.csv</code> data outputs for managing accountabiliy</td>
  </tr>
  <tr>
    <td>plan to implement view to automatically structure the data that the <code>.php</code> receives.</td>
  </tr>
  <tr>
    <td>If possible, interests could also be calculated automatically using a function or a store procedure or a combination of both.</td>
  </tr>
</table>
<h2>Gallery:</h2>
[pending]