<?php
// backend/controllers/BorrowingController.php

require_once __DIR__ . '/../config/database.php';

class BorrowingController
{
    // ================================
    // RIWAYAT PINJAM PER MEMBER (+SEARCH)
    // ================================
    public static function getHistoryByMember(int $mem_id, ?string $keyword = null) {
        global $mysqli;

        $keyword = trim($keyword ?? '');

        // SQL dasar
        $sql = "
            SELECT 
                br.Brw_ID,
                b.Book_ID,
                b.Title,
                b.Category,
                IFNULL(ba.Authors, '') AS Authors,
                br.Brw_Date,
                br.Due_Date,
                br.Return_Date,
                br.Brw_Status,
                b.File_URL
            FROM borrowing br
            JOIN book b 
                ON br.Book_ID = b.Book_ID
            LEFT JOIN (
                SELECT 
                    Book_ID,
                    GROUP_CONCAT(Author SEPARATOR ', ') AS Authors
                FROM book_author
                GROUP BY Book_ID
            ) ba ON ba.Book_ID = b.Book_ID
            WHERE br.Mem_ID = ?
        ";

        // Jika ada keyword, tambahkan filter LIKE
        $params = [];
        $types  = 'i';         // mem_id = int
        $params[] = $mem_id;

        if ($keyword !== '') {
            $sql .= "
                AND (
                    CAST(br.Brw_ID AS CHAR) LIKE ?
                    OR b.Book_ID             LIKE ?
                    OR b.Title               LIKE ?
                    OR b.Category            LIKE ?
                    OR IFNULL(ba.Authors,'') LIKE ?
                )
            ";
            $like = '%' . $keyword . '%';
            $types  .= 'sssss';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $sql .= " ORDER BY br.Brw_Date DESC";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }

    // ================================
    // MEMBER MENGEMBALIKAN BUKU
    // ================================
    public static function memberReturn(int $brw_id, int $mem_id): string {
        global $mysqli;

        $sql = "
            SELECT Book_ID
            FROM borrowing
            WHERE Brw_ID = ?
              AND Mem_ID = ?
              AND Brw_Status = 'Borrowed'
              AND Return_Date IS NULL
            LIMIT 1
        ";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ii', $brw_id, $mem_id);
        $stmt->execute();
        $stmt->bind_result($book_id);

        if (!$stmt->fetch()) {
            $stmt->close();
            return 'Data peminjaman tidak valid atau sudah dikembalikan.';
        }
        $stmt->close();

        $return_date = date('Y-m-d');

        // update borrowing
        $stmt = $mysqli->prepare("
            UPDATE borrowing
            SET Return_Date = ?, Brw_Status = 'Returned'
            WHERE Brw_ID = ?
        ");
        $stmt->bind_param('si', $return_date, $brw_id);
        $stmt->execute();
        $stmt->close();

        // tambah stok buku
        $stmt = $mysqli->prepare("UPDATE book SET Stock = Stock + 1 WHERE Book_ID = ?");
        $stmt->bind_param('s', $book_id);
        $stmt->execute();
        $stmt->close();

        return 'Pengembalian buku berhasil. Terima kasih.';
    }
}
