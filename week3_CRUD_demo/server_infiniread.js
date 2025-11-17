// server.js
const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2/promise');

const app = express();
app.use(bodyParser.json());

// === konfigurasi DB: ===
const dbConfig = {
  host: 'localhost',
  user: ' ', 
  password: ' ', 
  database: 'infiniread',
  port: 3306 
};

// helper untuk koneksi
async function getConn() {
  return await mysql.createConnection(dbConfig);
}

/* ---------------------------------------------------------
   1) STAFF
--------------------------------------------------------- */

// GET all staff
app.get('/api/staff', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute('SELECT * FROM Staff');
  await conn.end();
  res.json(rows);
});

// GET staff by ID
app.get('/api/staff/:id', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute(
    'SELECT * FROM Staff WHERE Staff_ID = ?', 
    [req.params.id]
  );
  await conn.end();

  if (rows.length === 0)
    return res.status(404).json({ error: 'Staff not found' });

  res.json(rows[0]);
});

// CREATE 1 or many staff
app.post('/api/staff', async (req, res) => {
  const conn = await getConn();
  const data = req.body;

  try {
    // multiple insert
    if (Array.isArray(data)) {
      const values = data.map(d => [d.Staff_Name, d.Position]);
      await conn.query(
        'INSERT INTO Staff (Staff_Name, Position) VALUES ?', 
        [values]
      );
      return res.status(201).json({ 
        message: `${data.length} staff inserted` 
      });
    }

    // single insert
    const { Staff_Name, Position } = data;
    if (!Staff_Name || !Position)
      return res.status(400).json({ error: 'Missing fields' });

    const [result] = await conn.execute(
      'INSERT INTO Staff (Staff_Name, Position) VALUES (?, ?)',
      [Staff_Name, Position]
    );

    res.status(201).json({
      Staff_ID: result.insertId,
      Staff_Name,
      Position
    });

  } finally {
    await conn.end();
  }
});

// UPDATE (PUT)
app.put('/api/staff/:id', async (req, res) => {
  const { Staff_Name, Position } = req.body;

  if (!Staff_Name || !Position)
    return res.status(400).json({ error: 'Missing fields' });

  const conn = await getConn();
  const [result] = await conn.execute(
    `UPDATE Staff SET Staff_Name=?, Position=? WHERE Staff_ID=?`,
    [Staff_Name, Position, req.params.id]
  );
  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: 'Staff not found' });

  res.json({ message: 'Staff updated (PUT)' });
});

// UPDATE (PATCH)
app.patch('/api/staff/:id', async (req, res) => {
  const updates = req.body;

  if (Object.keys(updates).length === 0)
    return res.status(400).json({ error: 'No fields to update' });

  const fields = Object.keys(updates);
  const values = Object.values(updates);
  const sqlSet = fields.map(f => `${f}=?`).join(', ');

  const conn = await getConn();
  const [result] = await conn.execute(
    `UPDATE Staff SET ${sqlSet} WHERE Staff_ID=?`,
    [...values, req.params.id]
  );
  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: 'Staff not found' });

  res.json({ message: 'Staff updated (PATCH)', updates });
});

// DELETE 1 staff
app.delete('/api/staff/:id', async (req, res) => {
  const conn = await getConn();

  // Cegah FK error → hapus borrowings dulu
  await conn.execute('DELETE FROM Borrowing WHERE Staff_ID=?', [
    req.params.id
  ]);

  // Baru hapus staff
  const [result] = await conn.execute(
    'DELETE FROM Staff WHERE Staff_ID=?',
    [req.params.id]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: 'Staff not found' });

  res.json({ success: true });
});

// DELETE many staff
app.delete('/api/staff', async (req, res) => {
  const { ids } = req.body;

  if (!Array.isArray(ids) || ids.length === 0)
    return res.status(400).json({ error: 'Provide ids: [1,2,...]' });

  const conn = await getConn();

  // delete related borrowings
  await conn.query('DELETE FROM Borrowing WHERE Staff_ID IN (?)', [ids]);

  // delete staff
  await conn.query('DELETE FROM Staff WHERE Staff_ID IN (?)', [ids]);
  await conn.end();

  res.json({ message: `${ids.length} staff deleted` });
});

