const db = require('../models/db');

// Get all products
exports.getAll = (req, res) => {
  db.query('SELECT * FROM Productos', (err, results) => {
    if (err) return res.status(500).json({ error: err });
    res.json(results);
  });
};

// Get one product
exports.getOne = (req, res) => {
  const id = req.params.id;
  db.query('SELECT * FROM Productos WHERE id = ?', [id], (err, result) => {
    if (err) return res.status(500).json({ error: err });
    res.json(result[0]);
  });
};

// Create product
exports.create = (req, res) => {
  const { nombre, precio } = req.body;
  db.query('INSERT INTO Productos (nombre, precio) VALUES (?, ?)', [nombre, precio], (err, result) => {
    if (err) return res.status(500).json({ error: err });
    res.json({ id: result.insertId, nombre, precio });
  });
};

// Update product
exports.update = (req, res) => {
  const { nombre, precio } = req.body;
  const id = req.params.id;
  db.query('UPDATE Productos SET nombre = ?, precio = ? WHERE id = ?', [nombre, precio, id], (err) => {
    if (err) return res.status(500).json({ error: err });
    res.json({ id, nombre, precio });
  });
};

// Delete product
exports.delete = (req, res) => {
  const id = req.params.id;
  db.query('DELETE FROM Productos WHERE id = ?', [id], (err) => {
    if (err) return res.status(500).json({ error: err });
    res.json({ message: 'Product deleted' });
  });
};