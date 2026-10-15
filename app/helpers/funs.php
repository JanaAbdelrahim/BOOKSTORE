<?php
function pr()
{
    echo '<pre>';
    print_r("");
    echo '</pre>';
}
function showPagination(int $totalPages, int $currentPage, string $paginationName)
{
    $htmlPagination = "";

    if ($totalPages <= 1) {
        return "";
    }

    $prevPage = $currentPage === 1 ? $totalPages : $currentPage - 1;
    $prevDisabledClass = $currentPage === 1 ? 'disabled' : '';

    $htmlPagination .= "
        <li class='page-item'>
            <button class='page-link {$prevDisabledClass}' onclick=\"changePage({$prevPage},'{$paginationName}')\">Previous</button>
        </li>";

    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = $currentPage === $i ? ' active' : '';
        $htmlPagination .= "
            <li class='page-item'><button class='page-link {$activeClass}' onclick=\"changePage({$i},'{$paginationName}')\">{$i}</button></li>
        ";
    }

    $nextPage = $currentPage === $totalPages ? 1 : $currentPage + 1;
    $nextDisabledClass = $currentPage === $totalPages ? 'disabled' : '';

    $htmlPagination .= "
        <li class='page-item'>
            <button class='page-link {$nextDisabledClass}' onclick=\"changePage({$nextPage},'{$paginationName}')\">Next</button>
        </li>";


    return $htmlPagination;
}
