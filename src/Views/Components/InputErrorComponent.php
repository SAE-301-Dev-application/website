<?php
if (isset($errors[$input]))
{
    echo "<ul>";

    foreach ($errors[$input] as $key => $value)
    {
?>

        <li class="input-error">
            <?= $value; ?>
        </li>

<?php
    }

    echo "</ul>";
}
?>