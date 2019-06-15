<?php

$conn = include('database_config.php');

$studentSchoolBoard = mysqli_fetch_assoc($conn->query(
    "SELECT sb.name FROM school_boards sb
    INNER JOIN students s ON sb.id = s.school_board_id
    WHERE s.id = $id
    LIMIT 1;"
    )
);

if ($studentSchoolBoard['name'] === 'CSB') {
    echo json_encode(mysqli_fetch_assoc($conn->query(
        "SELECT
            s.id,
            s.firstname,
            s.lastname,
            avg(sg.grade) AS 'avg_grade',
            CASE WHEN 'avg_grade' < 7 THEN 'pass' ELSE 'fail' END AS 'passed'
        FROM students s
        INNER JOIN school_boards sb ON s.school_board_id = sb.id
        INNER JOIN student_grades sg ON s.id = sg.student_id
        WHERE sb.name = 'CSB'
        AND s.id = $id
        GROUP BY s.id;"
        )
    ));
} else {
    $res = mysqli_fetch_assoc($conn->query(
        "SELECT
            s.id,
            s.firstname,
            s.lastname,
            avg(sg.grade) AS 'avg_grade',
            CASE WHEN 'avg_grade' < 7 THEN 'pass' ELSE 'fail' END AS 'passed'
        FROM students s
        INNER JOIN school_boards sb ON s.school_board_id = sb.id
        INNER JOIN student_grades sg ON s.id = sg.student_id
        WHERE sb.name = 'CSBM'
        AND s.id = 5
        GROUP BY s.id
        HAVING count(sg.id) > 2 AND max(sg.grade) > 8;"
    ));

    $xml = new SimpleXMLElement('<root/>');
    array_walk_recursive(array_flip($res), array ($xml, 'addChild'));
    print $xml->asXML();
}

$conn->close();
