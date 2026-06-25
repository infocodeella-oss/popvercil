<?php

require_once "functions.php";

$conn = mysqli_connect('localhost', 'root', '', 'popcorn');
mysqli_set_charset($conn, "utf8mb4");

header('Content-Type: application/json; charset=utf-8');


if ((empty($_REQUEST['want']) || !isset($_REQUEST['want'])) && $_SERVER['REQUEST_METHOD'] === 'GET') {

    echo json_encode(
        ["result" => "Must Enter Want"]
    );

} elseif ((!empty($_REQUEST['want']) || isset($_REQUEST['want'])) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // ========================== //
    // ========= Movies ========= //
    // ========================== //

    $want = $_REQUEST['want'];

    # Get All Movies
    if ($want == "movies") {

        $limit = $_REQUEST['limit'];

        if (!isset($limit) || empty($limit)) {
            echo json_encode(
                ["result" => "Should Enter Limit"]
            );
        } else {

            $query = "SELECT * FROM `movies` LIMIT $limit";
            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {

                $singleRowData = [];

                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }
    }

    // Search Movies
    if ($want == 'search_movies') {

        $search = @$_REQUEST['search'];

        if (!isset($search) || empty($search)) {
            echo json_encode(
                ["result" => "Search Text Is Required"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE title LIKE '%$search%' LIMIT 20";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }

    // Filter Movies
    if ($want == 'filter_movies') {

        $filter = @$_REQUEST['filter'];
        $limit = @$_REQUEST['limit'] ? $_REQUEST['limit']: 20;

        if (!isset($filter) || empty($filter)) {
            echo json_encode(
                ["result" => "filter Is Required Like This (افلام انمي)"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE category LIKE '%$filter%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['category'] = $row['category'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }
    }

    
    // ========================== //
    // ========= Series ========= //
    // ========================== //

    # Get All Series
    if ($want == "series") {

        $limit = $_REQUEST['limit'];

        if (!isset($limit) || empty($limit)) {
            echo json_encode(
                ["result" => "Should Enter Limit"]
            );
        } else {

            $query = "SELECT * FROM `series` LIMIT $limit";
            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {

                $singleRowData = [];

                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }
    }

    // Search Series
    if ($want == 'search_series') {

        $search = @$_REQUEST['search'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($search) || empty($search)) {
            echo json_encode(
                ["result" => "Search Text Is Required"]
            );
        } else {

            $query = "SELECT * FROM series WHERE title LIKE '%$search%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {

                $singleRowData = [];

                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                    "isLast" => str_contains($row['title'], 'والاخيرة')
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }


    // ========================== //
    // ========== Actor ========= //
    // ========================== //

    // Search Actor
    if ($want == 'search_actor') {

        $actor = @$_REQUEST['actor'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($actor) || empty($actor)) {
            echo json_encode(
                ["result" => "Actor Is Required"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE actors LIKE '%$actor%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['type'] = "فيلم";
                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            $querySeries = "SELECT * FROM series WHERE actors LIKE '%$actor%' LIMIT $limit";

            $rowsSeries = mysqli_query($conn, $querySeries);

            while ($row = $rowsSeries->fetch_assoc()) {

                $singleRowData = [];
                
                $singleRowData['type'] = "مسلسل";
                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                    "isLast" => str_contains($row['title'], 'والاخيرة')
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }

    // ========================== //
    // ========= Language ======= //
    // ========================== //

    // Search Language
    if ($want == 'search_language') {

        $language = @$_REQUEST['language'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($language) || empty($language)) {
            echo json_encode(
                ["result" => "language Is Required"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE language LIKE '%$language%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['type'] = "فيلم";
                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            $querySeries = "SELECT * FROM series WHERE language LIKE '%$language%' LIMIT $limit";

            $rowsSeries = mysqli_query($conn, $querySeries);

            while ($row = $rowsSeries->fetch_assoc()) {

                $singleRowData = [];
                
                $singleRowData['type'] = "مسلسل";
                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                    "isLast" => str_contains($row['title'], 'والاخيرة')
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }

    // ========================== //
    // =========== Year ========= //
    // ========================== //

    // Search Language
    if ($want == 'search_year') {

        $year = @$_REQUEST['year'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($year) || empty($year)) {
            echo json_encode(
                ["result" => "year Is Required"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE year LIKE '%$year%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['type'] = "فيلم";
                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            $querySeries = "SELECT * FROM series WHERE year LIKE '%$year%' LIMIT $limit";

            $rowsSeries = mysqli_query($conn, $querySeries);

            while ($row = $rowsSeries->fetch_assoc()) {

                $singleRowData = [];
                
                $singleRowData['type'] = "مسلسل";
                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                    "isLast" => str_contains($row['title'], 'والاخيرة')
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }

    // ========================== //
    // =========== Type ========= //
    // ========================== //

    // Search Type
    if ($want == 'movies_type') {

        $type = @$_REQUEST['type'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($type) || empty($type)) {
            echo json_encode(
                ["result" => "type Is Required (دراما, رعب, غموض)"]
            );
        } else {

            $query = "SELECT * FROM movies WHERE types LIKE '%$type%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];

                $singleRowData['type'] = "فيلم";
                $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['duration'] = $row['duration'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }

    if ($want == 'series_type') {

        $type = @$_REQUEST['type'];
        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        if (!isset($type) || empty($type)) {
            echo json_encode(
                ["result" => "type Is Required (دراما, رعب, غموض)"]
            );
        } else {

            $query = "SELECT * FROM series WHERE types LIKE '%$type%' LIMIT $limit";

            $rows = mysqli_query($conn, $query);

            $result = [];
            while ($row = $rows->fetch_assoc()) {
                $singleRowData = [];
                
                $singleRowData['type'] = "مسلسل";
                $singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

                $singleRowData['season'] = [
                    "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                    "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
                ];
                $singleRowData['episode'] = [
                    "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                    "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                    "isLast" => str_contains($row['title'], 'والاخيرة')
                ];
                $singleRowData['cover'] = $row['cover'];
                $singleRowData['story'] = $row['story'];
                $singleRowData['types'] = $row['types'];
                $singleRowData['actors'] = $row['actors'];
                $singleRowData['country'] = $row['country'];
                $singleRowData['language'] = $row['language'];
                $singleRowData['year'] = (int) $row['year'];
                $singleRowData['quality'] = $row['quality'];
                $singleRowData['rate'] = (float) $row['rate'];
                $singleRowData['downloads'] = [
                    "q1080" => $row['download_1080'],
                    "q720" => $row['download_720'],
                    "q480" => $row['download_480'],
                    "q240" => $row['download_240'],
                ];

                $result[] = $singleRowData;

            }

            echo json_encode(
                ["result" => $result]
            );

        }

    }


    
    // ========================== //
    // ========== Recent ======== //
    // ========================== //

    // Search Type
    if ($want == 'recent') {

        $limit = @$_REQUEST['limit'] ? @$_REQUEST['limit']: 20;

        $query = "SELECT * FROM movies ORDER BY created_at DESC LIMIT $limit";

        $rows = mysqli_query($conn, $query);

        $result = [];
        while ($row = $rows->fetch_assoc()) {
            $singleRowData = [];

            $singleRowData['type'] = "فيلم";
            $singleRowData['title'] = trim(str_replace(['فيلم', 'مترجم اون لاين - توب سينما'], '', $row['title']));
            $singleRowData['cover'] = $row['cover'];
            $singleRowData['story'] = $row['story'];
            $singleRowData['types'] = $row['types'];
            $singleRowData['actors'] = $row['actors'];
            $singleRowData['duration'] = $row['duration'];
            $singleRowData['year'] = (int) $row['year'];
            $singleRowData['quality'] = $row['quality'];
            $singleRowData['language'] = $row['language'];
            $singleRowData['rate'] = (float) $row['rate'];
            $singleRowData['downloads'] = [
                "q1080" => $row['download_1080'],
                "q720" => $row['download_720'],
                "q480" => $row['download_480'],
                "q240" => $row['download_240'],
            ];

            $result[] = $singleRowData;

        }

        $querySeries = "SELECT * FROM series ORDER BY created_at DESC LIMIT $limit";

        $rowsSeries = mysqli_query($conn, $querySeries);

        while ($row = $rowsSeries->fetch_assoc()) {
            $singleRowData = [];
            
            @$singleRowData['type'] = "مسلسل";
            @$singleRowData['title'] = trim(explode("الموسم", explode("مسلسل", $row['title'])[1])[0]);

            @$singleRowData['season'] = [
                "number" => arabicTextToNumber(trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0])),
                "text" => trim(explode('الحلقة ', explode('الموسم', $row['title'])[1])[0]),
            ];
            @$singleRowData['episode'] = [
                "number" => (int) trim(explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]),
                "text" => numberToArabicText(trim(str_replace('والاخيرة', '', explode('مترجمة', explode('الحلقة', $row['title'])[1])[0]))),
                "isLast" => str_contains($row['title'], 'والاخيرة')
            ];
            @$singleRowData['cover'] = $row['cover'];
            @$singleRowData['story'] = $row['story'];
            @$singleRowData['types'] = $row['types'];
            @$singleRowData['actors'] = $row['actors'];
            @$singleRowData['country'] = $row['country'];
            @$singleRowData['language'] = $row['language'];
            @$singleRowData['year'] = (int) $row['year'];
            @$singleRowData['quality'] = $row['quality'];
            @$singleRowData['rate'] = (float) $row['rate'];
            @$singleRowData['downloads'] = [
                "q1080" => $row['download_1080'],
                "q720" => $row['download_720'],
                "q480" => $row['download_480'],
                "q240" => $row['download_240'],
            ];

            $result[] = $singleRowData;

        }

        echo json_encode(
            ["result" => $result]
        );


    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
        echo json_encode(["error" => "Invalid JSON data"]);
        exit;
    }

    $into          = $data['into'] ?? '';
    $title         = trim($data['title'] ?? '');
    $rate          = $data['rate'] ?? '';
    $story         = $data['story'] ?? '';
    $types         = $data['types'] ?? '';
    $quality       = $data['quality'] ?? '';
    $duration      = $data['duration'] ?? '';
    $year          = $data['year'] ?? '';
    $language      = $data['language'] ?? '';
    $category      = $data['category'] ?? '';
    $actors        = $data['actors'] ?? '';
    $cover         = $data['cover'] ?? '';
    $download_1080 = $data['download_1080'] ?? '';
    $download_720  = $data['download_720'] ?? '';
    $download_480  = $data['download_480'] ?? '';
    $download_240  = $data['download_240'] ?? '';
    $movie_url     = $data['movie_url'] ?? '';
    $episode_url   = $data['episode_url'] ?? '';

    if (empty($title)) {
        echo json_encode(["error" => "The 'title' field is required and cannot be empty"]);
        exit; 
    }

    if ($into === 'movies') {
        $sql = "INSERT IGNORE INTO `movies` 
                (`title`,`rate`,`story`,`types`,`quality`,`duration`,`year`,`language`,`category`,`actors`,`cover`,`download_1080`,`download_720`,`download_480`,`download_240`, `movie_url`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
                $title, $rate, $story, $types, $quality, $duration, $year, $language, 
                $category, $actors, $cover, $download_1080, $download_720, $download_480, $download_240, $movie_url
            );
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["result" => "Done Added Movie: " . $title]);
            } else {
                echo json_encode(["error" => "Failed to insert movie: " . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        }

    } elseif ($into === 'series') {
        $sql = "INSERT IGNORE INTO `series` 
                (`title`,`rate`,`story`,`types`,`quality`,`year`,`language`,`actors`,`cover`,`download_1080`,`download_720`,`download_480`,`download_240`, `episode_url`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssssssss", 
                $title, $rate, $story, $types, $quality, $year, $language, 
                $actors, $cover, $download_1080, $download_720, $download_480, $download_240, $episode_url
            );
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["result" => "Done Added Series: " . $title]);
            } else {
                echo json_encode(["error" => "Failed to insert series: " . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(["error" => "Invalid 'into' type specified"]);
    }
}


