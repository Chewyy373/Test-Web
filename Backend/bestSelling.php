<?php
include "db.php";

$sql = "
SELECT 
    m.id,
    m.item_name,
    m.image,
    SUM(
        JSON_EXTRACT(
            o.items,
            CONCAT(
                '$[', idx.idx, '].qty'
            )
        )
    ) AS total_qty
FROM orders o
JOIN menu m
JOIN (
    SELECT 0 AS idx UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
) AS idx
WHERE JSON_EXTRACT(o.items, CONCAT('$[', idx.idx, '].id')) = m.id
GROUP BY m.id
ORDER BY total_qty DESC
LIMIT 5
";

$res = $conn->query($sql);

$data = [];
while ($row = $res->fetch_assoc()) {
    if ($row['total_qty'] !== null)
        $data[] = $row;
}

echo json_encode($data);
?>