/* ---------------------------------------------------------
   2) MEMBER
--------------------------------------------------------- */

/* -----------------------------------
   GET all members
----------------------------------- */
app.get('/api/members', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute('SELECT * FROM Member');
  await conn.end();
  res.json(rows);
});

/* -----------------------------------
   GET member by ID
----------------------------------- */
app.get('/api/members/:id', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute(
    'SELECT * FROM Member WHERE Mem_ID = ?',
    [req.params.id]
  );
  await conn.end();

  if (rows.length === 0)
    return res.status(404).json({ error: 'Member not found' });

  res.json(rows[0]);
});

/* ---------------------------------------------------------
   CREATE MEMBER (1 atau BANYAK)
--------------------------------------------------------- */
app.post('/api/members', async (req, res) => {
  const conn = await getConn();
  const data = req.body;

  try {
    // === INSERT MANY ===
    if (Array.isArray(data)) {
      const values = data.map(m => [
        m.Full_Name,
        m.Gender,
        m.Date_of_Birth,
        m.Email,
        m.City || null,
        m.Province || null,
        m.Staff_ID
      ]);

      await conn.query(
        `INSERT INTO Member 
         (Full_Name, Gender, Date_of_Birth, Email, City, Province, Staff_ID)
         VALUES ?`,
        [values]
      );

      return res.status(201).json({
        message: `${data.length} members inserted`
      });
    }

    // === INSERT ONE ===
    const {
      Full_Name, Gender, Date_of_Birth,
      Email, City, Province, Staff_ID
    } = data;

    if (!Full_Name || !Gender || !Date_of_Birth || !Email || !Staff_ID)
      return res.status(400).json({ error: 'Missing required fields' });

    const [result] = await conn.execute(
      `INSERT INTO Member 
      (Full_Name, Gender, Date_of_Birth, Email, City, Province, Staff_ID)
      VALUES (?, ?, ?, ?, ?, ?, ?)`,
      [Full_Name, Gender, Date_of_Birth, Email, City, Province, Staff_ID]
    );

    res.status(201).json({ Mem_ID: result.insertId });

  } finally {
    await conn.end();
  }
});

/* ---------------------------------------------------------
   PUT 
--------------------------------------------------------- */
app.put('/api/members/:id', async (req, res) => {
  const {
    Full_Name, Gender, Date_of_Birth,
    Email, City, Province, Staff_ID
  } = req.body;

  if (!Full_Name || !Gender || !Date_of_Birth || !Email || !Staff_ID)
    return res.status(400).json({ error: 'Missing required fields' });

  const conn = await getConn();

  const [result] = await conn.execute(
    `UPDATE Member SET
      Full_Name=?, Gender=?, Date_of_Birth=?, Email=?,
      City=?, Province=?, Staff_ID=?
     WHERE Mem_ID=?`,
    [
      Full_Name, Gender, Date_of_Birth, Email,
      City, Province, Staff_ID, req.params.id
    ]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: 'Member not found' });

  res.json({
    message: 'Member updated (PUT)',
    Mem_ID: req.params.id
  });
});

/* ---------------------------------------------------------
   PATCH — PARTIAL UPDATE MEMBER
--------------------------------------------------------- */
app.patch('/api/members/:id', async (req, res) => {
  const updates = req.body;

  if (Object.keys(updates).length === 0)
    return res.status(400).json({ error: 'No fields to update' });

  const fields = Object.keys(updates);
  const values = Object.values(updates);
  const setClause = fields.map(f => `${f}=?`).join(", ");

  const conn = await getConn();

  const [result] = await conn.execute(
    `UPDATE Member SET ${setClause} WHERE Mem_ID=?`,
    [...values, req.params.id]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: 'Member not found' });

  res.json({
    message: 'Member updated (PATCH)',
    updated: updates
  });
});

