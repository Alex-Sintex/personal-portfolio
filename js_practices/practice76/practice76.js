// Set up express server
const express = require("express");
const app = express();

app.set("port", 3000);
app.listen(3000);

// Set up mysql
let mysql = require("mysql2");

let connection = mysql.createConnection({
  host: "",
  user: "",
  password: "",
  database: "",
});

// Connect to the database
connection.connect();

// Insert a new row into the clients table
connection.query(
  'INSERT INTO clients VALUES (1, "Steve", 1 ,"0134567890", "Palo Alto")',
  function (error, results) {
    if (error) throw error;
    console.log(results);
  }
);

// Make a query to retrieve data from clients table
connection.query("SELECT * FROM clients", function (error, rows) {
  if (error) throw error;
  console.log(rows);
});

// Update a row in the clients table
connection.query(
  'UPDATE clients SET address = "No address" WHERE idClient = 1',
  function (error, results) {
    if (error) throw error;
    console.log(results);
  }
);

connection.query("SELECT * FROM clients", function (error, rows) {
  if (error) throw error;
  console.log(rows);
});

// Delete a row in the clients table
connection.query(
  "DELETE FROM clients WHERE idClient = 1",
  function (error, results) {
    if (error) throw error;
    console.log(results);
  }
);

connection.query("SELECT * FROM clients", function (error, rows) {
  if (error) throw error;
  console.log(rows);
});

// Close the database connection
connection.end();
