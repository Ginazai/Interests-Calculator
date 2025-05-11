<h1>Interests Calculator v.1</h1>
<p>This project consist in a simple interests calculator for compound interests. It works as a handy tool to keep track of personal finances in case borrowing is not stranger for you.</p>
<p>It was made for my personal use and I plan to expand it base in my needs. I may later migrate it to Laravel for scalability and increased features.</p>

<h2>Architecture</h2>

<h3>General Structure</h3>
<h2>State:</h2>
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
  	<td></td>
  	<td>Improve <code>.csv</code> data outputs for managing accountabiliy</td>
  </tr>
  <tr>
  	<td></td>
    <td>Better <code>.csv</code> integration to support more accounting features.</td>
  </tr>
</table>

<h3>Data model</h3>
<h2>State:</h2>
<ul>
	<li>[pending image]</li>
	<li><b>Current: </b>the current data model consist in the structure above (pending image).</li>
	<li><b>Future: </b>implement more efficient queries throughout code. plan to implement view to automatically structure the data that the <code>.php</code> receives.If possible, interests could also be calculated automatically using a function or a store procedure or a combination of both.</li>
</ul>
<p><b>Note: </b>work is being made to structure the project stages in tables for better presentation of the progress.</p>