/* ---------------------------------------------------------
   DELETE 1 MEMBER 
   + otomatis hapus semua borrowings yg berkaitan
--------------------------------------------------------- */
app.delete('/api/members/:id', async (req, res) => {
  const conn = await getConn();

  try {
    // hapus borrowing dulu
    await conn.execute(
      `DELETE FROM Borrowing WHERE Mem_ID=?`,
      [req.params.id]
    );

    // hapus member
    const [result] = await conn.execute(
      `DELETE FROM Member WHERE Mem_ID=?`,
      [req.params.id]
    );

    if (result.affectedRows === 0)
      return res.status(404).json({ error: 'Member not found' });

    res.json({
      success: true,
      message: 'Member & related borrowings deleted'
    });

  } finally {
    await conn.end();
  }
});

/* ---------------------------------------------------------
   DELETE MANY MEMBERS
--------------------------------------------------------- */
app.delete('/api/members', async (req, res) => {
  const { ids } = req.body;

  if (!Array.isArray(ids) || ids.length === 0)
    return res.status(400).json({ error: "Provide ids: [1,2,...]" });

  const conn = await getConn();

  await conn.query(`DELETE FROM Member WHERE Mem_ID IN (?)`, [ids]);

  await conn.end();

  res.json({ message: `${ids.length} members deleted` });
});

/* ============================================================
   3) BOOK 
   ============================================================
   FITUR:
   - Max_Borrowdays otomatis berdasarkan Pages:
        <=100 pages  → '3'
        101–300      → '7'
        >300         → '14'
   - Create 1 atau banyak
   - PUT & PATCH update
   - Delete 1 → otomatis hapus authors
   - Delete banyak → hapus authors juga
   - Fix ENUM error (pastikan Max_Borrowdays dikirim sebagai STRING!)
   ============================================================*/

function autoBorrowDays(pages) {
  if (pages <= 100) return '3';
  if (pages <= 300) return '7';
  return '14';
}

/* ---------------- GET ALL BOOKS ---------------- */
app.get('/api/books', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute('SELECT * FROM Book');
  await conn.end();
  res.json(rows);
});

/* ---------------- GET BOOK BY ID ---------------- */
app.get('/api/books/:id', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute(
    'SELECT * FROM Book WHERE Book_ID = ?',
    [req.params.id]
  );
  await conn.end();

  if (rows.length === 0)
    return res.status(404).json({ error: "Book not found" });

  res.json(rows[0]);
});

