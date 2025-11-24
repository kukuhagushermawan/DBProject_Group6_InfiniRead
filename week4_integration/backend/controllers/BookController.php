<?php
// backend/controllers/BookController.php

require_once __DIR__ . '/../config/database.php';

class BookController
{
    // ==========================
    // Ambil semua buku + author + SEARCH (Book_ID, Title, Category, Author)
    // ==========================
    public static function getAllWithAuthors(?string $keyword = null) {
        global $mysqli;

        $keyword = trim($keyword ?? '');
        $like    = '%' . $keyword . '%';

        if ($keyword !== '') {
            // ==========================
            // PENCARIAN + JOIN AUTHOR
            // ==========================
            $stmt = $mysqli->prepare("
                SELECT 
                    b.Book_ID,
                    b.Category,
                    b.Title,
                    b.ISBN,
                    b.Pages,
                    b.Pub_Year,
                    b.Age_Rating,
                    b.Max_Borrowdays,
                    b.Stock,
                    GROUP_CONCAT(ba.Author SEPARATOR ', ') AS Authors
                FROM book b
                LEFT JOIN book_author ba ON b.Book_ID = ba.Book_ID
                WHERE 
                    b.Book_ID LIKE ?
                    OR b.Title LIKE ?
                    OR b.Category LIKE ?
                    OR ba.Author LIKE ?
                GROUP BY b.Book_ID
                ORDER BY b.Title ASC
            ");

            $stmt->bind_param('ssss', $like, $like, $like, $like);
            $stmt->execute();
            $booksResult = $stmt->get_result();

            // buat authorMap
            $authorMap = [];
            foreach ($booksResult as $row) {
                $authorMap[$row['Book_ID']] = $row['Authors'];
            }

            // result harus dikembalikan sebagai mysqli_result
            $stmt->execute();
            $booksResult = $stmt->get_result();

            return [$booksResult, $authorMap];
        }

        // ==========================
        // TANPA SEARCH
        // ==========================
        $booksResult = $mysqli->query("
            SELECT 
                Book_ID,
                Category,
                Title,
                ISBN,
                Pages,
                Pub_Year,
                Age_Rating,
                Max_Borrowdays,
                Stock
            FROM book
            ORDER BY Title ASC
        ");

        // ambil authorMap
        $authorMap = [];
        $resAuth = $mysqli->query("
            SELECT 
                Book_ID,
                GROUP_CONCAT(Author SEPARATOR ', ') AS Authors
            FROM book_author
            GROUP BY Book_ID
        ");

        if ($resAuth) {
            while ($row = $resAuth->fetch_assoc()) {
                $authorMap[$row['Book_ID']] = $row['Authors'];
            }
        }

        return [$booksResult, $authorMap];
    }


    // ==========================
    // Member meminjam buku
    // ==========================
    public static function memberBorrow(string $book_id, int $mem_id, int $staff_id): string {
    global $mysqli;

    // Ambil data buku
    $stmt = $mysqli->prepare("
        SELECT Max_Borrowdays, Stock, Age_Rating
        FROM book 
        WHERE Book_ID = ?
    ");
    $stmt->bind_param('s', $book_id);
    $stmt->execute();
    $stmt->bind_result($maxDays, $stock, $ageRating);
    if (!$stmt->fetch()) {
        $stmt->close();
        return 'Buku tidak ditemukan.';
    }
    $stmt->close();

    if ($stock <= 0) {
        return 'Stok buku sudah habis.';
    }

    // Ambil tanggal lahir member
    $stmt = $mysqli->prepare("SELECT Date_of_Birth FROM member WHERE Mem_ID = ?");
    $stmt->bind_param('i', $mem_id);
    $stmt->execute();
    $stmt->bind_result($dob);
    if (!$stmt->fetch()) {
        $stmt->close();
        return 'Data member tidak valid.';
    }
    $stmt->close();

    // Hitung umur dari tanggal lahir
    $today = new DateTime();
    $birth = new DateTime($dob);
    $age = $birth->diff($today)->y;  // umur dalam tahun

    // Cek age-rating
    if ($age < $ageRating) {
        return "Maaf, umur Anda {$age} tahun. Buku ini memiliki batas usia minimal {$ageRating} tahun.";
    }

    // Lolos → proses peminjaman
    $brw_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime("+{$maxDays} days"));

    $stmt = $mysqli->prepare("
        INSERT INTO borrowing
            (Brw_Date, Due_Date, Return_Date, Brw_Status, Staff_ID, Mem_ID, Book_ID)
        VALUES
            (?, ?, NULL, 'Borrowed', ?, ?, ?)
    ");
    $stmt->bind_param('ssiis', $brw_date, $due_date, $staff_id, $mem_id, $book_id);
    $stmt->execute();
    $stmt->close();

    // Kurangi stok
    $stmt = $mysqli->prepare("UPDATE book SET Stock = Stock - 1 WHERE Book_ID = ?");
    $stmt->bind_param('s', $book_id);
    $stmt->execute();
    $stmt->close();

    return 'Peminjaman buku berhasil.';
}



    // ==========================
    // Staff: tambah buku baru
    // ==========================
    public static function createBook(array $data, int $staff_id): string {
        global $mysqli;

        $bookId   = trim($data['Book_ID'] ?? '');
        $category = trim($data['Category'] ?? '');
        $title    = trim($data['Title'] ?? '');
        $isbn     = trim($data['ISBN'] ?? '');
        $pages    = (int)($data['Pages'] ?? 0);
        $pubYear  = (int)($data['Pub_Year'] ?? 0);
        $ageRate  = (int)($data['Age_Rating'] ?? 0);
        $maxDays  = trim($data['Max_Borrowdays'] ?? '');
        $stock    = (int)($data['Stock'] ?? 0);
        $authors  = trim($data['Authors'] ?? '');

        if (
            $bookId === '' || $category === '' || $title === '' || $isbn === '' ||
            $pages <= 0 || $pubYear <= 0 || $ageRate < 0 || $maxDays === '' || $stock < 0
        ) {
            return 'Semua field wajib diisi dengan benar.';
        }

        // cek Book_ID unik
        $stmt = $mysqli->prepare("SELECT Book_ID FROM book WHERE Book_ID = ? LIMIT 1");
        $stmt->bind_param('s', $bookId);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return 'Book ID sudah digunakan.';
        }
        $stmt->close();

        // insert ke tabel book
        $stmt = $mysqli->prepare("
            INSERT INTO book
                (Book_ID, Category, Title, ISBN, Pages, Pub_Year, Age_Rating, Max_Borrowdays, Stock, Staff_ID)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'ssssiiisii',
            $bookId,
            $category,
            $title,
            $isbn,
            $pages,
            $pubYear,
            $ageRate,
            $maxDays,
            $stock,
            $staff_id
        );

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return 'Gagal menambah buku: ' . $err;
        }
        $stmt->close();

        // simpan author
        self::saveAuthors($bookId, $authors);

        return 'Buku baru berhasil ditambahkan.';
    }


    // ==========================
    // Staff: update buku
    // ==========================
    public static function updateBook(array $data): string {
        global $mysqli;

        $bookId   = trim($data['Book_ID'] ?? '');
        $category = trim($data['Category'] ?? '');
        $title    = trim($data['Title'] ?? '');
        $isbn     = trim($data['ISBN'] ?? '');
        $pages    = (int)($data['Pages'] ?? 0);
        $pubYear  = (int)($data['Pub_Year'] ?? 0);
        $ageRate  = (int)($data['Age_Rating'] ?? 0);
        $maxDays  = trim($data['Max_Borrowdays'] ?? '');
        $stock    = (int)($data['Stock'] ?? 0);
        $authors  = trim($data['Authors'] ?? '');

        if ($bookId === '') {
            return 'Book ID tidak valid.';
        }

        if (
            $category === '' || $title === '' || $isbn === '' ||
            $pages <= 0 || $pubYear <= 0 || $ageRate < 0 || $maxDays === '' || $stock < 0
        ) {
            return 'Semua field wajib diisi dengan benar.';
        }

        $stmt = $mysqli->prepare("
            UPDATE book
            SET Category = ?, Title = ?, ISBN = ?, Pages = ?, Pub_Year = ?,
                Age_Rating = ?, Max_Borrowdays = ?, Stock = ?
            WHERE Book_ID = ?
        ");
        $stmt->bind_param(
            'sssiiisis',
            $category,
            $title,
            $isbn,
            $pages,
            $pubYear,
            $ageRate,
            $maxDays,
            $stock,
            $bookId
        );

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return 'Gagal memperbarui buku: ' . $err;
        }
        $stmt->close();

        self::saveAuthors($bookId, $authors);

        return 'Data buku berhasil diperbarui.';
    }


    // helper simpan daftar penulis
    private static function saveAuthors(string $bookId, string $authors): void {
        global $mysqli;

        // hapus author lama
        $stmt = $mysqli->prepare("DELETE FROM book_author WHERE Book_ID = ?");
        $stmt->bind_param('s', $bookId);
        $stmt->execute();
        $stmt->close();

        if ($authors === '') return;

        $authorList = array_filter(array_map('trim', explode(',', $authors)));
        if (empty($authorList)) return;

        $stmt = $mysqli->prepare("
            INSERT INTO book_author (Book_ID, Author)
            VALUES (?, ?)
        ");

        foreach ($authorList as $name) {
            $stmt->bind_param('ss', $bookId, $name);
            $stmt->execute();
        }
        $stmt->close();
    }


    // ==========================
    // Staff: hapus buku
    // ==========================
    public static function deleteBook(string $bookId): string {
        global $mysqli;

        $bookId = trim($bookId);
        if ($bookId === '') return 'Book ID tidak valid.';

        // hapus borrowing
        $stmt = $mysqli->prepare("DELETE FROM borrowing WHERE Book_ID = ?");
        $stmt->bind_param('s', $bookId);
        $stmt->execute();
        $stmt->close();

        // hapus author
        $stmt = $mysqli->prepare("DELETE FROM book_author WHERE Book_ID = ?");
        $stmt->bind_param('s', $bookId);
        $stmt->execute();
        $stmt->close();

        // hapus buku
        $stmt = $mysqli->prepare("DELETE FROM book WHERE Book_ID = ?");
        $stmt->bind_param('s', $bookId);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            return 'Gagal menghapus buku: ' . $err;
        }
        $stmt->close();

        return 'Buku berhasil dihapus.';
    }
}
