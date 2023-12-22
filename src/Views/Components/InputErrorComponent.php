<?php
if (isset($errors[$input]))
{
    echo "<ul>";

    foreach ($errors[$input] as $key => $value) {
?>

        <li class="field-required">
            <?= $value; ?>
        </li>

<?php
    }

    echo "</ul>";
}
?>