<?php
// backend/models/Borrowing.php
class Borrowing
{
    public static function forMember(mysqli $db, int $memId): array {
        $sql = "
            SELECT 
                br.Brw_ID,
                b.Book_ID,
                b.Title,
                br.Brw_Date,
                br.Due_Date,
                br.Return_Date,
                br.Brw_Status
            FROM borrowing br
            JOIN book b ON br.Book_ID = b.Book_ID
            WHERE br.Mem_ID = ?
            ORDER BY br.Brw_Date DESC
        ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $memId);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public static function createForMember(
        mysqli $db,
        int $memId,
        string $bookId,
        int $staffId,
        int $maxDays
    ): bool {
        // cek stok
        $stmt = $db->prepare("SELECT Stock FROM book WHERE Book_ID = ?");
        $stmt->bind_param('s', $bookId);
        $stmt->execute();
        $stmt->bind_result($stock);
        if (!$stmt->fetch()) {
            $stmt->close();
            return false;
        }
        $stmt->close();
        if ($stock <= 0) return false;

        $brwDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime("+{$maxDays} days"));

        $stmt = $db->prepare("
            INSERT INTO borrowing
            (Brw_Date, Due_Date, Return_Date, Brw_Status, Staff_ID, Mem_ID, Book_ID)
            VALUES (?, ?, NULL, 'Borrowed', ?, ?, ?)
        ");
        $stmt->bind_param('ssiis', $brwDate, $dueDate, $staffId, $memId, $bookId);
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            Book::changeStock($db, $bookId, -1);
        }
        return $ok;
    }

    // mengembalikan book_id kalau sukses
    public static function returnForMember(mysqli $db, int $memId, int $brwId): ?string {
        $sql = "
            SELECT Book_ID
            FROM borrowing
            WHERE Brw_ID = ?
              AND Mem_ID = ?
              AND Brw_Status = 'Borrowed'
              AND Return_Date IS NULL
            LIMIT 1
        ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $brwId, $memId);
        $stmt->execute();
        $stmt->bind_result($bookId);
        if (!$stmt->fetch()) {
            $stmt->close();
            return null;
        }
        $stmt->close();

        $returnDate = date('Y-m-d');

        $stmt = $db->prepare("
            UPDATE borrowing
            SET Return_Date = ?, Brw_Status = 'Returned'
            WHERE Brw_ID = ?
        ");
        $stmt->bind_param('si', $returnDate, $brwId);
        $stmt->execute();
        $stmt->close();

        Book::changeStock($db, $bookId, +1);
        return $bookId;
    }

    // untuk halaman staff/borrowings.php
    public static function all(mysqli $db): array {
        $sql = "
            SELECT br.*, b.Title, m.Full_Name AS Member_Name, s.Staff_Name
            FROM borrowing br
            JOIN book b   ON br.Book_ID = b.Book_ID
            JOIN member m ON br.Mem_ID = m.Mem_ID
            LEFT JOIN staff s ON br.Staff_ID = s.Staff_ID
            ORDER BY br.Brw_Date DESC
        ";
        $res = $db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
