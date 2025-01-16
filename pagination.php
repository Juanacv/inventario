<?php 
    if ($totalPages > 1) { 
        $lastPage = ceil($currentPage/PAGESPERPAGINATION)*PAGESPERPAGINATION;
        $initPage = $lastPage - (PAGESPERPAGINATION-1);
    ?>
    <nav aria-label="Page navigation example" class="mt-1">
        <ul class="list-style-none flex">
            <li>
                <?php if ($currentPage == 1) { ?>
                <a class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-blue-500 transition-all duration-300 dark:text-blue-400">Anterior</a>
                <?php } else { ?>
                <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm font-medium text-blue-800 transition-all duration-300 hover:bg-neutral-700 hover:text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $prev; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?> ">Anterior</a>        
                <?php } ?>
            </li>
            <?php while ($initPage <= $lastPage) { 
                    if ($initPage > $totalPages) break;
                    if ($initPage == $currentPage) { 
                ?>
                <li aria-current="page">
                    <a class="relative block rounded bg-primary-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300" href="#!"><?php echo $initPage; ?><span class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]">(current)</span></a>
                </li>
                <?php } else { ?>
                <li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-sky-600 transition-all duration-300 hover:bg-neutral-700 hover:text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $initPage; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?>"><?php echo $initPage; ?></a>
                </li>
                <?php } ?>
            <?php   $initPage++; 
                    } ?>
            <li>
            <?php if ($currentPage == $totalPages) { ?>
                <a class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-blue-500 transition-all duration-300 dark:text-blue-400">Siguiente</a>
            <?php } else { ?>
                <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm font-medium text-blue-800 transition-all duration-300 hover:bg-neutral-700 hover:text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $next; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : "";?>">Siguiente</a>        
            <?php } ?>                                        
            </li>
        </ul>
    </nav>
<?php } ?>