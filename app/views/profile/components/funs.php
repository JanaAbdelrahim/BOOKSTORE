<?php 
function preparePagination(array $data, string $types) 
{ 

    if (!empty($data)) { 
        $preLI = ''; 
        $pages = ceil((int)($data['total']) / 10); 
        $href = route('/profile'); 
        $prev = ($data['currentPage'] > 1) ? $data['currentPage'] - 1 : 1; 
        $next = ($data['currentPage'] < $pages) ? $data['currentPage'] + 1 : $pages; 
        $isdis_next = ($next != $data['currentPage']) ? '' : 'disabled'; 
        $isdis_prev = ($data['currentPage'] != 1) ? '' : 'disabled'; 

        for ($i = 1; $i <= $pages; $i++) { 
            $isactive = ($i == $data['currentPage']) ? "active" : ""; 

            $preLI .= " 
                <li class='page-item'>
                    <a class='page-link {$isactive}' href='{$href}?{$types}-page={$i}'>
                        $i
                    </a>
                </li>
            "; 
        } 

        echo "
            <nav aria-label='Page navigation example '> 
                <ul class='pagination m-2'> 

                    <li class='page-item'>
                        <a class='page-link {$isdis_prev}' href='{$href}?{$types}-page={$prev}'>
                            Previous
                        </a>
                    </li> 

                    {$preLI} 

                    <li class='page-item'>
                        <a class='page-link {$isdis_next}' href='{$href}?{$types}-page={$next}'>
                            Next
                        </a>
                    </li> 

                </ul> 
            </nav>
        "; 

    } else { 
        echo ""; 
    } 
}