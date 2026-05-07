<?php
declare(strict_types=1);

namespace App\Library\Config\View;
?>

<h2>Library Report</h2>

<p>Total Books: <?= $stats['books'] ?></p>
<p>Borrowed: <?= $stats['borrowed'] ?></p>
<p>Returned: <?= $stats['returned'] ?></p>
<p>Total Fines: <?= $stats['fines'] ?></p>