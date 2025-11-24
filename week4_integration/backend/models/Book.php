<?php
// backend/models/Book.php
class Book
{
    public static function all(mysqli $db): array {
        $res = $db->query("SELECT * FROM book ORDER BY Title");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function authorMap(mysqli $db): array {
        $map = [];
        $sql = "
            SELECT Book_ID, GROUP_CONCAT(Author SEPARATOR ', ') AS Authors
            FROM book_author
            GROUP BY Book_ID
        ";
        $res = $db->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $map[$row['Book_ID']] = $row['Authors'];
            }
        }
        return $map;
    }

    public static function changeStock(mysqli $db, string $bookId, int $delta): bool {
        $stmt = $db->prepare("UPDATE book SET Stock = Stock + ? WHERE Book_ID = ?");
        $stmt->bind_param('is', $delta, $bookId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