/* ---------------- CREATE BOOK (1 atau banyak) ---------------- */
app.post('/api/books', async (req, res) => {
  const conn = await getConn();
  const data = req.body;

  try {
    // === INSERT BANYAK ===
    if (Array.isArray(data)) {
      const values = data.map(b => [
        b.Book_ID,
        b.Category,
        b.Title,
        b.ISBN,
        b.Pages,
        b.Pub_Year,
        b.Age_Rating,
        autoBorrowDays(b.Pages),   // ENUM ('3','7','14')
        b.Stock,
        b.Staff_ID
      ]);

      await conn.query(
        `INSERT INTO Book 
        (Book_ID, Category, Title, ISBN, Pages, Pub_Year, Age_Rating, Max_Borrowdays, Stock, Staff_ID)
        VALUES ?`,
        [values]
      );

      return res.status(201).json({ message: `${data.length} books inserted` });
    }

    // === INSERT 1 ===
    const {
      Book_ID, Category, Title, ISBN,
      Pages, Pub_Year, Age_Rating, Stock, Staff_ID
    } = data;

    await conn.execute(
      `INSERT INTO Book 
      (Book_ID, Category, Title, ISBN, Pages, Pub_Year, Age_Rating, Max_Borrowdays, Stock, Staff_ID)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [
        Book_ID,
        Category,
        Title,
        ISBN,
        Pages,
        Pub_Year,
        Age_Rating,
        autoBorrowDays(Pages),
        Stock,
        Staff_ID
      ]
    );

    res.status(201).json({ Book_ID });

  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Database error" });
  } finally {
    await conn.end();
  }
});

/* ---------------- UPDATE BOOK (PUT) ---------------- */
app.put('/api/books/:id', async (req, res) => {
  const {
    Category, Title, ISBN, Pages,
    Pub_Year, Age_Rating, Stock, Staff_ID
  } = req.body;

  const Max_Borrowdays = autoBorrowDays(Pages);

  const conn = await getConn();

  const [result] = await conn.execute(
    `UPDATE Book SET 
        Category=?, Title=?, ISBN=?, Pages=?, Pub_Year=?, Age_Rating=?, 
        Max_Borrowdays=?, Stock=?, Staff_ID=?
     WHERE Book_ID=?`,
    [
      Category, Title, ISBN, Pages, Pub_Year,
      Age_Rating, Max_Borrowdays, Stock, Staff_ID,
      req.params.id
    ]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: "Book not found" });

  res.json({ success: true });
});

/* ---------------- UPDATE BOOK (PATCH) ---------------- */
app.patch('/api/books/:id', async (req, res) => {
  const updates = req.body;

  // If Pages updated → auto-update Max_Borrowdays (ENUM)
  if (updates.Pages)
    updates.Max_Borrowdays = autoBorrowDays(updates.Pages);

  const fields = Object.keys(updates);
  const values = Object.values(updates);

  if (fields.length === 0)
    return res.status(400).json({ error: "No fields to update" });

  const sql = `
      UPDATE Book SET 
      ${fields.map(f => `${f}=?`).join(', ')} 
      WHERE Book_ID=?
  `;

  const conn = await getConn();
  const [result] = await conn.execute(sql, [...values, req.params.id]);
  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: "Book not found" });

  res.json({ success: true, updated: updates });
});

/* ---------------- DELETE 1 BOOK + AUTHORS ---------------- */
app.delete('/api/books/:id', async (req, res) => {
  const conn = await getConn();

  // delete authors first
  await conn.execute(
    `DELETE FROM Book_Author WHERE Book_ID = ?`,
    [req.params.id]
  );

  // delete book
  const [result] = await conn.execute(
    `DELETE FROM Book WHERE Book_ID = ?`,
    [req.params.id]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({ error: "Book not found" });

  res.json({ success: true });
});

/* ---------------- DELETE MANY BOOKS + AUTHORS ---------------- */
app.delete('/api/books', async (req, res) => {
  const { ids } = req.body;

  if (!Array.isArray(ids))
    return res.status(400).json({ error: "ids must be array" });

  const conn = await getConn();

  // delete authors
  await conn.query(
    `DELETE FROM Book_Author WHERE Book_ID IN (?)`,
    [ids]
  );

  // delete books
  await conn.query(
    `DELETE FROM Book WHERE Book_ID IN (?)`,
    [ids]
  );

  await conn.end();

  res.json({ message: `${ids.length} books deleted` });
});

/* ============================================================
   4) BOOK_AUTHOR 
   ============================================================
   FITUR:
   - GET semua author berdasarkan Book_ID
   - POST: tambah 1 atau banyak author
   - PUT: update author lama → author baru (full replace)
   - PATCH: update sebagian (khusus ubah nama author)
   - DELETE 1 author
   - DELETE banyak author
   Catatan:
   - Book_ID wajib ada di tabel Book
   - Tidak boleh ada duplikasi author pada buku yang sama
   ============================================================*/

/* ---------------- GET AUTHORS BY BOOK ID ---------------- */
app.get('/api/books/:id/authors', async (req, res) => {
  const conn = await getConn();
  const [rows] = await conn.execute(
    `SELECT Author FROM Book_Author WHERE Book_ID = ?`,
    [req.params.id]
  );

  await conn.end();
  res.json(rows.map(r => r.Author));
});

/* ---------------- ADD AUTHOR(S) ----------------
   Format Body:
   {
     "authors": ["A", "B", "C"]
   }
------------------------------------------------ */
app.post('/api/books/:id/authors', async (req, res) => {
  const { authors } = req.body;

  if (!Array.isArray(authors) || authors.length === 0)
    return res.status(400).json({ error: "authors must be a non-empty array" });

  const conn = await getConn();

  try {
    const values = authors.map(a => [a, req.params.id]);
    await conn.query(
      `INSERT IGNORE INTO Book_Author (Author, Book_ID)
       VALUES ?`,
      [values]
    );

    res.status(201).json({
      message: `${authors.length} author(s) inserted`,
      authors
    });
  } finally {
    await conn.end();
  }
});

/* ---------------- UPDATE AUTHORS (PUT FULL REPLACE) ----------------
   Mengganti SEMUA author lama dengan daftar baru.
   Body:
   {
     "authors": ["Author Baru 1", "Author Baru 2", ...]
   }
--------------------------------------------------------------------- */
app.put('/api/books/:id/authors', async (req, res) => {
  const { authors } = req.body;

  if (!Array.isArray(authors) || authors.length === 0) {
    return res.status(400).json({
      error: "authors must be a non-empty array"
    });
  }

  const conn = await getConn();

  try {
    // 1. Hapus semua author lama
    await conn.execute(
      `DELETE FROM Book_Author WHERE Book_ID = ?`,
      [req.params.id]
    );

    // 2. Insert semua author baru
    const values = authors.map(a => [a, req.params.id]);

    await conn.query(
      `INSERT INTO Book_Author (Author, Book_ID) VALUES ?`,
      [values]
    );

    res.json({
      message: "Authors fully replaced (PUT)",
      Book_ID: req.params.id,
      authors
    });

  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Database error" });
  } finally {
    await conn.end();
  }
});

/* ---------------- UPDATE AUTHOR (PATCH) ----------------
   Partial update—khusus update nama author
   Body:
   {
     "author": "Nama Lama",
     "new_author": "Nama Baru"
   }
-------------------------------------------------------- */
app.patch('/api/books/:id/authors', async (req, res) => {
  const { author, new_author } = req.body;

  if (!author)
    return res.status(400).json({ error: "author is required" });

  if (!new_author)
    return res.status(400).json({ error: "new_author is required" });

  const conn = await getConn();

  const [result] = await conn.execute(
    `UPDATE Book_Author
     SET Author = ?
     WHERE Book_ID = ? AND Author = ?`,
    [new_author, req.params.id, author]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({
      error: "Author not found for this book"
    });

  res.json({
    message: "Author updated (PATCH)",
    Book_ID: req.params.id,
    author_before: author,
    author_after: new_author
  });
});

/* ---------------- DELETE ONE AUTHOR ----------------
   Body:
   {
     "author": "Nama Author"
   }
----------------------------------------------------- */
app.delete('/api/books/:id/authors', async (req, res) => {
  const { author } = req.body;

  if (!author)
    return res.status(400).json({ error: "author is required" });

  const conn = await getConn();

  const [result] = await conn.execute(
    `DELETE FROM Book_Author
     WHERE Book_ID = ? AND Author = ?`,
    [req.params.id, author]
  );

  await conn.end();

  if (result.affectedRows === 0)
    return res.status(404).json({
      error: "Author not found"
    });

  res.json({
    success: true,
    deleted: author
  });
});

/* ---------------- DELETE MANY AUTHORS ----------------
   Body:
   {
     "authors": ["A", "B", "C"]
   }
-------------------------------------------------------- */
app.delete('/api/books/:id/authors/many', async (req, res) => {
  const { authors } = req.body;

  if (!Array.isArray(authors) || authors.length === 0)
    return res.status(400).json({ error: "authors must be a non-empty array" });

  const conn = await getConn();

  const [result] = await conn.query(
    `DELETE FROM Book_Author
     WHERE Book_ID = ? AND Author IN (?)`,
    [req.params.id, authors]
  );

  await conn.end();

  res.json({
    message: `${result.affectedRows} author(s) deleted`,
    deleted_authors: authors
  });
});

/* ============================================================
   5) BORROWING 
   ============================================================*/

const getTodayDatetime = () => {
  const now = new Date();
  return now.toISOString().slice(0, 19).replace("T", " ");
};

/* ---------------- CREATE BORROWING (1 atau banyak) ----------------  
   - Brw_Date otomatis NOW()
   - Status otomatis "Borrowed"
   - Due_Date otomatis (Brw_Date + Max_Borrowdays)
   - Stock -1 otomatis
------------------------------------------------------------------- */
app.post('/api/borrowings', async (req, res) => {
  const conn = await getConn();
  const data = req.body;

  try {
    // === INSERT MANY ===
    if (Array.isArray(data)) {
      for (const b of data) {
        await createBorrowing(conn, b);
      }
      return res.status(201).json({ message: `${data.length} borrowings inserted` });
    }

    // === INSERT ONE ===
    const result = await createBorrowing(conn, data);
    res.status(201).json(result);

  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "DB error" });
  } finally {
    await conn.end();
  }
});

// Helper function to insert 1 borrowing
async function createBorrowing(conn, body) {
  const { Staff_ID, Mem_ID, Book_ID } = body;

  // 1. Ambil Max_Borrowdays
  const [book] = await conn.execute(
    `SELECT Max_Borrowdays FROM Book WHERE Book_ID=?`,
    [Book_ID]
  );

  if (book.length === 0)
    throw new Error("Book not found");

  const maxDays = parseInt(book[0].Max_Borrowdays);

  // 2. Timestamp NOW()
  const Brw_Date = getTodayDatetime();

  // 3. Hitung Due_Date
  const dateObj = new Date(Brw_Date);
  dateObj.setDate(dateObj.getDate() + maxDays);
  const Due_Date = dateObj.toISOString().slice(0, 10);

  // 4. Kurangi stok
  const [stockResult] = await conn.execute(
    `UPDATE Book SET Stock = Stock - 1 
     WHERE Book_ID = ? AND Stock > 0`,
    [Book_ID]
  );

  if (stockResult.affectedRows === 0)
    throw new Error("Book out of stock");

  // 5. Insert Borrowing
  const [result] = await conn.execute(
    `INSERT INTO Borrowing
    (Brw_Date, Due_Date, Return_Date, Brw_Status, Staff_ID, Mem_ID, Book_ID)
     VALUES (?, ?, NULL, 'Borrowed', ?, ?, ?)`,
    [Brw_Date, Due_Date, Staff_ID, Mem_ID, Book_ID]
  );

  return { Brw_ID: result.insertId, Due_Date };
}

/* ---------------- GET ALL BORROWINGS ----------------  
   Menampilkan:
   - Informasi borrowing
   - Nama member
   - Judul buku
-----------------------------------------------------*/
app.get('/api/borrowings', async (req, res) => {
  const conn = await getConn();

  const [rows] = await conn.execute(
    `SELECT 
        b.Brw_ID,
        b.Brw_Date,
        b.Due_Date,
        b.Return_Date,
        b.Brw_Status,
        m.Full_Name AS Member_Name,
        bk.Title AS Book_Title,
        b.Mem_ID,
        b.Book_ID,
        b.Staff_ID
     FROM Borrowing b
     LEFT JOIN Member m ON b.Mem_ID = m.Mem_ID
     LEFT JOIN Book bk ON b.Book_ID = bk.Book_ID
     ORDER BY b.Brw_ID ASC`
  );

  await conn.end();
  res.json(rows);
});

/* ---------------- GET BORROWING BY ID ---------------- */
app.get('/api/borrowings/:id', async (req, res) => {
  const conn = await getConn();

  const [rows] = await conn.execute(
    `SELECT 
        b.Brw_ID,
        b.Brw_Date,
        b.Due_Date,
        b.Return_Date,
        b.Brw_Status,
        m.Full_Name AS Member_Name,
        bk.Title AS Book_Title,
        b.Mem_ID,
        b.Book_ID,
        b.Staff_ID
     FROM Borrowing b
     LEFT JOIN Member m ON b.Mem_ID = m.Mem_ID
     LEFT JOIN Book bk ON b.Book_ID = bk.Book_ID
     WHERE b.Brw_ID=?`,
    [req.params.id]
  );

  await conn.end();

  if (rows.length === 0)
    return res.status(404).json({ error: "Borrowing not found" });

  res.json(rows[0]);
});

/* ---------------- UPDATE BORROWING (PATCH) ----------------  
   - Jika PATCH Brw_Status="Returned":
       → Return_Date otomatis NOW()
       → Stock +1 
------------------------------------------------------------------- */
app.patch('/api/borrowings/:id', async (req, res) => {
  const updates = req.body;
  const conn = await getConn();

  // 1. Ambil borrowing lama
  const [rows] = await conn.execute(
    `SELECT * FROM Borrowing WHERE Brw_ID=?`,
    [req.params.id]
  );

  if (rows.length === 0)
    return res.status(404).json({ error: "Borrowing not found" });

  const old = rows[0];

  // 2. Jika update menjadi Returned
  if (updates.Brw_Status === "Returned" && old.Return_Date === null) {
    updates.Return_Date = getTodayDatetime();

    await conn.execute(
      `UPDATE Book SET Stock = Stock + 1 WHERE Book_ID=?`,
      [old.Book_ID]
    );
  }

  // 3. Patch builder
  const fields = Object.keys(updates);
  const values = Object.values(updates);

  if (fields.length === 0)
    return res.status(400).json({ error: "No fields to update" });

  const sql = `
      UPDATE Borrowing 
      SET ${fields.map(f => `${f}=?`).join(", ")}
      WHERE Brw_ID=?
  `;

  await conn.execute(sql, [...values, req.params.id]);
  await conn.end();

  res.json({ success: true, updated: updates });
});

/* ---------------- DELETE 1 BORROWING ----------------  
   - Jika borrowing masih aktif → Stock +1
------------------------------------------------------------------- */
app.delete('/api/borrowings/:id', async (req, res) => {
  const conn = await getConn();

  const [rows] = await conn.execute(
    `SELECT * FROM Borrowing WHERE Brw_ID=?`,
    [req.params.id]
  );

  if (rows.length === 0)
    return res.status(404).json({ error: "Borrowing not found" });

  const br = rows[0];

  // Jika belum dikembalikan → balikin stok
  if (!br.Return_Date) {
    await conn.execute(
      `UPDATE Book SET Stock = Stock + 1 WHERE Book_ID=?`,
      [br.Book_ID]
    );
  }

  await conn.execute(
    `DELETE FROM Borrowing WHERE Brw_ID=?`,
    [req.params.id]
  );

  await conn.end();
  res.json({ success: true });
});

/* ---------------- DELETE MANY BORROWINGS ---------------- */
app.delete('/api/borrowings', async (req, res) => {
  const { ids } = req.body;

  if (!Array.isArray(ids))
    return res.status(400).json({ error: "ids must be array" });

  const conn = await getConn();

  for (const id of ids) {
    const [rows] = await conn.execute(
      `SELECT * FROM Borrowing WHERE Brw_ID=?`,
      [id]
    );

    if (rows.length === 0) continue;

    const br = rows[0];

    if (!br.Return_Date) {
      await conn.execute(
        `UPDATE Book SET Stock = Stock + 1 WHERE Book_ID=?`,
        [br.Book_ID]
      );
    }

    await conn.execute(`DELETE FROM Borrowing WHERE Brw_ID=?`, [id]);
  }

  await conn.end();

  res.json({ message: `${ids.length} borrowings deleted` });
});

/* ---------------------------------------------------------
   START SERVER
--------------------------------------------------------- */

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`InfiniRead API running on port ${PORT}`);
});

